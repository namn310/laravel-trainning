<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderUserCollection;
use App\Services\OrderService;

class OrderUserController extends Controller
{
    protected $OrderService;
    public function __construct(OrderService $service)
    {
        $this->OrderService = $service;
    }
    public function getOrderList()
    {
        $idCus = Auth::user()->id;
        $Order = $this->OrderService->getListOrderUser($idCus);
        return view('User.OrderView', ['Order' => $Order]);
    }
}
