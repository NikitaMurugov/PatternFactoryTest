<?php

declare(strict_types=1);

namespace App\Controller;

use App\Modules\Order\Data\CreateOrderDTO;
use App\Modules\Order\Repository\OrderRepository;
use App\Modules\Order\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class OrderController extends AbstractController
{
    public function __construct(
        public OrderRepository $orderRepository,
        public OrderService $orderService,
    ) {
    }

    public function create(): Response
    {
        return $this->render('pages/order/create.html.twig');
    }

    public function show(Request $request, int $orderId): Response
    {
        $order = $this->orderRepository->find($orderId);

        return $this->render('pages/order/show.html.twig', ['order' => $order]);
    }

    public function submit(Request $request): Response
    {
        $dto = new CreateOrderDTO(
            totalPrice: (float) $request->get('totalPrice'),
        );

        try {
            $this->orderService->createOrder($dto);
        } catch (\Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());

            $this->addFlash('totalPrice', (float) $request->get('totalPrice'));

            return $this->redirectToRoute('order_create');
        }
        $this->addFlash('success', 'Заказ успешно создан');

        return $this->redirectToRoute('index_page');
    }
}
