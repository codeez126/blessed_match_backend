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
            ['name' => 'Primary Education', 'level' => 5],
            ['name' => 'Middle School', 'level' => 8],

            // Secondary Education
            ['name' => 'Matriculation (Matric)', 'level' => 10],
            ['name' => 'O-Level', 'level' => 10],
            ['name' => 'Intermediate (FA, FSc, ICS, ICom)', 'level' => 12],
            ['name' => 'A-Level', 'level' => 12],
            ['name' => 'Higher Secondary Education', 'level' => 12],

            // Undergraduate Education
            ['name' => 'BSc', 'level' => 14],
            ['name' => 'BA', 'level' => 14],
            ['name' => 'BCom', 'level' => 14],
            ['name' => 'BCS', 'level' => 14],
            ['name' => 'BBA', 'level' => 14],
            ['name' => 'BSE', 'level' => 14],
            ['name' => 'MBBS', 'level' => 16],
            ['name' => 'BDS', 'level' => 16],
            ['name' => 'BPharm', 'level' => 16],
            ['name' => 'BFA', 'level' => 14],
            ['name' => 'B.Ed', 'level' => 14],
            ['name' => 'LLB', 'level' => 14],
            ['name' => 'BSIT', 'level' => 14],
            ['name' => 'BSCS', 'level' => 14],
            ['name' => 'BS Bio-Tech', 'level' => 14],
            ['name' => 'BEngg', 'level' => 16],
            ['name' => 'BSc Nursing', 'level' => 16],
            ['name' => 'BArch', 'level' => 16],
            ['name' => 'BCA', 'level' => 14],
            ['name' => 'BDS', 'level' => 16],
            ['name' => 'BBA (Hons)', 'level' => 14],
            ['name' => 'BCom (Hons)', 'level' => 14],
            ['name' => 'BSc Engineering', 'level' => 16],
            ['name' => 'BTech', 'level' => 16],
            ['name' => 'BSSE', 'level' => 14],
            ['name' => 'BBA IT', 'level' => 14],
            ['name' => 'BIM (Bachelor of Information Management)', 'level' => 14],
            ['name' => 'BS Information Technology', 'level' => 14],
            ['name' => 'BS Computer Science', 'level' => 14],
            ['name' => 'BS Electronics', 'level' => 14],
            ['name' => 'BS Mechanical Engineering', 'level' => 16],
            ['name' => 'BS Civil Engineering', 'level' => 16],
            ['name' => 'BSc Agricultural Sciences', 'level' => 14],

            // Graduate Education
            ['name' => 'MSc', 'level' => 16],
            ['name' => 'MA', 'level' => 16],
            ['name' => 'MCom', 'level' => 16],
            ['name' => 'MCS', 'level' => 16],
            ['name' => 'MSE', 'level' => 16],
            ['name' => 'MPA', 'level' => 16],
            ['name' => 'M.Ed', 'level' => 16],
            ['name' => 'MFA', 'level' => 16],
            ['name' => 'LLM', 'level' => 16],
            ['name' => 'MPhil', 'level' => 18],
            ['name' => 'MD', 'level' => 18],
            ['name' => 'MS', 'level' => 16],
            ['name' => 'MBA', 'level' => 16],
            ['name' => 'MAED', 'level' => 16],
            ['name' => 'MSc Engineering', 'level' => 16],
            ['name' => 'MSc Nursing', 'level' => 16],
            ['name' => 'MCA', 'level' => 16],
            ['name' => 'MSC Bio-Tech', 'level' => 16],
            ['name' => 'MSc Information Technology', 'level' => 16],
            ['name' => 'MSCS', 'level' => 16],
            ['name' => 'MBA IT', 'level' => 16],
            ['name' => 'MS Cyber Security', 'level' => 16],
            ['name' => 'MSc Computer Science', 'level' => 16],
            ['name' => 'MS Software Engineering', 'level' => 16],
            ['name' => 'MSc Artificial Intelligence', 'level' => 16],
            ['name' => 'MS Data Science', 'level' => 16],
            ['name' => 'MSc Electronics', 'level' => 16],
            ['name' => 'MS Robotics', 'level' => 16],
            ['name' => 'MSc Mechanical Engineering', 'level' => 16],
            ['name' => 'MSc Civil Engineering', 'level' => 16],

            // Doctorate Education
            ['name' => 'PhD', 'level' => 18],
            ['name' => 'MD', 'level' => 18],
            ['name' => 'MS', 'level' => 18],
            ['name' => 'DDS', 'level' => 18],
            ['name' => 'PharmD', 'level' => 18],
            ['name' => 'DVM', 'level' => 18],
            ['name' => 'DPhil', 'level' => 18],
            ['name' => 'EdD', 'level' => 18],
            ['name' => 'PhD in Computer Science', 'level' => 18],
            ['name' => 'PhD in Artificial Intelligence', 'level' => 18],
            ['name' => 'PhD in Software Engineering', 'level' => 18],
            ['name' => 'PhD in Electrical Engineering', 'level' => 18],
            ['name' => 'PhD in Mechanical Engineering', 'level' => 18],
            ['name' => 'PhD in Civil Engineering', 'level' => 18],

            // Professional Certifications and Courses
            ['name' => 'CPA', 'level' => 14],
            ['name' => 'CA', 'level' => 16],
            ['name' => 'CMA', 'level' => 14],
            ['name' => 'CFA', 'level' => 16],
            ['name' => 'CCNA', 'level' => 12],
            ['name' => 'PMP', 'level' => 14],
            ['name' => 'Diploma in Computer Science', 'level' => 12],
            ['name' => 'Diploma in Business Administration', 'level' => 12],
            ['name' => 'Diploma in Engineering', 'level' => 12],
            ['name' => 'Diploma in Medical Technology', 'level' => 12],
            ['name' => 'Diploma in Nursing', 'level' => 12],
            ['name' => 'Diploma in Hotel Management', 'level' => 12],
            ['name' => 'Graphic Design Certificate', 'level' => 10],
            ['name' => 'Web Development Certificate', 'level' => 10],
            ['name' => 'CEH', 'level' => 14],
            ['name' => 'Google Analytics Certified', 'level' => 10],
            ['name' => 'AWS Certified Solutions Architect', 'level' => 14],
            ['name' => 'CompTIA A+', 'level' => 10],
            ['name' => 'Certified Ethical Hacker', 'level' => 14],
            ['name' => 'AWS Certified Developer', 'level' => 14],
            ['name' => 'Microsoft Certified Solutions Expert', 'level' => 14],
            ['name' => 'Oracle Certified Java Programmer', 'level' => 12],
            ['name' => 'Cisco Certified Network Associate', 'level' => 12],

            // Vocational and Technical Courses
            ['name' => 'Welding Technician', 'level' => 10],
            ['name' => 'Electrical Technician', 'level' => 10],
            ['name' => 'Plumbing Technician', 'level' => 10],
            ['name' => 'Carpentry Technician', 'level' => 10],
            ['name' => 'Automobile Technician', 'level' => 10],
            ['name' => 'Tailoring and Stitching', 'level' => 8],
            ['name' => 'Culinary Arts', 'level' => 10],
            ['name' => 'Interior Designing', 'level' => 10],
            ['name' => 'Graphic Designing', 'level' => 10],
            ['name' => 'Fashion Designing', 'level' => 10],
            ['name' => 'Photography', 'level' => 10],
            ['name' => 'Catering and Hospitality Management', 'level' => 12],
            ['name' => 'Baking and Pastry Arts', 'level' => 10],
            ['name' => 'Construction Management', 'level' => 12],
            ['name' => 'HVAC Technician', 'level' => 10],
            ['name' => 'Event Planning', 'level' => 10],
            ['name' => 'Beauty and Cosmetology', 'level' => 10],
            ['name' => 'Film Production', 'level' => 12],

            ['name' => 'Other', 'level' => 0],
            ['name' => 'Not Educated', 'level' => 0],
        ];

        // Insert all the education qualifications
        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
