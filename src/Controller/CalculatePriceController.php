<?php

namespace App\Controller;

use App\Dto\CalculatorDto;
use App\Services\Application\CalculatePrice;
use App\Validator\CalculatorRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class CalculatePriceController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly CalculatePrice $calculatePriceService
    ) {
    }

    #[Route('/calculate-price', name: 'app_calculate_price', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CalculatorDto $calculatorDto): JsonResponse
    {
        try {
            $violations = $this->validator->validate($calculatorDto, [new CalculatorRequest()]);

            if ($violations->count()) {
                return $this->json($violations, Response::HTTP_BAD_REQUEST);
            }

            $price = $this->calculatePriceService->calculatePrice($calculatorDto);

            return $this->json(['price' => $price->toString()]);
        } catch (Throwable $e) {
            return $this->json(
                [
                    'message' => 'An error occurred while calculating the price.'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
