<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\CalculatorDto;
use App\Entity\Common\Money;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Services\Calculator\Calculator;

final readonly class CalculatePriceService implements CalculatePrice
{
    public function __construct(
        private ProductRepository $products,
        private CouponRepository $coupons,
        private Calculator $calculator
    ) {
    }

    public function calculatePrice(CalculatorDto $payload): Money
    {
        $product = $this->products->findById($payload->product);
        $coupon = $this->coupons->findByCode((string) $payload->couponCode);

        return $this->calculator->calculate($product, $payload->taxNumber, $coupon);
    }
}