<?php

namespace App\Services\Movies;

use Exception;

class MovieServiceManager
{
    private $fooMovieService;
    private $barMovieService;
    private $bazMovieService;

    // Constructor to inject instances of FooMovieService, BarMovieService, and BazMovieService
    public function __construct(
        FooMovieService $fooMovieService,
        BarMovieService $barMovieService,
        BazMovieService $bazMovieService
    ) {
        $this->fooMovieService = $fooMovieService;
        $this->barMovieService = $barMovieService;
        $this->bazMovieService = $bazMovieService;
    }

    // Method to retrieve titles from all movie services
    public function getAllTitles(): array
    {
        try {
            // Retrieve titles from each movie service
            $fooTitles = $this->fooMovieService->getTitles();
            $barTitles = $this->barMovieService->getTitles();
            $bazTitles = $this->bazMovieService->getTitles();

            // Combine the results
            $combinedTitles = array_merge($fooTitles, $barTitles, $bazTitles);

            // Return the combined array of titles
            return $combinedTitles;
        } catch (Exception $exception) {
            // If an exception occurs during the process, report it and return an empty array
            report($exception);
            return [];
        }
    }
}
