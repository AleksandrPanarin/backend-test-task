<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Entity\Enums\Currency;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

final class CurrencyEnumType extends Type
{
    public const string CURRENCY_TYPE = 'currency_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return "VARCHAR(50)";
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (! in_array($value, Currency::values())) {
            throw new InvalidArgumentException("Invalid value '" . $value . "' for ENUM type '" . $this->getName() . "'");
        }

        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Currency
    {
        return Currency::from($value);
    }

    public function getName(): string
    {
        return self::CURRENCY_TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}