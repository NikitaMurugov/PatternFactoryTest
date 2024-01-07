<?php

declare(strict_types=1);

namespace App\Controller;

use App\Modules\Order\Services\OrderService;
use App\Modules\Payment\Data\CreatePaymentDTO;
use App\Modules\Payment\Enums\PayType;
use App\Modules\Payment\Services\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PaymentController extends AbstractController
{
    public function __construct(
        public OrderService $orderService,
        public PaymentService $paymentService,
    ) {
    }

    public function paymentPage(int $orderId): Response
    {
        $order = $this->orderService->find($orderId);

        if (! $order) {
            $this->addFlash('error', 'Заказ не найден');

            return $this->redirectToRoute('index_page');
        }

        $paymentTypes = $this->paymentService->getListPayTypes();

        return $this->render('pages/order/create_payment.html.twig', [
            'order' => $order,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function submitPayment(Request $request, int $orderId): RedirectResponse
    {
        $dto = new CreatePaymentDTO(
            type: (string) $request->get('paymentType'),
            price: (float) $request->get('price'),
            orderId: $orderId
        );

        try {
            $this->paymentService->save($dto);
        } catch (\Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());

            return $this->redirect($request->get('referer'));
        }

        return $this->redirectToRoute('order_show', ['orderId' => $request->get('orderId')]);
    }
}
