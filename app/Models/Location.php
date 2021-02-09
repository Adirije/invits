<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $appends = ['update_link', 'del_link'];

    public function getUpdateLinkAttribute(){
        return route('admin.locations.update', ['id' => $this->id]);
    }

    public function getDelLinkAttribute(){
        return route('admin.locations.delete', ['id' => $this->id]);
    }
}
