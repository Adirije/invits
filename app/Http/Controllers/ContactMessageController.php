<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:191'],
            'email' => ['bail', 'required', 'string', 'max:191'],
            'subject' => ['bail', 'required', 'string', 'max:191'],
            'content' => ['bail', 'required', 'string'],
        ]);


        $message = new ContactMessage;

        $message->name = ucwords(strtolower($request->name));
        $message->email = strtolower($request->email);
        $message->subject = strip_tags($request->subject);
        $message->content = strip_tags($request->content);

        $message->save();

        
        $notice = [
            'type' => 'success',
            'title' => 'Thank You!', 
            'text' => "Your message has been recieved. Thank you for contacting us."
        ];

        $request->session()->flash('notification', json_encode($notice));

        if($request->wantsJson()){
            return response()->json([], 201);
        }

        return back();
    }

}
