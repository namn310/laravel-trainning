<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CartController extends Controller
{
    public function index()
    {
        return view('User.CartView');
    }
    /**
     *
     * @param Request $request
     * @return ApiResponse
     */
    public function Checkout(Request $request): JsonResponse
    {
        try {
            $model = new Cart();
            $result = $model->CheckoutModel($request);
            if ($result) {
                return ApiResponse::Success(null, 'Vui lòng kiểm tra đơn hàng trong giỏ hàng', 'success', 200);
            } else {
                return ApiResponse::Error(null, 'Có lỗi xảy ra !else', 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra !catch', 'error', 500);
        }
    }
}
