<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $with = ['location'];

    protected $casts = [
        'starts' => 'datetime',
        'ends' => 'datetime',
        'published' => 'boolean',
        'enabled' => 'boolean',
        'featured' => 'boolean'
    ];

    public static function boot(){
        parent::boot();

        static::created(function($event){
            $event->slug = Str::random(20) . $event->id;
            $event->save();
        });
    }

    public function getFeatureImgAttribute($value){
        return Storage::url($value);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function registrations(){
        return $this->hasMany(EventRegistration::class);
    }

    public function invitations(){
        return $this->hasMany(Invitation::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function incomes(){
        return $this->hasMany(Income::class);
    }

    public function checkIns(){
        return $this->registrations()->where('checked_in', true)->get();
    }

    public function getLinkAttribute(){
        return route('public.events.show', ['slug' => $this->slug]);
    }

    public function getCheapestTicketPriceAttribute(){
        $amount = $this->tickets->filter(function($ticket){
            return $ticket->enabled;
        })->map(function($ticket){
                return $ticket->price;
            })->min();
        
        return number_format($amount, 2);
    }

    public function activeTickets(){
        return $this->tickets->filter(function($ticket){
            return $ticket->enabled;
        });
    }
}
