<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ReservationNotFoundException extends Exception
{
    public function __construct() {
        parent::__construct(
            $this->errorMessage(),
            Response::HTTP_NOT_FOUND
        );
    }

    public function errorMessage(): string
    {
            return 'Reservation not found';
    }
}
