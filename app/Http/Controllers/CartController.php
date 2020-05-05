<?php

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
     * method for cart data.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->httpOk([
            'data' => [
                'products' => $this->cartRepository->get(),
            ],
        ]);
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
    public function store(Request $request)
    {
        $input = $this->validate($request, $this->getValidationMethod());

        $oCart = $this->cartRepository->create($input);
        return $this->httpOk([
            'message' => ('Product added to cart successfully'),
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
    public function show(int $id)
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
    public function update(Request $request, int $id)
    {
        $input = $this->validate($request, $this->getValidationUpdateMethod());
        return $this->httpOk([
            'message' => ('cart Updated'),
            'data' => ['user' => new CartResource(
                $this->cartRepository->update(
                    $id,
                    $input
                )
            ),
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
     * method for delete cart data
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->cartRepository->deleteCart($id);
        return $this->httpOk([
            'message' => ('Product has been removed'),
            'data' => 'true',
        ]);
    }

}
