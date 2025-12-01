<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'city',
        'street',
        'house_number',
        'zip_code',
        'price',
        'description'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
