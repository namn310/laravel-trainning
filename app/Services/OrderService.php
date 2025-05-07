<?php

namespace App\Services;

use App\Repositories\Interface\OrderRepositoryInterface;

class OrderService
{
    protected $OrderRepo;
    public function __construct(OrderRepositoryInterface $interface)
    {
        $this->OrderRepo = $interface;
    }
    public function createOrder(
        int $status,
        string $Address,
        ?string $note,
        string $paymentMethod,
        int $idCus,
        ?string $idVoucher
    ) {
        return $this->OrderRepo->CreateOrderRepository(
            $status,
            $Address,
            $note,
            $paymentMethod,
            $idCus,
            $idVoucher
        );
    }
    public function getListInforOfOrder()
    {
        return $this->OrderRepo->getListInforOfOrderRepository();
    }
    public function detailOfOrder(string $idOrder)
    {
        return $this->OrderRepo->detailOfOrderRepository($idOrder);
    }
    public function deliveryOrder(string $idOrder)
    {
        return $this->OrderRepo->deliveryOrderRepository($idOrder);
    }
    public function getListOrderUser(int $idUser)
    {
        return $this->OrderRepo->getListOrderUserRepository($idUser);
    }
}
