<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{   
    /**
     * @param int|null $status
     * @param string|null $message
     * @param array $data
     * 
     * @return JsonResponse
     */
    public function response(
        ?int $status = null, 
        ?string $message = null, 
        array $data = []
    ):JsonResponse {
        $response['status'] = $status;

        if (!empty($data)) {
            $response['data'] = $data;
        }

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $status, [], JSON_NUMERIC_CHECK);
    }
}