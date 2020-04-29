<?php

namespace App\Http\Controllers;

use App\Product;
use App\Repositories\Auth\ProductRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
        return $this->productRepository->getProduct();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, $this->getValidationMethod());

        $input = $request->only('name', 'price', 'description');

        try {
            $oProduct = $this->productRepository->create($input);
            return response()->json(['product' => $oProduct, 'message' => 'Product Added successfully']);
        } catch (Exception $e) {

            return response()->json(['message' => 'Not Added']);
        }
    }

    /**
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
    public function show(int $id)
    {
        return $this->productRepository->show($id);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request['id'];
        $productData = Product::findOrFail($id);

        $productData->name = $request->input('name');
        $productData->price = $request->input('price');
        $productData->description = $request->input('description');
        $productData->save();
        return response()->json(['user' => $productData, 'message' => 'Product Updated']);
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

        $this->productRepository->deleteProduct($input);

        return response()->json('product deleted');
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
