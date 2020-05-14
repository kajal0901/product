<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->authRepository->getAll(
            $request->only('page', 'perPage', 'orderBy', 'orderByColumn')
        );
        return $this->httpOk([
            'data' =>
                [
                    'current_page' => $users->currentPage(),
                    'from' => $users->firstItem(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'to' => $users->lastItem(),
                    'total' => $users->total(),
                    'products' => UserResource::collection($users),
                ],
        ]);
    }

    /**
     * handle user registration Request.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request): JsonResponse
    {
        $input = $this->validate($request, $this->getValidationMethod());

        $oUser = $this->authRepository->create($input);

        LogActivity::addToLog('User Registration Api.',$request);

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
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * login request method
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $this->validate($request, $this->getValidationMethodLogin());

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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->authRepository->delete($id);
        return $this->httpOk([
            'message' => __('message.user_deleted'),
            'data' => ['status' => 'true'],
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function findUserById(int $id): JsonResponse
    {
        $user = $this->authRepository->find($id);
        return $this->httpOk([
            'data' => [
                'user' => new UserResource($user),
            ],
        ]);
    }

}
