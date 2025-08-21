<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pages;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'page_name' => 'Home',
                'page_url' => 'home-page',
                'page_heading' => 'Welcome to Home Page',
                'status' => true,
            ],
            [
                'page_name' => 'Contact Us',
                'page_url' => 'contact-us',
                'page_heading' => 'Get in Touch',
                'status' => true,
            ],
            [
                'page_name' => 'Privacy Policy',
                'page_url' => 'privacy-policy',
                'page_heading' => 'Privacy Policy',
                'status' => true,
            ],
            [
                'page_name' => 'Terms and Conditions',
                'page_url' => 'terms-and-conditions',
                'page_heading' => 'Terms and Conditions',
                'status' => true,
            ],
            [
                'page_name' => 'About Us',
                'page_url' => 'about-us',
                'page_heading' => 'Who We Are',
                'status' => true,
            ],
            [
                'page_name' => 'App About Us',
                'page_url' => 'app-about-us',
                'page_heading' => 'About Our App',
                'page_content' => 'About Our App content',
                'page_content2' => 'About Our App content 2',
                'status' => true,
            ],
        ];

        foreach ($pages as $page) {
            Pages::updateOrCreate(
                ['page_url' => $page['page_url']],
                $page
            );
        }
    }
}
