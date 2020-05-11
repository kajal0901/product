<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->productRepository->filter(
            $request->only('page', 'perPage', 'orderBy', 'orderByColumn', 'filter')
        );
        return $this->httpOk([
            'data' =>
                [
                    'current_page' => $products->currentPage(),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                    'products' => ProductResource::collection($products),
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
    public function create(Request $request): JsonResponse
    {
        $input = $this->validate($request, $this->getValidationMethod());
        $oProduct = $this->productRepository->create($input);
        return $this->httpOk([
            'message' => __('message.product_added_successfully'),
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
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
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
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $input = $this->validate($request, $this->getUpdateMethodValidation());
        return $this->httpOk([
            'message' => __('message.product_updated'),
            'data' => ['user' => new ProductResource($this->productRepository->update($id, $input)
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
    public function destroy(int $id): JsonResponse
    {
        $this->productRepository->delete($id);
        return $this->httpOk([
            'message' => __('message.product_deleted'),
            'data' => ['product' => $this->productRepository->getDeletedRecord($id)],
        ]);
    }

}
