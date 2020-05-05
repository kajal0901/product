<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use App\Repositories\Auth\ProductRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * ProductController constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        /**
         * sorting
         * searching
         * pagination
         */
        return $this->httpOk([
            'data' => [
                'products' => $this->productRepository->getProduct(),
            ],
        ]);
    }

    /**
     * Method for store product Information.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function create(Request $request)
    {
        $input = $this->validate($request, $this->getValidationMethod());
        $oProduct = $this->productRepository->create($input);
        return $this->httpOk([
            'message' => ('Product Added successfully'),
            'data' => [
                'product' => new ProductResource($oProduct),
            ],
        ]);
    }

    /**
     * validation method for product create
     *
     * @return array|string[]
     */
    protected function getValidationMethod(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
        ];
    }

    /**
     * method for get product data.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->httpOk([
            'data' => [
                'products' => new ProductResource(
                    $this->productRepository->show($id)
                ),
            ],
        ]);
    }

    /**
     * handle request for update product data.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        $input = $this->validate($request, $this->getUpdateMethodValidation());
        return $this->httpOk([
            'message' => ('Product Updated'),
            'data' => ['user' => new ProductResource(
                $this->productRepository->update(
                    $id,
                    $input
                )
            ),
            ],
        ]);
    }

    /**
     * validation method for update product
     *
     * @return array|string[]
     */
    protected function getUpdateMethodValidation(): array
    {
        return [
            'name' => 'sometimes|string',
            'price' => 'sometimes|integer',
            'description' => 'sometimes|integer',
        ];
    }

    /**
     * Method for product delete data.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->productRepository->deleteProduct($id);
        return $this->httpOk([
            'message' => ('product deleted successfully'),
            'data' => 'true',
        ]);
    }


    /**
     * Filter method for product field
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function filter(Request $request)
    {
        return Product::when($request->has('price'), function ($q) {
            return $q->where('price', request('price'))->get();
        })->when($request->has('description'), function ($q) {
            return $q->where('description', request('description'))->get();
        });
    }
}
