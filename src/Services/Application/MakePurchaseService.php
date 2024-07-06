<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\PurchaseAssembler;
use App\Dto\PurchaseDto;
use App\Dto\PurchaseViewDto;
use App\Entity\Enums\PaymentProcessorType;
use App\Entity\Purchase;
use App\Entity\Purchase\CouponPurchase;
use App\Entity\Purchase\ProductPurchase;
use App\Entity\Purchase\Tax;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Services\Calculator\Calculator;
use App\Services\PaymentProcessor\PaymentProcessorService;
use Ramsey\Uuid\Uuid;

final readonly class MakePurchaseService implements MakePurchase
{
    public function __construct(
        private ProductRepository $products,
        private CouponRepository $coupons,
        private Calculator $calculator,
        private PurchaseRepository $purchases,
        private PurchaseAssembler $assembler,
        private PaymentProcessorService $paymentProcessorService
    ) {
    }

    public function purchase(PurchaseDto $dto): PurchaseViewDto
    {
        $product = $this->products->getById($dto->product);
        $coupon = $this->coupons->findByCode((string) $dto->couponCode);

        $totalAmount = $this->calculator->calculate($product, $dto->taxNumber, $coupon);

        $paymentProcessorType = PaymentProcessorType::from($dto->paymentProcessor);

        $this->paymentProcessorService->processingPayment($totalAmount->amount(), $paymentProcessorType);

        $purchaseCoupon = null;
        if ($coupon !== null) {
            $purchaseCoupon = new CouponPurchase($coupon->code(), $coupon->type(), $coupon->discount());
            $coupon->decrementQuantity();
            $this->coupons->update($coupon);
        }

        $product->decrementInStock();
        $this->products->update($product);

        $purchaseUuid = Uuid::uuid4();
        $purchase = new Purchase(
            $purchaseUuid,
            new ProductPurchase($product->getId(), $product->title(), $product->price()),
            new Tax($dto->taxNumber),
            $totalAmount,
            $paymentProcessorType,
            $purchaseCoupon
        );

        $this->purchases->add($purchase);

        return $this->assembler->toPurchaseViewDto($purchase);
    }
}