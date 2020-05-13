<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Repositories\Auth\CartRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{

    /**
     * @var
     */
    protected $cartRepository;

    /**
     * CartController constructor.
     *
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * method for store cart data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $input = $this->validate($request, $this->getValidationMethod());
        $oCart = $this->cartRepository->create($input);
        return $this->httpOk([
            'message' => __('message.product_added_to_cart'),
            'data' => [
                'cart' => new CartResource($oCart),
            ],
        ]);
    }

    /**
     * validation for cart store data.
     *
     * @return array|string[]
     */
    protected function getValidationMethod(): array
    {
        return [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'product_id' => 'required|integer',
        ];
    }

    /**
     * method for show cart information by id
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->httpOk([
            'data' => [
                'carts' => new CartResource(
                    $this->cartRepository->show($id)
                ),
            ],
        ]);
    }

    /**
     * request handle for update cart data.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $input = $this->validate($request, $this->getValidationUpdateMethod());
        return $this->httpOk([
            'message' => __('message.cart_updated'),
            'data' => ['user' => new CartResource($this->cartRepository->update($id, $input)),
            ],
        ]);
    }

    /**
     * validation for update cart  data.
     *
     * @return array|string[]
     */
    public function getValidationUpdateMethod(): array
    {
        return [
            'name' => 'sometimes|string',
            'price' => 'sometimes|integer',
            'description' => 'sometimes|integer',
        ];
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->cartRepository->delete($id);
        return $this->httpOk([
            'message' =>__ ('message.cart_deleted'),
            'data' => ['cart' => $this->cartRepository->getDeletedRecord($id)],
        ]);
    }

}
