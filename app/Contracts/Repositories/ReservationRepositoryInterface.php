<?php

namespace App\Contracts\Repositories;

use App\Enums\StatusEnum;
use App\Http\DTO\ReservationDTO;
use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function save(
        ReservationDTO $reservationDTO,
        int $reservationPrice,
        string $documentPath
    ): Reservation;

    public function updateReservationStatus(Reservation $reservation, StatusEnum $status);
}
