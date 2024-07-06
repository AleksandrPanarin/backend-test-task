<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\PurchaseDto;
use App\Dto\PurchaseViewDto;

interface MakePurchase
{
    public function purchase(PurchaseDto $dto): PurchaseViewDto;
}