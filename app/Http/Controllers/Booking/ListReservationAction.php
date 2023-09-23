<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ListReservationAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $reservation = Reservation::all();

        if (!$reservation) {
            return response()->json(
                ['error' => 'Not found any reservation'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            $reservation,
            Response::HTTP_OK
        );
    }
}
