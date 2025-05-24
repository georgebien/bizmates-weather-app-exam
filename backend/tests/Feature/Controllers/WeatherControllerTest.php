<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\WeatherController;
use App\Services\WeatherService;
use Exception;
use Faker\Factory as Faker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    private \Faker\Generator $faker;
    private WeatherService $weatherService;
    private WeatherController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();

        $this->weatherService = $this->createMock(WeatherService::class);
        $this->app->instance(WeatherService::class, $this->weatherService);

        $this->controller = app(WeatherController::class);
    }

    /**
     * @test
     */
    public function fetching_weather_returned_data(): void
    {
        $request = new Request(
            [],
            ['city' => $this->faker->word()]
        );
        $weather = [
            'id' => $this->faker->uuid,
            'weather' => $this->faker->name,
        ];

        $this->weatherService
            ->expects($this->once())
            ->method('getWeather')
            ->with($request->get('city'))
            ->willReturn($weather);

        $response = $this->controller->getWeather($request);

        $this->assertInstanceOf(
            JsonResponse::class,
            $response
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

         $this->assertEquals(
            json_decode($response->getContent(), true)['data'],
            $weather
        );
    }

     /**
     * @test
     */
    public function fetching_weather_has_error(): void
    {
        $request = new Request(
            [],
            ['city' => $this->faker->word()]
        );
        $weather = [
            'id' => $this->faker->uuid,
            'weather' => $this->faker->name,
        ];

        $this->weatherService
            ->expects($this->once())
            ->method('getWeather')
            ->with($request->get('city'))
            ->willThrowException(new Exception());

        $response = $this->controller->getWeather($request);

        $this->assertInstanceOf(
            JsonResponse::class,
            $response
        );

        $this->assertEquals(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $response->getStatusCode()
        );
    }
}
