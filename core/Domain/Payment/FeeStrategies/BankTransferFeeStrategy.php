<?php

namespace Core\Domain\Payment\FeeStrategies;

use Core\Domain\Payment\FeeStrategy;

class BankTransferFeeStrategy implements FeeStrategy
{
    public function calculateFee(float $amount): float
    {
        return 0.04 * $amount;
    }
}
