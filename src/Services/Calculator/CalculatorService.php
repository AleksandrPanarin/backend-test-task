<?php

declare(strict_types=1);

namespace App\Services\Calculator;

use App\Entity\Common\Money;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Purchase\Tax;
use App\Services\Calculator\CouponDiscount\CouponDiscountResolver;
use RuntimeException;

final readonly class CalculatorService implements Calculator
{
    public function __construct(
        private CouponDiscountResolver $couponDiscountResolver
    )
    {

    }
    public function calculate(Product $product, string $taxNumber, Coupon|null $coupon): Money
    {
        $taxPercent = Tax::definePercent($taxNumber);
        $price = $product->price();

        $totalAmount = $price->amount()
            ->mul($taxPercent->div(100))
            ->add($price->amount());

        if ($coupon !== null) {
            $discountService = $this->couponDiscountResolver->resolve($coupon->type());

            $totalAmount = $discountService->calculate($totalAmount, $coupon);

            if ($totalAmount->isZero() || $totalAmount->isNegative()) {
                throw new RuntimeException('Price after discount is zero or less.');
            }
        }

        return new Money($totalAmount, $price->currency());
    }
}