<?php

namespace Core\Domain\Payment;

class FeeCalculator
{
    protected $strategies = [];

    public function __construct()
    {
        $this->strategies = [
            'pix' => new FeeStrategies\PixFeeStrategy(),
            'boleto' => new FeeStrategies\BoletoFeeStrategy(),
            'bank_transfer' => new FeeStrategies\BankTransferFeeStrategy(),
        ];
    }

    public function calculate(string $paymentMethod, float $amount): float
    {
        if (!isset($this->strategies[$paymentMethod])) {
            throw new \InvalidArgumentException("Payment method $paymentMethod not supported.");
        }

        return $this->strategies[$paymentMethod]->calculateFee($amount);
    }
}
