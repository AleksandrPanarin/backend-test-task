<?php

declare(strict_types=1);

namespace App\Services\Calculator\CouponDiscount;

use App\Entity\Enums\CouponType;

final readonly class CouponDiscountResolver
{
    public function __construct(
        private FixedDiscountService $fixedDiscountService,
        private PercentDiscountService $percentDiscountService,
    ) {
    }

    public function resolve(CouponType $type): CouponDiscount
    {
        return match ($type) {
            CouponType::FIXED_DISCOUNT => $this->fixedDiscountService,
            CouponType::IN_PERCENTAGE_DISCOUNT => $this->percentDiscountService,
        };
    }
}