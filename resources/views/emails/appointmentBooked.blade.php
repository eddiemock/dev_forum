{{-- resources/views/emails/appointmentBooked.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booked</title>
</head>
<body>
    <h1>Your Appointment is Confirmed</h1>
    <p>Hello {{ $appointment->user->name }},</p>
    <p>Your appointment with {{ $appointment->professional->name }} is booked.</p>
    <p>Details:</p>
    <ul>
        <li>Date and Time: {{ $appointment->appointment_time->format('l, F jS, Y g:i a') }}</li>
        <li>Location: {{ $appointment->professional->location }}</li>
        <li>Notes: {{ $appointment->notes ?? 'No additional notes.' }}</li>
    </ul>
    <p>Thank you for using our services.</p>
</body>
</html>
