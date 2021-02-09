<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();

        return view('admin.locations.index', \compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => ['bail', 'required', 'string'],
            'address' => ['bail', 'required', 'string'],
            'type' => ['bail', 'required', 'in:physical,virtual']
        ]);

        $location = new Location;
        
        $location->name = $request->name;
        $location->address = $request->address;
        $location->type = $request->type;

        $location->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Location saved successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'name' => ['bail', 'required', 'string'],
            'address' => ['bail', 'required', 'string'],
            'type' => ['bail', 'required', 'in:physical,virtual']
        ]);

        $location = Location::findOrFail($id);

        $location->name = $request->name;
        $location->address = $request->address;
        $location->type = $request->type;

        $location->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Location updated successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

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
        //
    }
}
