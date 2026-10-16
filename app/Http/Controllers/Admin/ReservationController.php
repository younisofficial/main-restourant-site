<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $reservations = Reservation::when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('reservation_date')->orderBy('reservation_time')
            ->paginate(12)->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'status'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_keys(Reservation::STATUSES))],
        ]);

        $reservation->update(['status' => $request->status]);

        return back()->with('success', "Reservation for {$reservation->name} is now {$reservation->status_label}.");
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return back()->with('success', 'Reservation deleted.');
    }
}
