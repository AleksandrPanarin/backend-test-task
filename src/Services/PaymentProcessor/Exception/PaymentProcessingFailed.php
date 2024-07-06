<?php

declare(strict_types=1);

namespace App\Services\PaymentProcessor\Exception;

use RuntimeException;

final class PaymentProcessingFailed extends RuntimeException
{
}