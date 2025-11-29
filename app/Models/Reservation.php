<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'hotel_id', 'check_in', 'check_out'];
    protected $casts = ['check_in' => 'date', 'check_out' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function hotel() { return $this->belongsTo(Hotel::class); }
}