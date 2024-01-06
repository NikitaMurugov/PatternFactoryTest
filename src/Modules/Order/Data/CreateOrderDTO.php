<?php

declare(strict_types=1);

namespace App\Modules\Order\Data;

final class CreateOrderDTO
{
    public function __construct(
        public ?float $totalPrice
    ) {
    }
}
