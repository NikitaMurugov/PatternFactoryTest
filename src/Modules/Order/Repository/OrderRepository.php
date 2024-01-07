<?php

declare(strict_types=1);

namespace App\Modules\Order\Repository;

use App\Modules\Order\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @noinspection PhpMultipleClassDeclarationsInspection
 */
final class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return array<array-key, Order>
     */
    public function findLatestOrders(int $count = 10): array
    {
        $query = $this
            ->createQueryBuilder('o')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults($count);

        return $query
            ->getQuery()
            ->getResult();
    }
}
