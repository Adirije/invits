<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Client;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $locations = Location::all();

        return view('admin.events.create', compact('locations', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:191'],
            'tagLine' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'startDate' => ['bail', 'sometimes', 'nullable', 'date'],
            'endDate' => ['bail', 'sometimes', 'nullable', 'date', 'after:startDate'],
            'type' => ['bail', 'required', 'in:open,invite'],
            'budget' => ['bail', 'sometimes', 'nullable', 'numeric'],
            'location' => ['bail', 'sometimes', 'nullable', 'numeric', 'exists:locations,id'], //, 
            'client' => ['bail', 'required', 'numeric', 'exists:clients,id'],
            'content' => ['bail', 'sometimes', 'nullable', 'string'],
            'featureImage' => ['bail', 'sometimes', 'nullable', 'image'],
        ]);

        $event = new Event;

        $event->name = $request->name;
        $event->client_id = $request->client;
        $event->tagline = $request->tagLine;
        $event->budget = $request->budget;
        $event->type = $request->type;
        $event->desc = $request->content;
        $event->location_id = $request->location;
        $event->starts = Carbon::parse($request->startDate);
        $event->ends = Carbon::parse($request->endDate);
        $event->featured = $request->boolean('featured');
        $event->enabled = $request->boolean('enabled');
        $event->published = $request->boolean('published');
        $event->major = $request->boolean('major');
        $event->feature_img = $this->uploadFeatureImage($request, $event);

        if($event->major){
            Event::where('major', true)->update(['major' => false]);
            
            $event->enabled = true;
            $event->published = true;
        }
        
        $event->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Event saved successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));


        return \response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with(['client', 'tickets'])->findOrFail($id);

        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::with('client')->findOrFail($id);
        $clients = Client::all();
        $locations = Location::all();

        return view('admin.events.edit', compact('event', 'clients', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:191'],
            'tagLine' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'startDate' => ['bail', 'sometimes', 'nullable', 'date'],
            'endDate' => ['bail', 'sometimes', 'nullable', 'date', 'after:startDate'],
            'type' => ['bail', 'required', 'in:open,invite'],
            'budget' => ['bail', 'sometimes', 'nullable', 'numeric'],
            'location' => ['bail', 'sometimes', 'nullable', 'numeric', 'exists:locations,id'], //, 
            'client' => ['bail', 'required', 'numeric', 'exists:clients,id'],
            'content' => ['bail', 'sometimes', 'nullable', 'string'],
            'featureImage' => ['bail', 'sometimes', 'nullable', 'image'],
        ]);

        $event = Event::findOrFail($id);
        
        $event->name = $request->name;
        $event->client_id = $request->client;
        $event->tagline = $request->tagLine;
        $event->budget = $request->budget;
        $event->type = $request->type;
        $event->desc = $request->content;
        $event->location_id = $request->location;
        $event->starts = Carbon::parse($request->startDate);
        $event->ends = Carbon::parse($request->endDate);
        $event->major = $request->boolean('major');
        $event->featured = $request->boolean('featured');
        $event->enabled = $request->boolean('enabled');
        $event->published = $request->boolean('published');
        $event->feature_img = $this->uploadFeatureImage($request, $event);
        
        if($event->major){
            Event::where('major', true)->update(['major' => false]);

            $event->enabled = true;
            $event->published = true;
        }

        $event->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Event updated successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return \response()->json([], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $img = $this->removeStoragPath($event->feature_img);

        Storage::disk($this->disk())->delete($img);

        $event->delete();

        return response()->json([], 201);
    }

    
    protected function uploadFeatureImage($request, $event)
    {
        $dir = 'events';
        $img = str_starts_with($event->feature_img, "/storage/") ? substr($event->feature_img, 9) : $event->feature_img;

        if(! $request->hasFile('featureImage') || ! $request->file('featureImage')->isValid()){
            return $img;
        }
        
        if($img){            
            Storage::disk($this->disk())->delete($img);
        }

        $file_name = Str::random(20) . $event->id . ".{$request->featureImage->extension()}";

        return $request->file('featureImage')->storeAs($dir, $file_name, $this->disk());

    }

    protected function disk(){
        return 'public';
    }

    protected function removeStoragPath(string $img){
        return str_starts_with($img, "/storage/") ? substr($img, 9) : $img;
    }
}
