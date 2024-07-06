<?php

declare(strict_types=1);

namespace App\Entity\Enums;

enum Currency: string
{
    case EUR = 'EUR';

    public static function values(): array
    {
        return [
            self::EUR,
        ];
    }

    public function value(): string
    {
        return $this->value;
    }
}
