<?php

namespace App\Repositories\Interface;

interface OrderRepositoryInterface
{
    public function CreateOrderRepository(int $status, string $Address, ?string $note, string $paymentMethod, int $idCus, ?string $idVoucher);
    public function getDetailOrderRepository(string $id);
    public function getTotalCostOfProductRepository(string $idOrderDetail);
    public function getTotalCostOfOrderRepository(string $idOrder);
    public function getListOrderUserRepository(int $iduser);
    public function getListInforOfOrderRepository();
    public function detailOfOrderRepository(string $idOrder);
    public function deliveryOrderRepository(string $idOrder);
}
