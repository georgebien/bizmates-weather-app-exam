<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface WeatherRepositoryInterface
{
    /**
     * @param string $city
     */
    public function getWeather(string $city): array;

    /**
     * @param string $city
     */
    public function getForecast(string $city): array;

    /**
     * @param string $city
     */
    public function getPlaces(string $city): array;
}
