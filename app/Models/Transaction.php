<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function guest(){
        return $this->belongsTo(Guest::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function registrations(){
        return $this->hasMany(EventRegistration::class);
    }

}
