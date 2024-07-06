<?php

namespace App\Controller;

use App\Dto\PurchaseDto;
use App\Services\Application\MakePurchase;
use App\Validator\PurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class PurchaseController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly MakePurchase $purchaseService
    ) {
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] PurchaseDto $dto): JsonResponse
    {
        try {
            $violations = $this->validator->validate($dto, [new PurchaseRequest()]);

            if ($violations->count()) {
                return $this->json($violations, Response::HTTP_BAD_REQUEST);
            }

            return $this->json(
                [
                    'purchase' => $this->purchaseService->purchase($dto),
                ]
            );
        } catch (Throwable $e) {
            return $this->json(
                [
                    'message' => 'An error occurred while making the purchase.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
