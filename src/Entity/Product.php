<?php

namespace App\Entity;

use App\Entity\Common\Money;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Embedded(class: Money::class)]
    private Money $price;

    #[ORM\Column(length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $inStock;

    public function __construct(string $title, Money $price, int $inStock = 0)
    {
        $this->title = $title;
        $this->price = $price;
        $this->inStock = $inStock;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function decrementInStock(): void
    {
        $this->inStock--;
    }

    public function isStockEmpty(): bool
    {
        return $this->inStock <= 0;
    }
}
