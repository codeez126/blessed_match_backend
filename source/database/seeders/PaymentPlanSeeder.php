<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PaymentPlan;
use App\Models\PaymentPlanVariation;

class PaymentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $plans = [
            [
                'title' => 'Silver Plan',
                'description' => 'Great for individuals starting out.',
                'image' => 'silver.jpg',
                'features' => json_encode(['Basic support', 'Access to core features']),
                'sort_order' => 1,
                'variations' => [
                    ['type' => 'Monthly', 'duration_days' => 30, 'price' => 1000],
                    ['type' => '6 Months', 'duration_days' => 180, 'price' => 5000],
                    ['type' => 'Yearly', 'duration_days' => 360, 'price' => 9000],
                ]
            ],
            [
                'title' => 'Gold Plan',
                'description' => 'Perfect for growing teams with more needs.',
                'image' => 'gold.jpg',
                'features' => json_encode(['Priority support', 'Advanced analytics', '10GB storage']),
                'sort_order' => 2,
                'variations' => [
                    ['type' => 'Monthly', 'duration_days' => 30, 'price' => 2000],
                    ['type' => '6 Months', 'duration_days' => 180, 'price' => 11000],
                    ['type' => 'Yearly', 'duration_days' => 360, 'price' => 20000],
                ]
            ],
            [
                'title' => 'Platinum Plan',
                'description' => 'Best value for enterprises with unlimited features.',
                'image' => 'platinum.jpg',
                'features' => json_encode(['24/7 premium support', 'Unlimited storage', 'Custom integrations']),
                'sort_order' => 3,
                'variations' => [
                    ['type' => 'Monthly', 'duration_days' => 30, 'price' => 5000],
                    ['type' => '6 Months', 'duration_days' => 180, 'price' => 27000],
                    ['type' => 'Yearly', 'duration_days' => 360, 'price' => 50000],
                ]
            ],
        ];

        foreach ($plans as $planData) {
            $plan = PaymentPlan::create([
                'title' => $planData['title'],
                'description' => $planData['description'],
                'price' => 0, // base price handled by variations
                'duration_days' => 0, // handled by variations
                'image' => $planData['image'],
                'features' => $planData['features'],
                'is_popular' => false,
                'max_usage_limit' => null,
                'is_active' => true,
                'sort_order' => $planData['sort_order'],
                'currency' => 'PKR',
                'trial_days' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            foreach ($planData['variations'] as $variation) {
                PaymentPlanVariation::create([
                    'payment_plan_id' => $plan->id,
                    'type' => $variation['type'],
                    'duration_days' => $variation['duration_days'],
                    'price' => $variation['price'],
                ]);
            }
        }
    }
}
