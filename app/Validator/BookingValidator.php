<?php

namespace App\Validator;

use App\Contracts\Validator\BookingValidatorInterface;
use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Models\Room;
use Carbon\Carbon;

class BookingValidator implements BookingValidatorInterface
{

    public function roomIsBooked(?Room $room): void
    {
        if (!$room->vacancy) {
            throw new RoomAlreadyBookedException($room->id);
        }
    }

    public function isPastDate(string $startDate): void
    {
        $brasilTimezone = new \DateTimeZone('America/Sao_Paulo');
        $currentDateTime = Carbon::now($brasilTimezone);
        $startDate = Carbon::parse($startDate, $brasilTimezone);

        if ($startDate < $currentDateTime) {
            throw new DateIsPastException('Choose a future date to start your reservation!');
        }
    }
}
