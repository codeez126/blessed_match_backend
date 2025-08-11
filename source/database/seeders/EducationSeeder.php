<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    public function run()
    {
        // Array of educational qualifications
        $educations = [
            // Primary Education
            ['name' => 'Primary Education'],
            ['name' => 'Middle School'],

            // Secondary Education
            ['name' => 'Matriculation (Matric)'],
            ['name' => 'O-Level'],
            ['name' => 'Intermediate (FA, FSc, ICS, ICom)'],
            ['name' => 'A-Level'],
            ['name' => 'Higher Secondary Education'],

            // Undergraduate Education
            ['name' => 'BSc'],
            ['name' => 'BA'],
            ['name' => 'BCom'],
            ['name' => 'BCS'],
            ['name' => 'BBA'],
            ['name' => 'BSE'],
            ['name' => 'MBBS'],
            ['name' => 'BDS'],
            ['name' => 'BPharm'],
            ['name' => 'BFA'],
            ['name' => 'B.Ed'],
            ['name' => 'LLB'],
            ['name' => 'BSIT'],
            ['name' => 'BSCS'],
            ['name' => 'BS Bio-Tech'],
            ['name' => 'BEngg'],
            ['name' => 'BSc Nursing'],
            ['name' => 'BArch'],
            ['name' => 'BCA'],
            ['name' => 'BDS'],
            ['name' => 'BBA (Hons)'],
            ['name' => 'BCom (Hons)'],
            ['name' => 'BSc Engineering'],
            ['name' => 'BTech'],
            ['name' => 'BSSE'],  // Adding BSSE (Bachelor of Science in Software Engineering)
            ['name' => 'BBA IT'],
            ['name' => 'BIM (Bachelor of Information Management)'],
            ['name' => 'BS Information Technology'],
            ['name' => 'BS Computer Science'],
            ['name' => 'BS Electronics'],
            ['name' => 'BS Mechanical Engineering'],
            ['name' => 'BS Civil Engineering'],
            ['name' => 'BSc Agricultural Sciences'],

            // Graduate Education
            ['name' => 'MSc'],
            ['name' => 'MA'],
            ['name' => 'MCom'],
            ['name' => 'MCS'],
            ['name' => 'MSE'],
            ['name' => 'MPA'],
            ['name' => 'M.Ed'],
            ['name' => 'MFA'],
            ['name' => 'LLM'],
            ['name' => 'MPhil'],
            ['name' => 'MD'],
            ['name' => 'MS'],
            ['name' => 'MBA'],
            ['name' => 'MAED'],
            ['name' => 'MSc Engineering'],
            ['name' => 'MSc Nursing'],
            ['name' => 'MCA'],
            ['name' => 'MSC Bio-Tech'],
            ['name' => 'MSc Information Technology'],
            ['name' => 'MSCS'],
            ['name' => 'MBA IT'],
            ['name' => 'MS Cyber Security'],
            ['name' => 'MSc Computer Science'],
            ['name' => 'MS Software Engineering'],
            ['name' => 'MSc Artificial Intelligence'],
            ['name' => 'MS Data Science'],
            ['name' => 'MSc Electronics'],
            ['name' => 'MS Robotics'],
            ['name' => 'MSc Mechanical Engineering'],
            ['name' => 'MSc Civil Engineering'],

            // Doctorate Education
            ['name' => 'PhD'],
            ['name' => 'MD'],
            ['name' => 'MS'],
            ['name' => 'DDS'],
            ['name' => 'PharmD'],
            ['name' => 'DVM'],
            ['name' => 'DPhil'],
            ['name' => 'EdD'],
            ['name' => 'PhD in Computer Science'],
            ['name' => 'PhD in Artificial Intelligence'],
            ['name' => 'PhD in Software Engineering'],
            ['name' => 'PhD in Electrical Engineering'],
            ['name' => 'PhD in Mechanical Engineering'],
            ['name' => 'PhD in Civil Engineering'],

            // Professional Certifications and Courses
            ['name' => 'CPA'],
            ['name' => 'CA'],
            ['name' => 'CMA'],
            ['name' => 'CFA'],
            ['name' => 'CCNA'],
            ['name' => 'PMP'],
            ['name' => 'Diploma in Computer Science'],
            ['name' => 'Diploma in Business Administration'],
            ['name' => 'Diploma in Engineering'],
            ['name' => 'Diploma in Medical Technology'],
            ['name' => 'Diploma in Nursing'],
            ['name' => 'Diploma in Hotel Management'],
            ['name' => 'Graphic Design Certificate'],
            ['name' => 'Web Development Certificate'],
            ['name' => 'CEH'],
            ['name' => 'Google Analytics Certified'],
            ['name' => 'AWS Certified Solutions Architect'],
            ['name' => 'CompTIA A+'],
            ['name' => 'Certified Ethical Hacker'],
            ['name' => 'AWS Certified Developer'],
            ['name' => 'Microsoft Certified Solutions Expert'],
            ['name' => 'Oracle Certified Java Programmer'],
            ['name' => 'Cisco Certified Network Associate'],

            // Vocational and Technical Courses
            ['name' => 'Welding Technician'],
            ['name' => 'Electrical Technician'],
            ['name' => 'Plumbing Technician'],
            ['name' => 'Carpentry Technician'],
            ['name' => 'Automobile Technician'],
            ['name' => 'Tailoring and Stitching'],
            ['name' => 'Culinary Arts'],
            ['name' => 'Interior Designing'],
            ['name' => 'Graphic Designing'],
            ['name' => 'Fashion Designing'],
            ['name' => 'Photography'],
            ['name' => 'Catering and Hospitality Management'],
            ['name' => 'Baking and Pastry Arts'],
            ['name' => 'Construction Management'],
            ['name' => 'HVAC Technician'],
            ['name' => 'Event Planning'],
            ['name' => 'Beauty and Cosmetology'],
            ['name' => 'Film Production'],

            ['name' => 'Other'],
            ['name' => 'Not Educated'],
        ];

        // Insert all the education qualifications
        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
