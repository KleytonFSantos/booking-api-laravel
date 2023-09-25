<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListBookingsResource;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ListReservationAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): AnonymousResourceCollection | JsonResponse
    {
        $reservation = Reservation::all();

        if ($reservation->isEmpty()) {
            return response()->json(
                ['error' => 'Not found any reservation'],
                Response::HTTP_NOT_FOUND
            );
        }

        return ListBookingsResource::collection($reservation);
    }
}
