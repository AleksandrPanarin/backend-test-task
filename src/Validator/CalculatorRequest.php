<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class CalculatorRequest extends Constraint
{
    public string $fieldConNotBeEmptyMessage = 'The field "{{ value }}" cannot be empty.';
    public string $productNotFoundMessage = 'Product with id "{{ value }}" not found.';
    public string $couponNotFoundMessage = 'Coupon with code "{{ value }}" not found.';
    public string $textNumberIsInvalidMessage = 'The field textNumber "{{ value }}" is invalid.';
}
