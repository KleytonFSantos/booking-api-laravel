<?php

namespace App\Services\Booking;

use App\Enums\StatusEnum;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use App\Repositories\RoomRepository;

class CancelBookingService
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly RoomRepository $roomRepository
    )
    {
    }

    public function cancel(Reservation $reservation): void
    {
        $this->reservationRepository->updateReservationStatus($reservation, StatusEnum::CANCELED);

        $this->roomRepository->updateVacancyRoomStatus($reservation->room, true);
    }
}
