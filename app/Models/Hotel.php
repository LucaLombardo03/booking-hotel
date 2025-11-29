<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name', 'city', 'price', 'description'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}