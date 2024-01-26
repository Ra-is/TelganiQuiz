<?php

namespace App\Services\Movies;

use Exception;
use External\Foo\Movies\MovieService;

class FooMovieService implements MovieServiceInterface
{
    private $fooMovieService;

    // Constructor to inject an instance of FooMovieService
    public function __construct(MovieService $fooMovieService)
    {
        $this->fooMovieService = $fooMovieService;
    }

    // Method to retrieve titles from FooMovieService
    public function getTitles(): array
    {
        try {
            // Call the getTitles method of FooMovieService
            return $this->fooMovieService->getTitles();
        } catch (Exception $exception) {
            // If an exception occurs during the process, catch it and return an empty array
            return [];
        }
    }
}
