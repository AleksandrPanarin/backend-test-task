<?php

namespace App\Entity\Purchase;

use App\Doctrine\Type\CouponEnumType;
use App\Doctrine\Type\CustomDecimalType;
use App\Entity\Enums\CouponType;
use Decimal\Decimal;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class CouponPurchase
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: CouponEnumType::COUPON_TYPE, nullable: true)]
    private ?CouponType $type = null;

    #[ORM\Column(type: CustomDecimalType::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?Decimal $discount = null;

    public function __construct(
        string $code,
        CouponType $type,
        Decimal $discount
    ) {
        $this->code = $code;
        $this->type = $type;
        $this->discount = $discount;
    }
}
