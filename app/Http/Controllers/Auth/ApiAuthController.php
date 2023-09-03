<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $user->createToken($request->email)->plainTextToken;
        } catch (ValidationException $error) {
            return new JsonResponse(['error' => $error->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return new JsonResponse(['error' => 'something got wrong'], Response::HTTP_BAD_REQUEST);
        }
    }
}
