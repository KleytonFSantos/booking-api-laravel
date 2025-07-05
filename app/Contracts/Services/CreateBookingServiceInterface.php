<?php

namespace App\Contracts\Services;

use App\Http\DTO\ReservationDTO;
use App\Models\Room;
use Illuminate\Http\UploadedFile;

interface CreateBookingServiceInterface
{
    public function createBooking(ReservationDTO $reservationDTO, ?UploadedFile $file);
}
