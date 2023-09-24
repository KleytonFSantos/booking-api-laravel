<?php

namespace App\Services\Booking;

use App\Enums\StatusEnum;
use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Http\DTO\ReservationDTO;
use App\Models\Room;
use App\Models\User;
use App\Repositories\ReservationRepository;
use App\Repositories\RoomRepository;
use App\Services\Document\UploadFileService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;


class CreateBookingService
{
    public function __construct(
        private readonly Room $room,
        private readonly ReservationRepository $reservationRepository,
        readonly private UploadFileService $uploadFile,
        private readonly RoomRepository $roomRepository
    )
    {
    }

    /**
     * @throws RoomAlreadyBookedException
     * @throws DateIsPastException
     */
    public function createBooking(
        ?User $user,
        ReservationDTO $reservationDTO,
        ?UploadedFile $file
    ): Builder|Model
    {

        $room = $this->room::query()
            ->find($reservationDTO->getRoom());

        $this->checkBookedRoom($room)
            ->isPastDate($reservationDTO->getStartDate());

        $reservationPrice = $this->reservationPriceCalculation($reservationDTO, $room->price);
        
        $fileName = $this->uploadFile->create($file);

        $reservation = $this->reservationRepository->saveReservation(
            $reservationDTO,
            $user,
            $reservationPrice
        );

        $this->roomRepository->updateVacancyRoomStatus($room, false);

        return $reservation;
    }

    public function reservationPriceCalculation(ReservationDTO $reservationDTO, int $roomPrice): int
    {
        $startDateParsed = Carbon::parse($reservationDTO->getStartDate());

        $daysDiff = $startDateParsed->diffInDays($reservationDTO->getEndDate());

        return $roomPrice * $daysDiff;
    }

    /**
     * @throws RoomAlreadyBookedException
     */
    public function checkBookedRoom(?Room $room): CreateBookingService
    {
        if (!$room->vacancy) {
            throw new RoomAlreadyBookedException($room->id);
        }

        return $this;
    }

    /**
     * @throws DateIsPastException
     */
    public function isPastDate(string $startDate): CreateBookingService
    {
        $brasilTimezone = new \DateTimeZone('America/Sao_Paulo');

        $currentDateTime = Carbon::now($brasilTimezone);

        $startDate = Carbon::parse($startDate, $brasilTimezone);

        if ($startDate < $currentDateTime) {
            throw new DateIsPastException('Choose a future date to start your reservation!');
        }

        return $this;
    }
}
