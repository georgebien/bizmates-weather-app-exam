<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends Controller
{
    use ResponseTrait;

    const GET_MESSAGE = 'Listed successfully';

    /**
     * @var \App\Services\WeatherService
     */
    private $weatherService;

    /**
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function getWeather(Request $request): JsonResponse
    {
        try {
            $response = $this->weatherService->getWeather($request->get('city'));
          
            return $this->response(
                Response::HTTP_OK,
                self::GET_MESSAGE,
                $response
            );
            
        } catch (Exception $exception) {
            return $this->response(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function getForecast(Request $request): JsonResponse
    {
        try {
            $response = $this->weatherService->getForecast($request->get('city'));
          
            return $this->response(
                Response::HTTP_OK,
                self::GET_MESSAGE,
                $response
            );
            
        } catch (Exception $exception) {
            return $this->response(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function getPlaces(Request $request): JsonResponse
    {
        try {
            $response = $this->weatherService->getPlaces($request->get('city'));
          
            return $this->response(
                Response::HTTP_OK,
                self::GET_MESSAGE,
                $response
            );
            
        } catch (Exception $exception) {
            return $this->response(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }
    }
}
