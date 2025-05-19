<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\HttpFoundation\Response as Http;


class ProductUserController extends Controller
{
    protected $ProductService;
    protected $CategoryService;
    public function __construct(ProductService $servicePro, CategoryService $serviceCat)
    {
        $this->ProductService = $servicePro;
        $this->CategoryService = $serviceCat;
    }
    public function index($id)
    {
        if (is_numeric($id)) {
            $products = $this->ProductService->getListProductByCategory($id);
            $category = $this->CategoryService->getAllNoPaginate();
            return view('User.product', ['products' => $products, 'category' => $category]);
        } else {
            $categoryFist = Category::first();
            $idCatFirst = $categoryFist->idCat;
            $products = $this->ProductService->getListProductByCategory($idCatFirst);
            $category = $this->CategoryService->getAllNoPaginate();
            return view('User.ProductView', ['products' => $products, 'category' => $category]);
        }
    }
    public function getProductAjax()
    {
        try {
            $firstIdCat = Category::select('idCat')->first();
            $field = $_GET['field'] ?? 'idPro';
            $sort = $_GET['sort'] ?? 'desc';
            $idCat = ($_GET['category'] && is_numeric($_GET['category'])) ? $_GET['category'] : $firstIdCat->idCat;
            $product = $this->ProductService->getListProductBySort($idCat, $field, $sort);
            return ApiResponse::Error($product, 'Thành công', 'success', Http::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getDetail($id, $name)
    {
        try {
            $product = $this->ProductService->getDetailProduct($id);
            $productRelated = $this->ProductService->getRelatedProduct($id);
            return view("User.ProductDetailView", ['product' => $product, 'productRelated' => $productRelated]);
        } catch (Throwable $e) {
            Log::error($e);
            return view("template.404_NOT_FOUND");
        }
    }
}
