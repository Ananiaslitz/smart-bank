<?php

namespace Core\Infrastructure\Services;

class PaymentProcessor
{
    /**
     * Process a payment with a 70% chance of success.
     *
     * @return bool
     */
    public function process()
    {
        // 70% chance of success
        return rand(0, 100) < 70;
    }
}
