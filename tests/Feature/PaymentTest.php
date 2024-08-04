<?php

namespace Tests\Feature;

use Core\Infrastructure\Models\PaymentMethod;
use Core\Infrastructure\Models\PaymentModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_payment()
    {
        $paymentMethod = PaymentMethod::create(['name' => 'Pix', 'slug' => 'pix']);

        $response = $this->postJson('/api/payments', [
            'name_client' => 'John Doe',
            'cpf' => '12345678909',
            'amount' => 100,
            'payment_method' => 'pix',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', ['name_client' => 'John Doe']);
    }

    public function test_list_payments()
    {
        $response = $this->getJson('/api/payments');
        $response->assertStatus(200);
    }

    public function test_show_payment()
    {
        $payment = PaymentModel::factory()->create();

        $response = $this->getJson("/api/payments/{$payment->id}");
        $response->assertStatus(200);
    }
}
