<?php

namespace Tests\Feature\Controllers;

use App\Repositories\WeatherRepository;
use App\Services\WeatherService;
use Faker\Factory as Faker;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    private \Faker\Generator $faker;
    private WeatherRepository $weatherRepository;
    private WeatherService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        $this->weatherRepository = $this->createMock(WeatherRepository::class);
        $this->app->instance(WeatherRepository::class, $this->weatherRepository);

        $this->service = app(WeatherService::class);
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

        $this->weatherRepository
            ->expects($this->once())
            ->method('getWeather')
            ->with($city)
            ->willReturn($weather);

        $response = $this->service->getWeather($city);

        $this->assertIsArray($response);

        $this->assertEquals(
            $response,
            $weather
        );
    }
}
