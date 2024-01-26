<?php

namespace App\Services\Movies;

use Exception;
use External\Bar\Movies\MovieService;

class BarMovieService implements MovieServiceInterface
{
    private $barMovieService;

    // Constructor to inject an instance of MovieService into BarMovieService
    public function __construct(MovieService $barMovieService)
    {
        $this->barMovieService = $barMovieService;
    }

    // Implementation of the getTitles method defined in MovieServiceInterface
    public function getTitles(): array
    {
        try {
            // Retrieve titles data from the Bar movie service
            $titlesData = $this->barMovieService->getTitles();

            // Extract title information from the data and create an array of titles
            $titles = array_map(function ($titleInfo) {
                return $titleInfo['title'];
            }, $titlesData['titles']);

            // Return the array of titles
            return $titles;
        } catch (Exception $exception) {
            // If an exception occurs during the process, return an empty array
            return [];
        }
    }
}
