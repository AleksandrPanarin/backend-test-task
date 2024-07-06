<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor\Adapter;

use App\Entity\Enums\PaymentProcessorType;

final readonly class PaymentProcessorResolver
{
    public function __construct(
        private PaypalPaymentProcessorAdapter $paypalPaymentProcessorAdapter,
        private StripePaymentProcessorAdapter $stripePaymentProcessorAdapter,
    )
    {

    }
    public function resolve(PaymentProcessorType $paymentProcessorType): PaymentProcessor
    {
        return match ($paymentProcessorType) {
            PaymentProcessorType::PAYPAL => $this->paypalPaymentProcessorAdapter,
            PaymentProcessorType::STRIPE => $this->stripePaymentProcessorAdapter,
        };
    }
}