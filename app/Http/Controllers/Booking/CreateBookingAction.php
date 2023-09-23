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

    public function __invoke(CreateBookingRequest $request, User $user): JsonResponse
    {
        try {
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
        } catch (DateIsPastException | RoomAlreadyBookedException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage()
                ],
                $exception->getCode(),
            );
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'error' => 'Something was wrong!'
                ],
                $exception->getCode(),
            );
        }
    }
}
