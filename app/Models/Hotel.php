<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    // Aggiunto 'total_rooms'
    protected $fillable = ['name', 'city', 'street', 'house_number', 'zip_code', 'price', 'tourist_tax', 'description', 'total_rooms'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // RELAZIONE: Un hotel ha molte immagini
    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }
}