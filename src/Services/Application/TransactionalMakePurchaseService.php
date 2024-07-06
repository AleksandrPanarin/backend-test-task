<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\PurchaseDto;
use App\Dto\PurchaseViewDto;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class TransactionalMakePurchaseService implements MakePurchase
{
    public function __construct(
        private MakePurchase $service,
        private EntityManagerInterface $em
    ) {
    }

    public function purchase(PurchaseDto $dto): PurchaseViewDto
    {
        $this->em->beginTransaction();

        try {
            $view = $this->service->purchase($dto);
            $this->em->flush();
            $this->em->commit();

            return $view;
        } catch (Throwable $e) {
            $this->em->close();
            $this->em->rollback();

            throw $e;
        }
    }
}