<?php

declare(strict_types=1);

namespace App\Entity\Purchase;

use App\Entity\Common\Money;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;

#[Embeddable]
final class ProductPurchase
{
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private string $title;

    #[Embedded(class: Money::class)]
    private Money $price;

    public function __construct(int $id, string $title, Money $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }
}