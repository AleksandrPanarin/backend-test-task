<?php

declare(strict_types=1);

namespace App\Services\Calculator;

use App\Entity\Common\Money;
use App\Entity\Coupon;
use App\Entity\Product;

interface Calculator
{
    public function calculate(Product $product, string $taxNumber, Coupon|null $coupon): Money;
}