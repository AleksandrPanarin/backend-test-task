<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Entity\Enums\PaymentProcessorType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

final class PaymentProcessorTypeEnumType extends Type
{
    public const string PAYMENT_PROCESSOR_TYPE = 'payment_processor_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "VARCHAR(50)";
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (! in_array($value, PaymentProcessorType::values())) {
            throw new InvalidArgumentException("Invalid value '" . $value . "' for ENUM type '" . $this->getName() . "'");
        }

        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PaymentProcessorType
    {
        return PaymentProcessorType::from($value);
    }

    public function getName(): string
    {
        return self::PAYMENT_PROCESSOR_TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}