<?php

namespace App\Http\Controllers;

use App\Services\Movies\MovieServiceManager;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private $movieServiceManager;

    public function __construct(MovieServiceManager $movieServiceManager)
    {
        $this->movieServiceManager = $movieServiceManager;
    }

    public function getTitles(): JsonResponse
    {
        try {
            // Get titles from the movie service manager
            $titles = $this->movieServiceManager->getAllTitles();

            // Return the results in a JSON response
            return response()->json($titles, 200);
        } catch (Exception $exception) {
            // Handle any exceptions and return a failure response
            report($exception);
            return response()->json(['status' => 'failure'], 500);
        }
    }
}
