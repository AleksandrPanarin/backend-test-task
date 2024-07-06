<?php

namespace App\Validator;

use App\Dto\CalculatorDto;
use App\Entity\Purchase\Tax;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CalculatorRequestValidator extends ConstraintValidator
{
    private ProductRepository $products;
    private CouponRepository $coupons;

    public function __construct(ProductRepository $products, CouponRepository $coupons)
    {
        $this->products = $products;
        $this->coupons = $coupons;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof CalculatorRequest) {
            throw new UnexpectedTypeException($constraint, CalculatorRequest::class);
        }

        if (! $value instanceof CalculatorDto) {
            throw new UnexpectedValueException($value, CalculatorDto::class);
        }

        if (empty($value->product) || empty($value->taxNumber)) {
            if (empty($value->product)) {
                $this->context
                    ->buildViolation($constraint->fieldConNotBeEmptyMessage)
                    ->setParameter('{{ value }}', 'product')
                    ->addViolation();
            }

            if (empty($value->taxNumber)) {
                $this->context
                    ->buildViolation($constraint->fieldConNotBeEmptyMessage)
                    ->setParameter('{{ value }}', 'taxNumber')
                    ->addViolation();
            }

            return;
        }

        $product = $this->products->findById($value->product);

        if ($product === null) {
            $this->context
                ->buildViolation($constraint->productNotFoundMessage)
                ->setParameter('{{ value }}', $value->product)
                ->addViolation();
        }

        if ($value->couponCode !== null) {
            $coupon = $this->coupons->findOneBy(['code' => $value->couponCode]);

            if ($coupon === null) {
                $this->context
                    ->buildViolation($constraint->couponNotFoundMessage)
                    ->setParameter('{{ value }}', $value->couponCode)
                    ->addViolation();
            }
        }

        foreach (Tax::TAX_PATTERNS as $pattern) {
            if (preg_match($pattern, $value->taxNumber)) {
                return;
            }
        }

        $this->context
            ->buildViolation($constraint->textNumberIsInvalidMessage)
            ->setParameter('{{ value }}', $value->taxNumber)
            ->addViolation();
    }
}
