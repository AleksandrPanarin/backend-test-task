<?php

declare(strict_types=1);

namespace App\Services\Calculator\CouponDiscount;

use App\Entity\Coupon;
use Decimal\Decimal;

final class PercentDiscountService implements CouponDiscount
{
    public function calculate(Decimal $totalAmount, Coupon $coupon): Decimal
    {
        return $totalAmount->sub($totalAmount->mul($coupon->discount()->div(100)));
    }
}