<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_date',
        'amount_paid',
        'payment_method',
        'payment_status',
    ];

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Booking::class,
            'id',         // Foreign key on bookings table
            'id',         // Foreign key on users table
            'booking_id', // Local key on payments table
            'user_id'     // Local key on bookings table
        );
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

