<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $appends = ['accept_link', 'reject_link', 'del_link'];

    public static function boot(){
        parent::boot();

        static::created(function($invitation){
            $invitation->slug = Str::random(15) . Str::random(15) . $invitation->id;

            $invitation->save();
        });
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function getAcceptLinkAttribute(){
        return route('public.invites.showReg', $this->slug);
    }

    public function getDelLinkAttribute(){
        return route('admin.invitations.destroy', $this->id);
    }

    public function getRejectLinkAttribute(){
        return route('public.invitations.showDeclinePage', $this->slug);
    }
}
