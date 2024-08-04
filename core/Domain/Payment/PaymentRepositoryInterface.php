<?php

namespace Core\Domain\Payment;

interface PaymentRepositoryInterface
{
    public function findAll();
    public function findById($id);
    public function save(Payment $payment);
}
