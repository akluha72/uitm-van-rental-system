<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $status;
    public $comment;

    /**
     * Create a new message instance.
     */
    public function __construct($booking, $status, $comment = null)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Booking Review Status')
            ->view('emails.booking_review_notification') // Correct view path
            ->with([
                'booking' => $this->booking,
                'status' => $this->status,
                'comment' => $this->comment,
            ]);
    }
}
