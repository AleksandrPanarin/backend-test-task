<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DomainException;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getById(int $id): Product
    {
        $product = $this->find($id);

        if ($product === null) {
            throw new DomainException(sprintf('Product by ID: %s not found', $id));
        }

        return $product;
    }

    public function findById(int $id): ?Product
    {
        return $this->find($id);
    }

    public function update(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }
}
