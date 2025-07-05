<?php

namespace App\Http\Controllers\Booking;

use App\Contracts\Services\CreateBookingServiceInterface;
use App\Contracts\Services\UploadFileServiceInterface;
use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Http\Controllers\Controller;
use App\Http\DTO\ReservationDTO;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Http\Resources\CreateBookingResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateBookingAction extends Controller
{
    public function __construct(
        readonly private CreateBookingServiceInterface $bookingService,
        readonly private UploadFileServiceInterface $fileService
    ) {
    }

    public function __invoke(CreateBookingRequest $request): CreateBookingResource | JsonResponse
    {
        try {
            $file = $this->fileService->getFile($request);
            $reservation = new ReservationDTO($request->validated());
            $booking = $this->bookingService->createBooking(
                reservationDTO: $reservation,
                file: $file
            );

            return CreateBookingResource::make($booking);
        } catch (DateIsPastException | RoomAlreadyBookedException $exception) {
            return response()->json(
                ['error' => $exception->getMessage()],
                $exception->getCode(),
            );
        } catch (\Exception $exception) {
            return response()->json(
                ['error' => 'Something was wrong!'],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
