<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\HttpFoundation\Response as Http;

class OrderController extends Controller
{
    protected $Order;
    protected $OrderService;
    public function __construct(Order $order, OrderService $service)
    {
        $this->Order = $order;
        $this->OrderService = $service;
    }
    public function index()
    {
        $Order = $this->OrderService->getListInforOfOrder();
        return view('Admin.OrderView', ['Order' => $Order]);
    }
    /**
     * get detail order
     * @param string $idOrder
     * @return ApiResponse|view
     */
    public function getDetailOrder(string $idOrder)
    {
        try {
            $result = $this->OrderService->detailOfOrder($idOrder);
            Log::info($result);
            if ($result) {
                return view('Admin.DetailOrderView', ['order' => $result]);
            }
            return ApiResponse::Error(null, 'Error', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            Log::error($e);
            return ApiResponse::Error(null, 'Có lỗi xảy ra', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * get detail order
     * @param string $idOrder
     * @return ApiResponse
     */
    public function delivery(string $id): JsonResponse
    {
        try {
            $result = $this->OrderService->deliveryOrder($id);
            if ($result) {
                return ApiResponse::Success(null, 'Success', 'success', Http::HTTP_OK);
            }
            return ApiResponse::Error(null, 'Error', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $e) {
            return ApiResponse::Error(null, 'Error', 'error', Http::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
