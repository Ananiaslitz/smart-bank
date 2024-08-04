<?php

namespace Core\Infrastructure\Repositories;

use Core\Domain\Payment\Payment;
use Core\Domain\Payment\PaymentRepositoryInterface;
use Core\Infrastructure\Models\PaymentModel;

class PaymentRepository implements PaymentRepositoryInterface
{
    protected $model;

   public function __construct(PaymentModel $model)
   {
       $this->model = $model;
   }

    public function findAll()
    {
        return $this->model::all()->map(function ($paymentModel) {
            return $this->toDomain($paymentModel);
        });
    }

    public function findById($id): Payment
    {
        $paymentModel = $this->model::findOrFail($id);
        return $this->toDomain($paymentModel);
    }

    public function save(Payment $payment): Payment
    {
        $paymentModel = $this->model::updateOrCreate(
            ['id' => $payment->id],
            [
                'name_client' => $payment->nameClient,
                'cpf' => $payment->cpf,
                'description' => $payment->description,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'payment_method' => $payment->paymentMethod,
                'paid_at' => $payment->paidAt
            ]
        );

        return $this->toDomain($paymentModel);
    }

    private function toDomain(PaymentModel $paymentModel): Payment
    {
        return new Payment(
            $paymentModel->id,
            $paymentModel->name_client,
            $paymentModel->cpf,
            $paymentModel->description,
            $paymentModel->amount,
            $paymentModel->status,
            $paymentModel->payment_method,
            $paymentModel->paid_at
        );
    }
}
