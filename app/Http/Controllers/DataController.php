<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DataController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function postRequest(Request $request): JsonResponse
    {
        $input =   $this->validate($request, $this->getValidationMethod());
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'laravellumen.local/api/auth/register', [
            'form_params' => $input
        ]);
        $response = $response->getBody()->getContents();
        return $this->httpOk([
            'message' => __('Registration Complected'),
            'data' => [
                'user' => $response,
            ],
        ]);
    }

    /**
     * @return array|string[]
     */
    protected function getValidationMethod(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

}
