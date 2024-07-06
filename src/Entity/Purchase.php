<?php

namespace App\Entity;

use App\Doctrine\Type\PaymentProcessorTypeEnumType;
use App\Entity\Common\Money;
use App\Entity\Enums\PaymentProcessorType;
use App\Entity\Purchase\CouponPurchase;
use App\Entity\Purchase\ProductPurchase;
use App\Entity\Purchase\Tax;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
#[ORM\Table(name: 'purchases')]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: false, unique: true)]
    private string $uuid;

    #[Embedded(class: ProductPurchase::class)]
    private ProductPurchase $product;

    #[Embedded(class: Tax::class)]
    private Tax $tax;

    #[Embedded(class: CouponPurchase::class)]
    private ?CouponPurchase $coupon = null;

    #[Embedded(class: Money::class)]
    private Money $totalAmount;

    #[ORM\Column(type: PaymentProcessorTypeEnumType::PAYMENT_PROCESSOR_TYPE, nullable: false)]
    private PaymentProcessorType $paymentProcessorType;

    public function __construct(
        UuidInterface $uuid,
        ProductPurchase $product,
        Tax $tax,
        Money $totalAmount,
        PaymentProcessorType $paymentProcessorType,
        ?CouponPurchase $coupon
    ) {
        $this->uuid = $uuid->toString();
        $this->product = $product;
        $this->tax = $tax;
        $this->totalAmount = $totalAmount;
        $this->coupon = $coupon;
        $this->paymentProcessorType = $paymentProcessorType;
    }

    public function uuid(): UuidInterface
    {
        return Uuid::fromString($this->uuid);
    }

    public function totalAmount(): Money
    {
        return $this->totalAmount;
    }
}
