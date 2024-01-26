<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use App\Services\Auth\AuthManager;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $login = $request->input('login');
        $password = $request->input('password');

        try {
            // Resolve the AuthManager service
            $authManager = resolve(AuthManager::class);

            // Attempt to authenticate the user
            $authenticationResult = $authManager->authenticateUser($login, $password);

            // If authentication is successful, retrieve the generated token
            if ($authenticationResult) {
                $generatedToken = $authManager->getGeneratedToken();
                
                // Return success response with the generated token
                return new SuccessResponse($generatedToken);
            } else {
                // Return failure response if authentication fails
                return new FailResponse();
            }
        } catch (Exception $exception) {
            // Log the exception and return failure response in case of an error
            report($exception);
            return new FailResponse();
        }
    }
}
