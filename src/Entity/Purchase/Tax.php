<?php

declare(strict_types=1);

namespace App\Entity\Purchase;

use App\Doctrine\Type\CustomDecimalType;
use Decimal\Decimal;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;
use DomainException;

#[Embeddable]
final class Tax
{
    public const array TAX_PATTERNS = [
        self::GERMANY_TAX_DEFINE_PATTERN,
        self::ITALY_TAX_DEFINE_PATTERN,
        self::FRANCE_TAX_DEFINE_PATTERN,
        self::GREECE_TAX_DEFINE_PATTERN,
    ];

    private const string GERMANY_TAX_DEFINE_PATTERN = '/^DE\d{9}$/';

    private const string ITALY_TAX_DEFINE_PATTERN = '/^IT\d{11}$/';

    private const string FRANCE_TAX_DEFINE_PATTERN = '/^FR[A-Za-z]{2}\d{9}$/';

    private const string GREECE_TAX_DEFINE_PATTERN = '/^GR\d{9}$/';

    private const string GERMANY_TAX_PERCENT = '19';

    private const string ITALY_TAX_PERCENT = '22';

    private const string FRANCE_TAX_PERCENT = '20';

    private const string GREECE_TAX_PERCENT = '24';

    #[ORM\Column(length: 255, nullable: false)]
    private string $number;

    #[ORM\Column(nullable: false, type: CustomDecimalType::DECIMAL, precision: 10, scale: 2)]
    private Decimal $percentage;

    public function __construct(string $number)
    {
        $this->number = $number;
        $this->percentage = self::definePercent($number);
    }

    public static function definePercent(string $taxNumber): Decimal
    {
        if (preg_match(self::GERMANY_TAX_DEFINE_PATTERN, $taxNumber)) {
            return new Decimal(self::GERMANY_TAX_PERCENT);
        }

        if (preg_match(self::ITALY_TAX_DEFINE_PATTERN, $taxNumber)) {
            return new Decimal(self::ITALY_TAX_PERCENT);
        }

        if (preg_match(self::FRANCE_TAX_DEFINE_PATTERN, $taxNumber)) {
            return new Decimal(self::FRANCE_TAX_PERCENT);
        }

        if (preg_match(self::GREECE_TAX_DEFINE_PATTERN, $taxNumber)) {
            return new Decimal(self::GREECE_TAX_PERCENT);
        }

        throw new DomainException('Invalid tax number.');
    }
}