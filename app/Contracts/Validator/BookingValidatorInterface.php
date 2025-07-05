<?php

namespace App\Contracts\Validator;

use App\Models\Room;

interface BookingValidatorInterface
{
    public function roomIsBooked(?Room $room): void;
    public function isPastDate(string $startDate): void;
}
