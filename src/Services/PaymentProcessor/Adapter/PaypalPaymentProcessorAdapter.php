<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor\Adapter;

use App\Services\PaymentProcessor\Exception\PaymentProcessingFailed;
use Decimal\Decimal;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

final readonly class PaypalPaymentProcessorAdapter implements PaymentProcessor
{
    public function processingPayment(Decimal $price): void
    {
        try {
            $convertedPrice = (int) $price->toString();

            (new PaypalPaymentProcessor())->pay($convertedPrice);
        } catch (Throwable $e) {
            throw new PaymentProcessingFailed(
                sprintf('Paypal processing payment is failed with message: %s', $e->getMessage()), 0, $e
            );
        }
    }
}