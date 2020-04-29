<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, $this->getValidationMethod());

        $input = $request->only('name', 'email', 'password');
        try {
            $oUser = $this->authRepository->create($input);
            return response()->json(['user' => $oUser, 'message' => 'Registration Complected']);
        } catch (Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!']);
        }
    }

    /**
     * Get the password reset validation rules.
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
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, $this->getValidationMethodLogin());
        $input = $this->validate($request, config('validation-rules.login'));
        if (!$token = Auth::attempt($input)) {
            return response()->json(['message' => 'Unauthorized']);
        }
        return $this->respondWithToken($token);
    }

    /**
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
