{{-- resources/views/emails/appointmentCancelled.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Cancelled</title>
</head>
<body>
    <h1>Your Appointment Has Been Cancelled</h1>
    <p>Hello {{ $appointment->user->name }},</p>
    <p>We're sorry to inform you that your appointment with {{ $appointment->professional->name }} scheduled for {{ $appointment->appointment_time->format('l, F jS, Y g:i a') }} has been cancelled.</p>
    <p>If this was a mistake or if you did not request a cancellation, please contact us immediately.</p>
    <p>Thank you for your understanding.</p>
</body>
</html>
