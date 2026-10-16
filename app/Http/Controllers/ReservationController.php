<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        return view('frontend.reservation');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'required|string|max:30',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guests' => 'required|integer|min:1|max:30',
            'message' => 'nullable|string|max:1000',
        ], [
            'reservation_date.after_or_equal' => 'Please choose today or a future date.',
        ]);

        $data['user_id'] = $request->user()?->id;
        Reservation::create($data);

        return redirect()->route('reservation')
            ->with('success', 'Your table request has been received! We will call you shortly to confirm.');
    }
}
