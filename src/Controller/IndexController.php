<?php

declare(strict_types=1);

namespace App\Controller;

use App\Modules\Order\Repository\OrderRepository;
use App\Modules\Order\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends AbstractController
{
    public function __construct(
        public OrderService $orderService,
    ) {
    }

    public function index(): Response
    {
        $orders = $this->orderService->getLastOrders(20);

        return $this->render('pages/index.html.twig', ['orders' => $orders]);
    }
}
