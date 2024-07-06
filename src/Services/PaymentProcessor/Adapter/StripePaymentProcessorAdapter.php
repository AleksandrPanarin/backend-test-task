<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor\Adapter;

use App\Services\PaymentProcessor\Exception\PaymentProcessingFailed;
use Decimal\Decimal;
use RuntimeException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;
use Throwable;

final readonly class StripePaymentProcessorAdapter implements PaymentProcessor
{
    public function processingPayment(Decimal $price): void
    {
        try {
            $convertedPrice = (float) $price->toString();
            $successfulPayment = (new StripePaymentProcessor())->processPayment($convertedPrice);

            if ($successfulPayment === false) {
                throw new RuntimeException('Stripe processing payment is failed.');
            }
        } catch (Throwable $e) {
            throw new PaymentProcessingFailed(
                sprintf('Stripe processing payment is failed with message: %s', $e->getMessage()), 0, $e
            );
        }
    }
}