<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function show(): Response
    {
        $bookings = Reservation::with('user')
            ->select(['id', 'price', 'start_date', 'end_date', 'user_id', 'status'])
            ->get();

        return Inertia::render('Bookings', [
            'bookings' => $bookings
        ]);
    }
}
