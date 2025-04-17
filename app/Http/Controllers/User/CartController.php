<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentService;
use App\Services\VNPAYPayment;
use Illuminate\Http\JsonResponse;
use Throwable;

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
            $model = new Cart();
            $result = $model->CheckoutModel($request);
            if ($result) {
                return ApiResponse::Success(null, 'Vui lòng kiểm tra đơn hàng trong giỏ hàng', 'success', 200);
            }
            return ApiResponse::Error(null, 'Có lỗi xảy ra !else', 'error', 500);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Có lỗi xảy ra !catch', 'error', 500);
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
            return ApiResponse::Success($urlVNPAYPayment, 'Success', 'success', 200);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', 500);
        }
    }
    public function completePaymentVNPay(){
        try{

        }
        catch(Throwable $e){
            
        }
    }
}
