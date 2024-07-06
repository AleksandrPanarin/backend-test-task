<?php

declare(strict_types=1);

namespace App\Dto;

final class PurchaseDto
{
    public ?int $product = null;

    public ?string $taxNumber = null;

    public ?string $couponCode = null;

    public ?string $paymentProcessor = null;
}
