<?php

namespace App\Services\Booking;

use App\Enums\StatusEnum;
use App\Exceptions\DateIsPastException;
use App\Exceptions\RoomAlreadyBookedException;
use App\Http\DTO\ReservationDTO;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class CreateBookingService
{
    public function __construct(
        private readonly Room $room,
        private readonly Reservation $reservation
    )
    {
    }

    /**
     * @throws RoomAlreadyBookedException
     * @throws DateIsPastException
     */
    public function createBooking(
        ?User $user,
        ReservationDTO $reservationDTO
    ): Builder|Model
    {

        $room = $this->room::query()
            ->find($reservationDTO->getRoom());

        $this->checkBookedRoom($room)
            ->isPastDate($reservationDTO->getStartDate());

        $reservationPrice = $this->reservationPriceCalculation($reservationDTO, $room->price);

        $reservation = $this->reservation::query()
            ->create([
                'start_date' => Carbon::parse($reservationDTO->getStartDate()),
                'end_date' => Carbon::parse($reservationDTO->getEndDate()),
                'room_id' => $reservationDTO->getRoom(),
                'user_id'=> $user->id,
                'price' => $reservationPrice,
                'status' => StatusEnum::RESERVED
            ]);

        $room->update([
            'vacancy' => false
        ]);

        return $reservation;
    }

    public function reservationPriceCalculation(ReservationDTO $reservationDTO, int $roomPrice): string
    {
        $startDateParsed = Carbon::parse($reservationDTO->getStartDate());

        $daysDiff = $startDateParsed->diffInDays($reservationDTO->getEndDate());

        return $roomPrice * $daysDiff;
    }

    /**
     * @throws RoomAlreadyBookedException
     */
    public function checkBookedRoom(?Room $room): CreateBookingService
    {
        if (!$room->vacancy) {
            throw new RoomAlreadyBookedException($room->id);
        }

        return $this;
    }

    /**
     * @throws DateIsPastException
     */
    public function isPastDate(string $startDate): CreateBookingService
    {
        $brasilTimezone = new \DateTimeZone('America/Sao_Paulo');

        $currentDateTime = Carbon::now($brasilTimezone);

        $startDate = Carbon::parse($startDate, $brasilTimezone);

        if ($startDate < $currentDateTime) {
            throw new DateIsPastException('Choose a future date to start your reservation!');
        }

        return $this;
    }
}
