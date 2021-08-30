<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // crea il tipo di pagamento 'Paypal'
        PaymentType::create([
            'name' => 'PayPal',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'MasterCard'
        PaymentType::create([
            'name' => 'MasterCard',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'Visa'
        PaymentType::create([
            'name' => 'Visa',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'American Express'
        PaymentType::create([
            'name' => 'American Express',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'Visa Electron'
        PaymentType::create([
            'name' => 'Visa Electron',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'Google Pay'
        PaymentType::create([
            'name' => 'Google Pay',
            'enabled' => false
        ]);

        // crea il tipo di pagamento 'Apple Pay'
        PaymentType::create([
            'name' => 'Apple Pay',
            'enabled' => false
        ]);
    }
}
