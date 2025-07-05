<?php

namespace App\Contracts\Repositories;

use App\Models\Room;

interface RoomRepositoryInterface
{
    public function findRoomById(int $id): ?Room;
    public function updateVacancyRoomStatus(?Room $room, bool $status): void;
}
