<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\DTO\ReservationDTO;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class ReservationRepository
{
    public function __construct(private readonly Reservation $model)
    {
    }

    public function save(
        ReservationDTO $reservationDTO,
        int $reservationPrice,
        ?string $documentPath
    ): Reservation {
        return $this->model::query()
            ->with('room')
            ->with('user')
            ->create([
                'start_date' => Carbon::parse($reservationDTO->getStartDate()),
                'end_date' => Carbon::parse($reservationDTO->getEndDate()),
                'room_id' => $reservationDTO->getRoom(),
                'user_id'=> auth('sanctum')->user()->id,
                'price' => $reservationPrice,
                'document' => $documentPath,
                'status' => StatusEnum::RESERVED
            ]);
    }

    public function updateReservationStatus(Reservation $reservation, StatusEnum $status): void
    {
        $reservation->update([
          'status' => $status->value
        ]);
    }
}
