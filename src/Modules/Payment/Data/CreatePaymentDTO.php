<?php

declare(strict_types=1);

namespace App\Modules\Payment\Data;

final class CreatePaymentDTO
{
    public function __construct(
        public string $type,
        public float $price,
        public int $orderId,
    ) {
    }
}
