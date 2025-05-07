<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ListProductCollection;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Http;


class ProductController extends Controller
{
    protected $product;
    protected $ProductService;
    public function __construct(Product $product, ProductService $productService)
    {
        $this->product = $product;
        $this->ProductService = $productService;
    }
    public function index()
    {
        $products = $this->ProductService->getListProductInAdmin();
        return view('Admin.ProductView', [
            'product' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(), // total pages
            'total' => $products->total(), // // total product
            'per_page' => $products->perPage(),
        ]);
    }
    /**
     * @param Request $request 
     * @return ListProductCollection|null 
     */
    public function indexAjax(): ListProductCollection|null
    {
        try {
            $products = $this->ProductService->getListProductInAdmin();
            return new ListProductCollection($products);
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function create()
    {
        $category = $this->ProductService->getListCategory();
        return view('Admin.CreateProductView', ['category' => $category]);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->ProductService->StoreProduct($request);
            if ($result) {
                return ApiResponse::Success(null, "Thêm sản phẩm thành công", 'success', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @param string $id
     * @param string $name
     * @return view
     */
    public function edit(string $id, string $name)
    {
        $result = $this->ProductService->getDetailProductToUpdate($id, $name);
        return view('Admin.ChangeProductView', ['product' => $result['product'], 'category' => $result['category'], 'nameCat' => $result['nameCat']]);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $result = $this->ProductService->delete($request);
            if ($result) {
                return ApiResponse::Success(null, "Xóa sản phẩm thành công", 'success', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $result = $this->ProductService->update($id, $request);
            if ($result === 'success') {
                return ApiResponse::Success(null, "Cập nhật sản phẩm thành công", 'success', Http::HTTP_OK);
            }
            if ($result === 'Not Found') {
                return ApiResponse::Success(null, "Not Found", 'error', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function deleteImageProduct(Request $request): JsonResponse
    {
        try {
            $result = $this->ProductService->deleteImageProduct($request->id);
            if ($result) {
                return ApiResponse::Success(null, "Xóa ảnh thành công", 'success', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @param Request $request
     * @return ApiResponse|ListProductCollection
     */
    public function findProductByName(Request $request): JsonResponse|ListProductCollection
    {
        try {
            $result = $this->ProductService->getListProductByName($request->text);
            return new ListProductCollection($result);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
