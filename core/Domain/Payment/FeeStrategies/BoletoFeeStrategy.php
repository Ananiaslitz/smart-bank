<?php

namespace Core\Domain\Payment\FeeStrategies;

use Core\Domain\Payment\FeeStrategy;

class BoletoFeeStrategy implements FeeStrategy
{
    public function calculateFee(float $amount): float
    {
        return 0.02 * $amount;
    }
}
