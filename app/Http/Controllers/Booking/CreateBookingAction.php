<?php

namespace App\Http\Controllers\Booking;

use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Http\Controllers\Controller;
use App\Http\DTO\ReservationDTO;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Http\Resources\CreateBookingResource;
use App\Models\User;
use App\Services\Booking\CreateBookingService;
use App\Services\Document\UploadFileService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateBookingAction extends Controller
{
    public function __construct(
        readonly private CreateBookingService $bookingService,
        readonly private UploadFileService $fileService
    )
    {
    }

    public function __invoke(CreateBookingRequest $request): CreateBookingResource | JsonResponse
    {
        $file = $this->fileService->getFile($request);

        try {
            $reservation = new ReservationDTO($request->validated());

            $booking = $this->bookingService->createBooking(
                reservationDTO: $reservation,
                file: $file
            );

            return CreateBookingResource::make($booking);
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
