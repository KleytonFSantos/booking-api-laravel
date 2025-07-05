<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Models\Room;


class RoomRepository implements RoomRepositoryInterface
{
    public function findRoomById(int $id): ?Room
    {
        return Room::find($id);
    }

    public function updateVacancyRoomStatus(?Room $room, bool $status): void
    {
        $room->update(['vacancy' => $status]);
    }
}
