<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\AppointmentBookedMail;
use App\Mail\AppointmentCancelledMail;
use Illuminate\Support\Facades\Mail; // Correct the import for Mail
use App\Models\User;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'appointment_time' => 'required|date',
            // Add other validation rules as needed
        ]);

        $appointment = new Appointment();
        $appointment->user_id = auth()->id(); // Assumes user is logged in
        $appointment->professional_id = $request->professional_id;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->notes = $request->notes;
        $appointment->save();

        $user = auth()->user(); // Define $user variable
        Mail::to($user->email)->send(new AppointmentBookedMail($appointment));
        
        return back()->with('success', 'Appointment booked successfully.');
    }

    public function cancelAppointment(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Optional: Check if the authenticated user is allowed to cancel this appointment
        if ($appointment->user_id !== auth()->id()) {
            return back()->with('error', 'You are not authorized to cancel this appointment.');
        }

        // Delete the appointment
        $appointment->delete();

        $user = auth()->user(); // Define $user variable
        Mail::to($user->email)->send(new AppointmentCancelledMail($appointment));

        return back()->with('success', 'Appointment canceled successfully.');
    }
}
