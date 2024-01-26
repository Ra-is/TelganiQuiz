<?php

namespace App\Services\Movies;

use External\Baz\Movies\MovieService;
use Exception;

class BazMovieService implements MovieServiceInterface
{
    private $bazMovieService;

    // Constructor to inject an instance of BazMovieService
    public function __construct(MovieService $bazMovieService)
    {
        $this->bazMovieService = $bazMovieService;
    }

    // Method to retrieve titles from BazMovieService
    public function getTitles(): array
    {
        try {
            // Call the getTitles method of BazMovieService and directly access the 'titles' key
            return $this->bazMovieService->getTitles()['titles'];
        } catch (Exception $exception) {
            // If an exception occurs during the process, catch it and return an empty array
            return [];
        }
    }
}
