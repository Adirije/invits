<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public static function boot(){
        parent::boot();

        static::created(function($guest){
            if($guest->name){
                $guest->slug = Str::slug($guest->name . $guest->id);
            }

            $guest->save();
        });

        static::saving(function($guest){
            if($guest->name && is_null($guest->slug)){
                $guest->slug = Str::slug($guest->name . $guest->id);
            }
        });
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

}
