<?php

namespace App\Http\DTO;

class ReservationDTO
{
    private ?int $room;

    private ?string $startDate = null;

    private ?string $endDate = null;

    public function __construct(array $booking)
    {
        $this->room = $booking['room'];
        $this->startDate = $booking['start_date'];
        $this->endDate = $booking['end_date'];
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'room' => $this->room,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ];
    }
}
