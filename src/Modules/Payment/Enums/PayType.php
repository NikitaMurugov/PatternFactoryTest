<?php

declare(strict_types=1);

namespace App\Modules\Payment\Enums;

enum PayType: string
{
    case CREDIT_CARD = 'Кредитка';
    case CASH = 'Наличные';
    case UNDEFINED = 'Не определён';

    public static function getFromString(string $code): self
    {
        foreach (self::cases() as $status) {
            if (in_array($code, [$status->name, $status->value])) {
                return $status;
            }
        }

        return self::UNDEFINED;
    }

    /** @return array<string, string> */
    public static function getList(): array
    {
        $cases = [];

        foreach (self::cases() as $case) {
            if (self::UNDEFINED === $case) {
                continue;
            }

            $cases[$case->name] = $case->value;
        }

        return $cases;
    }
}
