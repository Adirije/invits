<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $casts = [
        'checked_in' => 'boolean'
    ];

    public static function boot(){

        parent::boot();

        static::created(function($reg){
            $reg->checkin_code = strtoupper(Str::random(15)) . $reg->id;

            $reg->save();
        });
    }

    public function guest(){
        return $this->belongsTo(Guest::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
