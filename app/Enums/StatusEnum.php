<?php

namespace App\Enums;

enum StatusEnum: string
{
    case CANCELED = 'CANCELED';
    case RESERVED = 'RESERVED';
    case FINISHED = 'FINISHED';
}
