<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $paymentMethods = [
            [
                'payment_type' => 'EasyPaisa',
                'payment_logo' => 'https://logos-download.com/wp-content/uploads/2020/06/EasyPaisa_Logo.png',
                'account_title' => 'Company Name',
                'account_no' => '0312-3456789',
                'account_iban' => null,
                'status' => true,
                'sort_order' => 1,
                'description' => 'Send money via EasyPaisa mobile account or EasyPaisa shop',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'payment_type' => 'JazzCash',
                'payment_logo' => 'https://seeklogo.com/images/J/jazzcash-logo-7E6D49C0A1-seeklogo.com.png',
                'account_title' => 'Company Name',
                'account_no' => '0300-1234567',
                'account_iban' => null,
                'status' => true,
                'sort_order' => 2,
                'description' => 'Send money via JazzCash mobile wallet or JazzCash agent',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'payment_type' => 'Meezan Bank',
                'payment_logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Meezan_Bank_logo.svg/1200px-Meezan_Bank_logo.svg.png',
                'account_title' => 'Company Name',
                'account_no' => '0123-4567890123',
                'account_iban' => 'PK36MEZN0001234567890123',
                'status' => true,
                'sort_order' => 3,
                'description' => 'Bank transfer to Meezan Bank account',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'payment_type' => 'HBL Bank',
                'payment_logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Habib_Bank_logo.svg/2560px-Habib_Bank_logo.svg.png',
                'account_title' => 'Company Name',
                'account_no' => '0123-4567890123',
                'account_iban' => 'PK36HABB0001234567890123',
                'status' => true,
                'sort_order' => 4,
                'description' => 'Bank transfer to HBL account',
                'created_at' => $now,
                'updated_at' => $now
            ],

        ];

        PaymentMethod::insert($paymentMethods);

        $this->command->info('Payment methods seeded successfully!');
    }
}
