<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Enums\PayType;

final class PaymentTypesService
{
    /** @return array<string, string> */
    public function getTypesList(): array
    {
        return PayType::getList();
    }
}
