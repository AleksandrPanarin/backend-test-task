<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\CalculatorDto;
use App\Entity\Common\Money;

interface CalculatePrice
{
    public function calculatePrice(CalculatorDto $payload): Money;
}
