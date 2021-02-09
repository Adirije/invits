<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $appends = ['update_link', 'destroy_link'];

    public function getUpdateLinkAttribute(){
        return route('admin.finance.expenses.update', ['id' => $this->id]);
    }

    public function getDestroyLinkAttribute(){
        return route('admin.finance.expenses.destroy', ['id' => $this->id]);
    }
}
