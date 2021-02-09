<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $clients = Client::all();

        return view('admin.clients.index', compact('clients'));
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
            'firstName' =>  ['bail', 'required', 'string', 'max:191'],
            'lastName' => ['bail', 'required', 'string', 'max:191'],
            'email' => ['bail', 'required', 'email', 'max:191', 'unique:clients,email'],
            'phone' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'address' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'gender' => ['bail', 'required', 'string', 'in:male,female'],
            'about' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
        ]);

        $client = new Client;

        $client->firstname = $request->firstName;
        $client->lastname = $request->lastName;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->gender = $request->gender;
        $client->about = $request->about;

        $client->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Client saved successfuly'
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
            'firstName' =>  ['bail', 'required', 'string', 'max:191'],
            'lastName' => ['bail', 'required', 'string', 'max:191'],
            'email' => ['bail', 'required', 'email', 'max:191', Rule::unique('clients', 'email')->ignore($id)],
            'phone' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'address' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
            'gender' => ['bail', 'required', 'string', 'in:male,female'],
            'about' => ['bail', 'sometimes', 'nullable', 'string', 'max:191'],
        ]);

        $client = Client::findOrFail($id);

        $client->firstname = $request->firstName;
        $client->lastname = $request->lastName;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->gender = $request->gender;
        $client->about = $request->about;

        $client->save();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Client updated successfuly'
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
