<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Decimal\Decimal;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class CustomDecimalType extends Type
{
    public const string DECIMAL = 'custom_decimal';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'DECIMAL(' . ($column['precision'] ?: 10) . ',' . ($column['scale'] ?: 0) . ')';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Decimal
    {
        return $value !== null ? new Decimal($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value !== null ? (string) $value : null;
    }

    public function getName(): string
    {
        return self::DECIMAL;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}