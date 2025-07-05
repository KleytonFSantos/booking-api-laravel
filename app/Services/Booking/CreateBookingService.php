<?php

namespace App\Services\Booking;

use App\Contracts\Repositories\ReservationRepositoryInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Services\CreateBookingServiceInterface;
use App\Contracts\Services\UploadFileServiceInterface;
use App\Contracts\Validator\BookingValidatorInterface;
use App\Http\DTO\ReservationDTO;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

final readonly class CreateBookingService implements CreateBookingServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private RoomRepositoryInterface    $roomRepository,
        private UploadFileServiceInterface $uploadFile,
        private BookingValidatorInterface  $validator
    ){
    }

    public function createBooking(ReservationDTO $reservationDTO, ?UploadedFile $file): Reservation {
        $room = $this->roomRepository->findRoomById($reservationDTO->getRoom());
        $this->validator->roomIsBooked($room);
        $this->validator->isPastDate($reservationDTO->getStartDate());

        $reservationPrice = $this->reservationPriceCalculation(
            $reservationDTO->getStartDate(),
            $reservationDTO->getEndDate(),
            $room->price
        );

        $fileName = $this->uploadFile->create($file);

        $reservation = $this->reservationRepository->save(
            $reservationDTO,
            $reservationPrice,
            $fileName
        );

        $this->roomRepository->updateVacancyRoomStatus($room, false);

        return $reservation;
    }

    private function reservationPriceCalculation(string $startDate,string $endDate, int $roomPrice): int
    {
        $startDateParsed = Carbon::parse($startDate);
        $daysDiff = $startDateParsed->diffInDays($endDate);
        return $roomPrice * $daysDiff;
    }
}
