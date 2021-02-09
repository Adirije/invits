<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Support\Str;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleryImages = GalleryImage::with('event')->paginate();
        $events = Event::all();

        return view('admin.gallery.index', compact('galleryImages', 'events'));
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
            'image' => ['bail', 'required', 'image'],
            'event' => ['bail', 'sometimes', 'nullable', 'exists:events,id']
        ]);

        $galleryImage = new GalleryImage;
        
        $galleryImage->event_id = $request->event;
        $galleryImage->enabled = $request->boolean('visible');

        $galleryImage->img = $this->uploadImage($request, $galleryImage);

        $galleryImage->save();

        return response()->json([], 201);
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
            'image' => ['bail', 'sometimes', 'image'],
            'event' => ['bail', 'sometimes', 'nullable', 'exists:events,id']
        ]);

        $galleryImage = GalleryImage::findOrFail($id);
        
        $galleryImage->event_id = $request->event;
        $galleryImage->enabled = $request->boolean('visible');

        $galleryImage->img = $this->uploadImage($request, $galleryImage);

        $galleryImage->save();

        return response()->json([], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        $img = $this->removeStoragPath($galleryImage->img);

        Storage::disk($this->disk())->delete($img);

        $galleryImage->delete();

        return response()->json([], 201);
    }

    protected function uploadImage($request, $galleryImage)
    {
        $dir = 'gallery';

        $img = $this->removeStoragPath($galleryImage->img);

        if(! $request->hasFile('image') || ! $request->file('image')->isValid()){
            return $img;
        }
        
        if($img){            
            Storage::disk($this->disk())->delete($img);
        }

        $file_name = Str::random(20) . $galleryImage->id . ".{$request->image->extension()}";

        return $request->file('image')->storeAs($dir, $file_name, $this->disk());

    }

    protected function disk(){
        return 'public';
    }

    protected function removeStoragPath(string $img){
        return str_starts_with($img, "/storage/") ? substr($img, 9) : $img;
    }
}
