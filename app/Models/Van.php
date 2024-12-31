<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Van extends Model
{
    use HasFactory;

    protected $fillable = [
        'model', 
        'capacity', 
        'rental_rate', 
        'license_plate', 
        'maintenance_status', 
        'availability',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
