<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Dto\PurchaseDto;
use App\Dto\PurchaseViewDto;
use Psr\Log\LoggerInterface;
use Throwable;

final readonly class LoggableMakePurchaseService implements MakePurchase
{
    public function __construct(
        private MakePurchase $service,
        private LoggerInterface $logger
    ) {
    }

    public function purchase(PurchaseDto $dto): PurchaseViewDto
    {
        try {
            return $this->service->purchase($dto);
        } catch (Throwable $e) {
            $this->logger->error(
                'An error occurred during purchase.',
                [
                    'product' => $dto->product,
                    'tax_number' => $dto->taxNumber,
                    'coupon_code' => $dto->couponCode,
                    'payment_processor' => $dto->paymentProcessor,
                    'message' => $e->getMessage(),
                    'exception' => $e->getTrace(),
                ]
            );

            throw $e;
        }
    }
}