<?php

namespace App\Entity;

use App\Doctrine\Type\CouponEnumType;
use App\Doctrine\Type\CustomDecimalType;
use App\Entity\Enums\CouponType;
use App\Repository\CouponRepository;
use Decimal\Decimal;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $code;

    #[ORM\Column(type: CouponEnumType::COUPON_TYPE, nullable: false)]
    private CouponType $type;

    #[ORM\Column(nullable: false, type: CustomDecimalType::DECIMAL, precision: 10, scale: 2)]
    private Decimal $discount;

    #[ORM\Column(nullable: false, type: Types::INTEGER)]
    private int $quantity;

    public function __construct(
        string $code,
        CouponType $type,
        Decimal $discount,
        int $quantity
    ) {
        $this->code = $code;
        $this->type = $type;
        $this->discount = $discount;
        $this->quantity = $quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function type(): CouponType
    {
        return $this->type;
    }

    public function discount(): Decimal
    {
        return $this->discount;
    }

    public function decrementQuantity(): void
    {
        $this->quantity--;
    }
}
