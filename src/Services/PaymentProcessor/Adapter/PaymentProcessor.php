<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor\Adapter;

use Decimal\Decimal;

interface PaymentProcessor
{
    public function processingPayment(Decimal $price): void;
}
