<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateBookingAction extends Controller
{
    public function __invoke(CreateBookingRequest $request): JsonResponse
    {
        $request->validated();

        return response()->json(
            ['teste'=>'teste'],
            200,
        );
    }
}
