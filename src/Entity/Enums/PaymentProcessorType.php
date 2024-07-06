<?php

declare(strict_types=1);

namespace App\Entity\Enums;

enum PaymentProcessorType: string
{
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';

    public static function values(): array
    {
        return [
            self::STRIPE,
            self::PAYPAL,
        ];
    }

    public function value(): string
    {
        return $this->value;
    }
}
