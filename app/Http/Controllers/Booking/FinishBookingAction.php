<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Booking\FinishBookingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FinishBookingAction extends Controller
{
    public function __construct(private readonly FinishBookingService $bookingService)
    {
    }

    public function __invoke(Reservation $reservation): JsonResponse
    {
        $this->bookingService->finish($reservation);

        return response()->json(
          [
              'message' => 'Reservation '.$reservation->id.' was finished successfully!'
          ],
            Response::HTTP_OK
        );
    }
}
