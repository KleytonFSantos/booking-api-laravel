<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ApiRegisteredUserController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::query()
            ->create($request->validated());

        return response()->json(
            $user,
            Response::HTTP_OK
        );
    }
}
