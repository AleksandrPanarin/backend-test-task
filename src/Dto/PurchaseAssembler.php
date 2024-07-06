<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Purchase;

final class PurchaseAssembler
{
    public function toPurchaseViewDto(Purchase $purchase): PurchaseViewDto
    {
        $dto = new PurchaseViewDto();
        $dto->uuid = $purchase->uuid()->toString();
        $dto->totalAmount = $purchase->totalAmount()->toString();

        return $dto;
    }
}