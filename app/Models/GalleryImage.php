<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $appends = ['update_link', 'del_link'];

    public function getImgAttribute($value){
        return Storage::url($value);
    }

    public function event(){
        return $this->belongsTo(Event::class)->withDefault([
            'name' => 'None'
        ]);
    }

    public function getUpdateLinkAttribute(){
        return route('admin.gallery.update', ['id' => $this->id]);
    }

    public function getDelLinkAttribute(){
        return route('admin.gallery.destroy', ['id' => $this->id]);
    }
}
