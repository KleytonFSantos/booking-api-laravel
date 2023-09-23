<?php

namespace App\Repositories;

use App\Models\Room;


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
