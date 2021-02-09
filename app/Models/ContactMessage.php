<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $casts = ['is_read' => 'boolean'];

    public static function boot(){
        parent::boot();

        static::creating(function($message){
            $message->createIntro();
        });

        static::updating(function($message){
            $message->createIntro();
        });
    }

    public function createIntro(){  

        $intro = strip_tags($this->content);

        $intro = Str::limit($intro, 200);

        $this->intro = str_replace('&nbsp;', ' ', $intro);

        return $this->intro;
    }

    public function markAsRead(){
        $this->is_read = true;

        $this->save();

        return $this;
    }    
}
