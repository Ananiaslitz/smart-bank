<?php

namespace Core\Domain\Payment;

class Payment
{
    public $id;
    public $nameClient;
    public $cpf;
    public $description;
    public $amount;
    public $status;
    public $paymentMethod;
    public $fee;
    public $paidAt;

    public function __construct($id, $nameClient, $cpf, $description, $amount, $status, $paymentMethod, $paidAt = null)
    {
        $this->id = $id;
        $this->nameClient = $nameClient;
        $this->cpf = $cpf;
        $this->description = $description;
        $this->amount = $amount;
        $this->status = $status;
        $this->paymentMethod = $paymentMethod;
        $this->paidAt = $paidAt;

        $calculator = new FeeCalculator();
        $this->fee = $calculator->calculate($paymentMethod, $amount);
    }

    /**
     * Calculate the fee based on the payment method.
     *
     * @param string $paymentMethod
     * @param float $amount
     * @return float
     */
    private function calculateFee(string $paymentMethod, float $amount): float
    {
        $fees = [
            'pix' => 0.015,
            'boleto' => 0.02,
            'bank_transfer' => 0.04,
        ];

        return isset($fees[$paymentMethod]) ? $fees[$paymentMethod] * $amount : 0;
    }
}
