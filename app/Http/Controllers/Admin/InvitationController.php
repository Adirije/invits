<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Jobs\SendInvitationEmail;
use App\Http\Controllers\Controller;

class InvitationController extends Controller
{
    public function index($eventId = null){
        $events = Event::where('type', 'invite')->get();
        $event = null;

        if($eventId){
            $event = Event::with(['invitations'])->findOrFail($eventId);
        }

        return view('admin.invitations.index', compact('events', 'event'));
    }

    public function store(Request $request, $eventId){

        $request->validate([
            'email' => 'required|string|unique:invitations,email'
        ]);

        $emailAddresses = $request->email;

        $emailAddresses = preg_replace("/[\n\/]*[\r\/]*\s/", '', $emailAddresses);

        $emailAddresses = explode(',', $emailAddresses);

        foreach($emailAddresses as $email){
            if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
                return response()->json(['errors' => ['email' => ['The list contains an invalid address. Please check the values and try again.']]], 422);
            }
        }

        $emailJob = (new SendInvitationEmail($emailAddresses, $eventId))->delay(Carbon::now()->addSeconds(3));

        dispatch($emailJob);

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Invitations sent successfuly'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json($emailAddresses);
    }
    
    public function destroy(Request $request,  $id){
        Invitation::destroy($id);

        $notice = [
            'type' => 'success',
            'title' => 'Done!', 
            'text' => 'Invitations deleted successfuly.'
        ];

        $request->session()->flash('notification', json_encode($notice));

        return response()->json([], 201);
    }
}
