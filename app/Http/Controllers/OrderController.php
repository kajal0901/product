<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Repositories\Auth\OrderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderController constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * show order list
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->orderRepository->filter(
            $request->only('page',
                'perPage',
                'orderBy',
                'orderByColumn',
                'filter')
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
                    'products' => OrderResource::collection($products),
                ],
        ]);
    }

    /**
     * store order
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $input = $this->validate($request, $this->getValidationMethod());
        $order = $this->orderRepository->create($input);

        return $this->httpOk([
            'message' => __('message.order_placed'),
            'data' => [
                'Order' => new OrderResource($order),
            ],
        ]);

    }


    /**
     * validation for store order
     *
     * @return array
     */
    protected function getValidationMethod(): array
    {
        return [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'delivery_address' => 'required|string',
            'delivery_city' => 'required|string',
            'delivery_postcode' => 'required|integer',
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }

    /**
     * show order by id
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->httpOk([
            'data' => [
                'orders' => new OrderResource(
                    $this->orderRepository->show($id)
                ),
            ],
        ]);
    }

    /**
     * update order method
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
            'message' => __('message.order_updated'),
            'data' =>
                ['user' =>
                    new OrderResource(
                        $this->orderRepository->update($id, $input))
                ,],
        ]);
    }

    /**
     *
     * validation method for update order
     *
     * @return array|string[]
     */
    protected function getUpdateMethodValidation(): array
    {
        return [
            'name' => 'sometimes|string',
            'quantity' => 'sometimes|integer',
            'delivery_address' => 'sometimes|string',
            'delivery_city' => 'sometimes|string',
            'delivery_postcode' => 'sometimes|integer',
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }

    /**
     * method for delete product
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->orderRepository->delete($id);
        return $this->httpOk([
            'message' => __('message.order_deleted'),
            'data' => ['status' => true],
        ]);
    }

}
