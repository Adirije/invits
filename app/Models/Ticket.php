<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $appends = [
        'edit_link', 
        'price_str', 
        'quantity_sold',
        'sales_page',
        'sold_out',
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function getEditLinkAttribute(){
        return route('admin.tickets.update', ['id' => $this->id]);
    }

    public function getPriceStrAttribute(){
        return number_format($this->price, 2);
    }

    public function sales(){
        return $this->hasMany(Transaction::class);
    }

    public function getQuantitySoldAttribute()
    {
        return $this->sales->reduce(function($total, $sale){
            return $total + $sale->ticket_quantity;
        }, 0);
    }

    public function getSalesPageAttribute()
    {
        return route('admin.tickets.sales', ['id' => $this->id]);
    }

    public function getSoldOutAttribute()
    {
        return $this->quantity_sold  >= $this->volume;
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function registrations(){
        return $this->hasMany(EventRegistration::class);
    }

}
