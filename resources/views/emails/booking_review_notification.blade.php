<!DOCTYPE html>
<html>
<head>
    <title>Booking Review Status</title>
</head>
<body>
    <h1>Booking Review Status</h1>
    <p>Dear {{ $booking->user->first_name }},</p>

    <p>Your booking with reference <strong>{{ $booking->booking_reference }}</strong> has been <strong>{{ ucfirst($status) }}</strong>.</p>

    @if ($status === 'rejected' && $comment)
        <p><strong>Reason for Rejection:</strong> {{ $comment }}</p>
    @endif

    <p>Thank you for using our service!</p>

    <p>Best regards,<br>Van Rental Team</p>
</body>
</html>
