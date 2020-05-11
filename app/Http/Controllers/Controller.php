<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    /**
     * @param $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return $this->httpOk([
            'message' => __('message.login_successful'),
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ],
        ]);
    }

    /**
     * @param array $response
     *
     * @return JsonResponse]
     */
    public function httpOk(array $response = []): JsonResponse
    {
        if (!isset($response['code'])) {
            $response['code'] = Response::HTTP_OK;
        }

        if (!isset($response['message'])) {
            $response['message'] = __('success');
        }

        if (!isset($response['data'])) {
            $response['data'] = [];
        }

        return response()->json($response, $response['code']);
    }
}
