<?php

namespace Core\Domain\Payment;

interface FeeStrategy
{
    public function calculateFee(float $amount): float;
}
