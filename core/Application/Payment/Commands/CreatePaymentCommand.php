<?php

namespace Core\Application\Payment\Commands;

class CreatePaymentCommand
{
    public $nameClient;
    public $cpf;
    public $description;
    public $amount;
    public $paymentMethod;

    public function __construct($nameClient, $cpf, $description, $amount, $paymentMethod)
    {
        $this->nameClient = $nameClient;
        $this->cpf = $cpf;
        $this->description = $description;
        $this->amount = $amount;
        $this->paymentMethod = $paymentMethod;
    }
}
