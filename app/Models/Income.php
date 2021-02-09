<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $appends = ['update_link', 'destroy_link'];

    public function getUpdateLinkAttribute(){
        return route('admin.finance.income.update', ['id' => $this->id]);
    }

    public function getDestroyLinkAttribute(){
        return route('admin.finance.income.destroy', ['id' => $this->id]);
    }
}
