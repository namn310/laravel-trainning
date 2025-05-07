<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Throwable;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\Response as Http;

class CategoryController extends Controller
{
    protected $CategoryService;
    public function __construct(CategoryService $categorySer)
    {
        $this->CategoryService = $categorySer;
    }
    public function index()
    {
        $category = $this->CategoryService->getAllHasPaginate();
        return view('Admin.CategoryView')->with('category', $category);
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->CategoryService->createCategory($request);
            if (is_array($result)) {
                return ApiResponse::Error($result, 'Thêm danh mục thành công', 'success', Http::HTTP_OK);
            }
            if ($result == 'Category has existed !') {
                return ApiResponse::Success($result, 'Danh mục đã tồn tại !', 'error', Http::HTTP_OK);
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
    public function delete(Request $request): JsonResponse
    {
        try {
            $result = $this->CategoryService->deleteCategory($request);
            if ($result == 'true') {
                return ApiResponse::Success(null, "Xóa danh mục thành công", 'success', Http::HTTP_OK);
            }
            if ($result == 'Not Found') {
                return ApiResponse::Success(null, "Danh mục không tồn tại", 'error', Http::HTTP_OK);
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
    public function update(Request $request): JsonResponse
    {
        try {
            $result = $this->CategoryService->updateCategory($request->idCat, $request->only('name'));
            if ($result === 'success') {
                return ApiResponse::Success(null, "Cập nhật danh mục thành công", 'success', Http::HTTP_OK);
            }
            if ($result === 'Not Found') {
                return ApiResponse::Success(null, "Danh mục không tồn tại", 'error', Http::HTTP_OK);
            }
            if ($result === 'Name has existed') {
                return ApiResponse::Success(null, "Danh mục đã tồn tại", 'error', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
