<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\DTO\ReservationDTO;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class RoomRepository
{
    public function __construct()
    {
    }

    public function updateVacancyRoomStatus(?Room $room, bool $status): void
    {
        $room->update([
            'vacancy' => $status
        ]);
    }
}
