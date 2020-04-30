<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Repositories\Auth\CartRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
     * @return JsonResponse
     */
    public function index()
    {
        return $this->httpOk([
            'data' => [
                'products' => $this->cartRepository->getProduct(),
            ],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getValidationMethod());

        $input = $request->only('name', 'quantity', 'product_id');

        try {
            $oCart = $this->cartRepository->create($input);
            return $this->httpOk([
                'message' => ('Product added to cart successfully'),
                'data' => [
                    'cart' => $oCart,
                ],
            ]);

        } catch (Exception $e) {

            throw $e;
        }
    }

    /**
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
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->httpOk([
            'data' => [
                'carts' => $this->cartRepository->show($id),
            ],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request['id'];

        $productData = Cart::findOrFail($id);

        $productData->name = $request->input('name');
        $productData->quantity = $request->input('quantity');
        $productData->product_id = $request->input('product_id');
        $productData->save();

        return $this->httpOk([
            'message' => ('Cart Updated successfully'),
            'data' => [
                'cart' => $productData,
            ],
        ]);

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function destroy(Request $request)
    {
        $this->validate($request, $this->getValidationProductDelete());

        $input = $request->only('id');

        $this->cartRepository->deleteCart($input);

        return $this->httpOk([
            'message' => ('Product has been removed'),
        ]);

    }

    /**
     * @return array|string[]
     */
    protected function getValidationProductDelete(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return Product[]|Collection
     */
    public function filter(Request $request, Product $product)
    {
        // Search by Product Name
        if ($request->has('price')) {
            return $product->where('price', $request->input('price'))->get();
        }

        return Product::all();
    }
}
