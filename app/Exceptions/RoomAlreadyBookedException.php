<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RoomAlreadyBookedException extends Exception
{
    public function __construct(
        private readonly int $room
    ) {
        parent::__construct(
            $this->errorMessage(),
            Response::HTTP_BAD_REQUEST
        );
    }

    public function errorMessage(): string
    {
        if (empty($this->room)) {
            return 'No room available';
        }

        return sprintf(
            'The room %s is already booked!',
            $this->room
        );
    }
}
