<?php

declare(strict_types=1);

namespace App\Entity\Common;

use App\Doctrine\Type\CurrencyEnumType;
use App\Doctrine\Type\CustomDecimalType;
use App\Entity\Enums\Currency;
use Decimal\Decimal;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class Money
{
    #[ORM\Column(nullable: false, type: CustomDecimalType::DECIMAL, precision: 10, scale: 2)]
    private Decimal $amount;

    #[ORM\Column(nullable: false, type: CurrencyEnumType::CURRENCY_TYPE)]
    private Currency $currency;

    public function __construct(Decimal $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount(): Decimal
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function toString():string
    {
        $amount = $this->amount->round(2);

        return $amount->toString() . ' ' . $this->currency->value();
    }
}