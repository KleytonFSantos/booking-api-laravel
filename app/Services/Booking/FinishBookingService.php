<?php

namespace App\Services\Booking;

use App\Enums\StatusEnum;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use App\Repositories\RoomRepository;

class FinishBookingService
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly RoomRepository $roomRepository
    )
    {
    }

    public function finish(Reservation $reservation): void
    {
        $this->reservationRepository->updateReservationStatus($reservation, StatusEnum::FINISHED);

        $this->roomRepository->updateVacancyRoomStatus($reservation->room, true);
    }
}
