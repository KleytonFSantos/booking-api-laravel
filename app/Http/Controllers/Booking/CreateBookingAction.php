<?php

namespace App\Http\Controllers\Booking;

use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Http\Controllers\Controller;
use App\Http\DTO\ReservationDTO;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Models\User;
use App\Services\Booking\CreateBookingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateBookingAction extends Controller
{
    public function __construct(
        readonly private CreateBookingService $bookingService
    )
    {

    }

    /**
     * @throws RoomAlreadyBookedException
     * @throws DateIsPastException
     */
    public function __invoke(CreateBookingRequest $request, User $user): JsonResponse
    {
        $reservation = new ReservationDTO($request->validated());
        $getUser = $user::query()->find(1);

        $booking = $this->bookingService->createBooking(
            user: $getUser,
            reservationDTO: $reservation
        );

        return response()->json(
            $booking,
            Response::HTTP_OK,
        );
    }
}
