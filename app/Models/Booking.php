<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'van_id',
        'booking_type',
        'start_date',
        'end_date',
        'total_amount',
        'amount_due',
        'amount_paid',
        'booking_status',
        'payment_status',
        'booking_reference',
        'payment_schedule',
    ];
    
    protected $casts = [
        'payment_schedule' => 'array',
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


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = self::generateBookingReference();
        });
    }

    // Generate a unique booking reference
    public static function generateBookingReference()
    {
        do {
            $reference = strtoupper(Str::random(8)); // Generate an 8-character random string
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

    public function getAmountDueAttribute()
    {
        return $this->total_amount - $this->amount_paid;
    }
}
