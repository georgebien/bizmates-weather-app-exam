<?php

namespace App\Services;

use App\Repositories\WeatherRepository;

class WeatherService
{   
    /**
     * @var App\Repositories\WeatherRepository
     */
    private $weatherRepository;

    /**
     * @param WeatherRepository $weatherRepository
     */
    public function __construct(WeatherRepository $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @param string $city
     */
    public function getWeather(string $city): array
    {
        return $this->weatherRepository->getWeather($city);
    }
    
    /**
     * @param string $city
     */
    public function getForecast(string $city): array
    {
        return $this->weatherRepository->getForecast($city);
    }

    /**
     * @param string $city
     */
    public function getPlaces(string $city): array
    {
        return $this->weatherRepository->getPlaces($city);
    }
}
