<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'van_id', 
        'start_date', 
        'end_date', 
        'total_amount', 
        'booking_status', 
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function van()
    {
        return $this->belongsTo(Van::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
