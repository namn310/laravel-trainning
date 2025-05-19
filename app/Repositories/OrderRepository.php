<?php

namespace App\Repositories;

use App\Repositories\Interface\OrderRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\Order;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class OrderRepository implements OrderRepositoryInterface
{
    protected $ProductService;
    public function __construct(ProductService $service)
    {
        $this->ProductService = $service;
    }
    /**
     * Create new order
     *
     * @param int $status : Status of order (ví dụ: 0 - pending, 1 - confirmed, v.v.)
     * @param string $Address : Customer's delivery address.
     * @param string $note : note of Order (can be null).
     * @param string $paymentMethod 
     * @param int $idCus Customer's ID.
     * @param string $idVoucher Voucher code if has.
     *
     * @return Order|null
     */
    public function CreateOrderRepository(int $status, string $Address, ?string $note, string $paymentMethod, int $idCus, ?string $idVoucher): ?Order
    {
        try {
            DB::beginTransaction();
            $order = new Order();
            $order->status = $status;
            $order->address = $Address;
            $order->note = $note;
            $order->thanhtoan = $paymentMethod;
            $order->idCus = $idCus;
            $order->idVoucher = $idVoucher ?? null;
            $order->save();
            DB::commit();
            return $order;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return null;
        }
    }
    public function getDetailOrderRepository(string $id)
    {
        try {
            $OrderDetail = OrderDetail::where('idOrder', $id)->get();
            foreach ($OrderDetail as $row) {
                $row['ProductDetail'] = $this->ProductService->getDetailProduct($row->idPro);
                $row['TotalCostOfProduct'] = $this->getTotalCostOfProductRepository($row->id);
            }
            return $OrderDetail;
        } catch (Throwable $e) {
            Log::error("GetDetailproduct2" . $e);
            return null;
        }
    }
    /**
     *  get total cost of each product in order
     * @param string $idOrderDetail
     * @return string|null
     */
    public function getTotalCostOfProductRepository(string $idOrderDetail): ?string
    {
        try {
            $orderDetail = OrderDetail::where('id', $idOrderDetail)
                ->select(
                    'id',
                    'idPro',
                    'number',
                    'price'
                )->first();
            $discountProduct = $this->ProductService->getDiscountProduct($orderDetail->idPro);
            if ($discountProduct > 0) {
                return number_format(($orderDetail->price - ($orderDetail->price * ($discountProduct) / 100)) * $orderDetail->number);
            }
            return number_format($orderDetail->price * $orderDetail->number);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
    /**
     * get total cost of Order
     * @param string $idOrderDetail
     * @return int|null
     */
    public function getTotalCostOfOrderRepository(string $idOrder): ?int
    {
        try {
            $order = OrderDetail::where('idOrder', $idOrder)
                ->select(
                    'idOrder',
                    'number',
                    'price',
                    'idPro'
                )->get();
            $totalCostOfOrder = 0;
            foreach ($order as $row) {
                $discountProduct = $this->ProductService->getDiscountProduct($row->idPro);
                if ($discountProduct > 0) {
                    $totalCostOfOrder += ($row->price - ($row->price * ($discountProduct) / 100)) * $row->number;
                } else {
                    $totalCostOfOrder += $row->number * $row->price;
                }
            }
            return $totalCostOfOrder;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * get list order of user
     * @param int $idOrder
     * @return \Illuminate\Support\Collection|null
     */
    public function getListOrderUserRepository(int $iduser): ?Collection
    {
        try {
            $order = Order::where('idCus', $iduser)
                ->orderBy("created_at", 'desc')
                ->get();
            foreach ($order as $row) {
                $row['totalCost'] = number_format($this->getTotalCostOfOrderRepository($row->id));
                $row['OrderDetail'] = $this->getDetailOrderRepository($row->id);
            }
            return $order;
        } catch (Throwable $e) {
            return null;
        }
    }
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function getListInforOfOrderRepository(): ?LengthAwarePaginator
    {
        try {
            $Query = DB::table("orders as o")
                ->join('users as u', 'u.id', '=', 'o.idCus')
                ->select(
                    'o.id',
                    'o.status',
                    'o.created_at',
                    'o.idCus as IdCusInOrder',
                    'u.id as IdCusInUser',
                    'u.name',
                    'u.phone'
                )
                ->paginate(20);
            return $Query;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * Get detail order include:
     * - Information of Order
     * - Products in order
     * - Total cost
     * - Information of customer
     *
     * @param string $idOrder
     * @return \Illuminate\Database\Eloquent\Model|null 
     */
    public function detailOfOrderRepository(string $idOrder): ?Model
    {
        try {
            $order = Order::where('id', $idOrder)->first();
            $user = new User();
            $DetailUser = $user->getDetailUser($order->idCus);
            $order['totalCost'] = number_format($this->getTotalCostOfOrderRepository($order->id));
            $order['OrderDetail'] = $this->getDetailOrderRepository($order->id);
            $order['UserInfo'] = $DetailUser;
            Log::info($order);
            return $order;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * confirm delevery order
     * @param string id
     * @return bool
     */
    public function deliveryOrderRepository(string $idOrder): bool
    {
        try {
            DB::beginTransaction();
            $order = Order::find($idOrder);
            $order->status = 1;
            $order->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            return false;
        }
    }
}
