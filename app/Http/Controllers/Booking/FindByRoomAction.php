<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FindByRoomAction extends Controller
{
    public function __invoke(Room $room): JsonResponse
    {
        return response()->json(
            $room->reservation,
            Response::HTTP_OK
        );
    }
}
