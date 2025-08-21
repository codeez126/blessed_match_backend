<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $plans = [
            [
                'title' => '1 Month Plan',
                'description' => 'Perfect for short-term projects or trying out our services. Get full access to all features for one month.',
                'price' => 1500,
                'duration_days' => 30,
                'image' => '1-month-plan.jpg',
                'features' => json_encode([
                    'Full access to all features',
                    'Priority email support',
                    '5GB storage',
                    'Basic analytics',
                    '1 user included'
                ]),
                'is_popular' => false,
                'max_usage_limit' => 30,
                'is_active' => true,
                'sort_order' => 1,
                'currency' => 'PKR',
                'trial_days' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => '6 Months Plan',
                'description' => 'Our most popular plan for serious users. Save 15% compared to monthly billing with full access for half a year.',
                'price' => 5000, // 16.99 × 6 months
                'duration_days' => 180,
                'image' => '6-months-plan.jpg',
                'features' => json_encode([
                    'All features from 1 Month Plan',
                    'Priority phone & email support',
                    '20GB storage',
                    'Advanced analytics dashboard',
                    'Up to 3 users',
                    'Custom branding options',
                    '15% savings compared to monthly'
                ]),
                'is_popular' => true,
                'max_usage_limit' => 180,
                'is_active' => true,
                'sort_order' => 2,
                'currency' => 'PKR',
                'trial_days' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => '1 Year Plan',
                'description' => 'The best value for long-term commitment. Get 2 months free and all premium features with maximum savings.',
                'price' => 8000, // Equivalent to ~16.67/month
                'duration_days' => 365,
                'image' => '1-year-plan.jpg',
                'features' => json_encode([
                    'All features from 6 Months Plan',
                    '24/7 premium support',
                    'Unlimited storage',
                    'Advanced analytics & reports',
                    'Up to 10 users',
                    'White-label options',
                    'API access',
                    'Custom integration support',
                    '2 months free compared to monthly'
                ]),
                'is_popular' => false,
                'max_usage_limit' => null, // Unlimited
                'is_active' => true,
                'sort_order' => 3,
                'currency' => 'PKR',
                'trial_days' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('payment_plans')->insert($plans);
    }
}
