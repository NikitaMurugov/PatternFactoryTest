<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Order\Repository\OrderRepository;
use App\Modules\Payment\Data\CreatePaymentDTO;
use App\Modules\Payment\Entity\Payment;
use App\Modules\Payment\Enums\PayType;
use App\Modules\Payment\Repository\PaymentRepository;
use App\Modules\Shared\Exceptions\EnumNotSupported;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class PaymentService
{
    public function __construct(
        public EntityManagerInterface $em,
        public OrderRepository $orderRepository,
        public PaymentRepository $paymentRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     * @throws EnumNotSupported
     */
    public function save(CreatePaymentDTO $createPaymentDTO): bool
    {
        $order = $this->orderRepository->find($createPaymentDTO->orderId);

        if (! $order) {
            throw new EntityNotFoundException("Order with id: {$createPaymentDTO->orderId} not found", 405);
        }

        $type = PayType::getFromString($createPaymentDTO->type);

        if (PayType::UNDEFINED === $type) {
            throw new EnumNotSupported(PayType::class, $createPaymentDTO->type, 400);
        }

        $payment = new Payment();
        $payment
            ->setPrice($createPaymentDTO->price)
            ->setType($type)
            ->setOrderEntity($order)
        ;

        $this->em->persist($payment);
        $this->em->flush();

        return true;
    }

    /** @return array<string, string> */
    public function getListPayTypes(): array
    {
        return PayType::getList();
    }
}
