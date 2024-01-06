<?php

declare(strict_types=1);

namespace App\Modules\Payment\Entity;

use App\Modules\Payment\Enums\PayType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class PaymentType extends Type
{
    public const NAME = 'payment_type_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(255)';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return $value instanceof PayType ? $value->name : PayType::UNDEFINED->name;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): PayType
    {
        return PayType::getFromString($value);
    }
}
