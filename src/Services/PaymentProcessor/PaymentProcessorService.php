<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor;

use App\Entity\Enums\PaymentProcessorType;
use App\Services\PaymentProcessor\Adapter\PaymentProcessorResolver;
use Decimal\Decimal;

final readonly class PaymentProcessorService
{

    public function __construct(
        private PaymentProcessorResolver $paymentProcessorResolver
    ) {
    }

    public function processingPayment(Decimal $price, PaymentProcessorType $paymentProcessorType): void
    {
        $paymentProcessor = $this->paymentProcessorResolver->resolve($paymentProcessorType);

        $paymentProcessor->processingPayment($price);
    }
}