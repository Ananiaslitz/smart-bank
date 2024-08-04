<?php

namespace Core\Application\Payment\Handlers;

use Core\Application\Payment\Commands\CreatePaymentCommand;
use Core\Domain\Payment\Payment;
use Core\Domain\Payment\PaymentRepositoryInterface;
use Core\Infrastructure\Exceptions\GatewayException;
use Core\Infrastructure\Services\PaymentProcessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreatePaymentHandler
{
    protected $paymentRepository;
    private PaymentProcessor $paymentProcess;
    const VALUE_TO_ACCEPT_A_PAYMENT = 70;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        PaymentProcessor $paymentProcessor
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->paymentProcess = $paymentProcessor;
    }

    public function handle(CreatePaymentCommand $command)
    {
        $payment = new Payment(
            (string) Str::uuid(),
            $command->nameClient,
            $command->cpf,
            $command->description,
            $command->amount,
            'pending',
            $command->paymentMethod
        );

        if ($this->paymentProcess->process() >= self::VALUE_TO_ACCEPT_A_PAYMENT) {
            throw new GatewayException();
        }


        $this->paymentRepository->save($payment);

        $this->processPayment($payment);

        return $payment;
    }

    private function processPayment(Payment $payment)
    {
        $success = rand(0, 100) < 70;

        if ($success) {
            $payment->status = 'paid';
            $payment->paidAt = now();
            $merchant = Auth::user();
            $fee = $this->calculateFee($payment->paymentMethod, $payment->amount);
            $merchant->balance += ($payment->amount - $fee);
            $merchant->save();
        } else {
            $payment->status = 'failed';
        }

        $this->paymentRepository->save($payment);
    }

    private function calculateFee($method, $amount)
    {
        switch ($method) {
            case 'pix':
                return $amount * 0.015;
            case 'boleto':
                return $amount * 0.02;
            case 'bank_transfer':
                return $amount * 0.04;
            default:
                return 0;
        }
    }
}
