<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Entity\Enums\CouponType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

final class CouponEnumType extends Type
{
    public const string COUPON_TYPE = 'coupon_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "VARCHAR(50)";
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (! in_array($value, CouponType::values())) {
            throw new InvalidArgumentException("Invalid value '" . $value . "' for ENUM type '" . $this->getName() . "'");
        }

        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CouponType
    {
        if ($value === null) {
            return null;
        }

        return CouponType::from($value);
    }

    public function getName(): string
    {
        return self::COUPON_TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}