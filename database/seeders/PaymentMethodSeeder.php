<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = [
            ['name' => 'Pix', 'slug' => 'pix'],
            ['name' => 'Boleto', 'slug' => 'boleto'],
            ['name' => 'Bank Transfer', 'slug' => 'bank_transfer'],
        ];

        DB::table('payment_methods')->insert($paymentMethods);
    }
}

