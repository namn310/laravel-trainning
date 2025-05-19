<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Cart;
use App\Repositories\Interface\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentService;
use App\Services\VNPAYPayment;
use Illuminate\Http\JsonResponse;
use Throwable;
use Symfony\Component\HttpFoundation\Response as Http;


class CartController extends Controller
{
    public function index()
    {
        return view('User.CartView');
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function Checkout(Request $request): JsonResponse
    {
        try {
            $model = new Cart(app(OrderService::class));
            $result = $model->CheckoutModel($request);
            if ($result) {
                return ApiResponse::Success(null, 'Vui lòng kiểm tra đơn hàng trong giỏ hàng', 'success', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Có lỗi xảy ra !', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @param Request $request
     * @return ApiResponse
     */
    public function createPaymentVNPay(Request $request): JsonResponse
    {
        try {
            $gatewayClass = app(VNPAYPayment::class);
            $paymentService = new PaymentService($gatewayClass);
            $urlVNPAYPayment = $paymentService->processPayment($request);
            return ApiResponse::Success($urlVNPAYPayment, 'Success', 'success', Http::HTTP_OK);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function completePaymentVNPay()
    {
        try {
        } catch (Throwable $e) {
        }
    }
}
