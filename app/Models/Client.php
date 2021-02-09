<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $appends = ['edit_link'];

    public static function boot(){

        parent::boot();
        
        static::created(function($client){
            $client->slug = Str::slug($client->name . $client->id);
        });
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getEditLinkAttribute(){
        return route('admin.clients.update', ['id' => $this->id]);
    }

}
