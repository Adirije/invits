<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Controllers\Controller;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $messages = ContactMessage::latest()->get();

        return view('admin.messages.index', compact('messages'));
    }

    /** 
     * Mark the given massage as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, ContactMessage $contactMessage){
        $contactMessage->markAsRead();

        return response()->json([], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContactMessage $contactMessage){

        $contactMessage->delete();

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'The message has been deleted successfully.'
        ];

        $request->session()->flash('notification', json_encode($notice));

        
        if($request->wantsJson()){
            return \response()->json([], 201);
        }

        return redirect( route('admin.messages.index'));
    }

}
