<?php

namespace Tests\Feature\Controllers;

use App\Repositories\WeatherRepository;
use App\Services\WeatherService;
use Exception;
use Faker\Factory as Faker;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class WeatherRepositoryTest extends TestCase
{
    private const API_KEY_WEATHER = 'c51d061f86891a4f4fc0c3f26d61bade';
    private const API_KEY_FORECAST = '20571ab45c74dc2a1897b60c5b8047a1';
    private const API_KEY_FOURSQUARE = 'fsq3lXAxp4pP4ixPfv+5OrZ1ULEZxJn7odiGqQ4+xHgzqSA=';

    private \Faker\Generator $faker;
    private Client $client;
    private WeatherRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        $this->client = $this->createMock(Client::class);
        $this->app->instance(Client::class, $this->client);

        $this->repository = app(WeatherRepository::class);
    }

    /**
     * @test
     */
    public function fetching_weather_returned_data(): void
    {
        $city = $this->faker->word();
        $weather = [
            'id' => $this->faker->uuid,
            'weather' => $this->faker->name,
        ];
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&appid=%s',
            strtolower($city),
            self::API_KEY_WEATHER
        );

        $response = new Response(
            200, 
            [], 
            json_encode($weather)
        );

        $this->client
            ->expects($this->once())
            ->method('get')
            ->with($url)
            ->willReturn($response);

        $response = $this->repository->getWeather($city);

        $this->assertIsArray($response);

        $this->assertEquals(
            $response,
            $weather
        );
    }

    /**
     * @test
     */
    public function fetching_weather_has_error(): void
    {
        $errorMesage = $this->faker->sentence();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage($errorMesage);

        $city = $this->faker->word();
        $weather = [
            'id' => $this->faker->uuid,
            'weather' => $this->faker->name,
        ];
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&appid=%s',
            strtolower($city),
            self::API_KEY_WEATHER
        );

        $this->client
            ->expects($this->once())
            ->method('get')
            ->with($url)
            ->willThrowException(new Exception($errorMesage));

        $this->repository->getWeather($city);
    }
}
