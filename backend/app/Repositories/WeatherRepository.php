<?php

namespace App\Repositories;

use Exception;
use GuzzleHttp\Client;

class WeatherRepository implements WeatherRepositoryInterface
{   
    private const API_KEY_WEATHER = 'c51d061f86891a4f4fc0c3f26d61bade';
    private const API_KEY_FORECAST = '20571ab45c74dc2a1897b60c5b8047a1';
    private const API_KEY_FOURSQUARE = 'fsq3lXAxp4pP4ixPfv+5OrZ1ULEZxJn7odiGqQ4+xHgzqSA=';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $city
     */
    public function getWeather(string $city): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&appid=%s',
            strtolower($city),
            self::API_KEY_WEATHER
        );

        try {
            $response = $this->client->get($url);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
    
    /**
     * @param string $city
     */
    public function getForecast(string $city): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/forecast/daily?q=%s&units=metric&appid=%s',
            $city,
            self::API_KEY_FORECAST
        );

        try {
            $response = $this->client->get($url);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
    
    /**
     * @param string $city
     */
    public function getPlaces(string $city): array
    {
        $url = sprintf(
            'https://api.foursquare.com/v3/places/search?categories=16000&near=%s&limit=6',
            strtolower($city),
            self::API_KEY_FORECAST
        );

        try {
            $response = $this->client->get(
                $url,
                [
                    'headers' => [
                      'Authorization' => self::API_KEY_FOURSQUARE,
                      'accept' => 'application/json',
                    ]
                ]
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
