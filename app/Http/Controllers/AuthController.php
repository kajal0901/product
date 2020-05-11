<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\Auth\AuthRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @var AuthRepository
     */
    protected $authRepository;

    /**
     * AuthController constructor.
     *
     * @param AuthRepository $authRepository
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * handle user registration Request.
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request): JsonResponse
    {
        $input = $this->validate($request, [$this->getValidationMethod()]);

        $oUser = $this->authRepository->create($input);

        return $this->httpOk([
            'message' => __('message.register_complected'),
            'data' => [
                'user' => new UserResource($oUser),
            ],
        ]);
    }

    /**
     * Get the user registration validation rule.
     *
     * @return array
     */
    protected function getValidationMethod(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique_encrypted:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * login request method
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $this->validate($request, [$this->getValidationMethodLogin()]);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => __('message.unauthorized')]);
        }

        return $this->respondWithToken($token);

    }

    /**
     * get the user login rule.
     *
     * @return array|string[]
     */
    protected function getValidationMethodLogin(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
