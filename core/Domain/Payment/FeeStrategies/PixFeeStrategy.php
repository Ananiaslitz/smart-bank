<?php

namespace Core\Domain\Payment\FeeStrategies;

use Core\Domain\Payment\FeeStrategy;

class PixFeeStrategy implements FeeStrategy
{
    public function calculateFee(float $amount): float
    {
        return 0.015 * $amount;
    }
}
