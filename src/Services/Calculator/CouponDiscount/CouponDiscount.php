<?php

declare(strict_types=1);

namespace App\Services\Calculator\CouponDiscount;

use App\Entity\Coupon;
use Decimal\Decimal;

interface CouponDiscount
{
    public function calculate(Decimal $totalAmount, Coupon $coupon): Decimal;
}