<?php

namespace App\DataFixtures;

use App\Entity\Common\Money;
use App\Entity\Coupon;
use App\Entity\Enums\CouponType;
use App\Entity\Enums\Currency;
use App\Entity\Product;
use Decimal\Decimal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productTitles = [
            'Iphone',
            'Наушники',
            'Чехол',
        ];

        foreach ($productTitles as $title) {
            $price = rand(10, 1000);
            $inStock = rand(10, 30);
            $product = new Product($title, new Money(new Decimal(sprintf('%.2f', (string) $price)), Currency::EUR), $inStock);
            $manager->persist($product);
        }

        $couponCodes = [
            'P10' => new Decimal('10.00'),
            'P20' => new Decimal('20.00'),
            'P30' => new Decimal('30.00'),
            'P40' => new Decimal('40.00'),
            'P50' => new Decimal('50.00'),
            'F15' => new Decimal('15.00'),
            'F25' => new Decimal('25.00'),
            'F35' => new Decimal('35.00'),
            'F45' => new Decimal('45.00'),
            'F55' => new Decimal('55.00'),
        ];

        foreach ($couponCodes as $code => $discount) {
            $couponType = str_contains($code, 'P') ? CouponType::IN_PERCENTAGE_DISCOUNT : CouponType::FIXED_DISCOUNT;
            $quantity = rand(10, 30);
            $coupon = new Coupon($code, $couponType, $discount, $quantity);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
