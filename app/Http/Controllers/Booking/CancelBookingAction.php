<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Booking\CancelBookingService;
use Symfony\Component\HttpFoundation\Response;

class CancelBookingAction extends Controller
{
    public function __construct(private readonly CancelBookingService $cancelBookingService)
    {
    }

    public function __invoke(Reservation $reservation)
    {
        $this->cancelBookingService->cancel($reservation);

        return response()->json(
            [
                'message' => 'Booking '. $reservation->id .' was canceled successfully',
            ],
            Response::HTTP_OK
        );
    }
}
