<?php

declare(strict_types=1);

namespace App\Modules\Order\Services;

use App\Modules\Order\Data\CreateOrderDTO;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

final readonly class OrderService
{
    public function __construct(
        public EntityManagerInterface $em,
        public OrderRepository $orderRepository,
    ) {
    }

    public function createOrder(CreateOrderDTO $createOrderDTO): bool
    {
        $order = (new Order())
            ->setTotalPrice($createOrderDTO->totalPrice);

        $this->em->persist($order);
        $this->em->flush();

        return true;
    }

    /**
     * @return array<array-key, Order>
     *
     * @throws NonUniqueResultException
     */
    public function getLastOrders(int $count = 10): array
    {
        return $this->orderRepository->findLatestOrders($count);
    }
}
