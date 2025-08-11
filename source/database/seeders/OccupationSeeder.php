<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $occupations = [
            'Accountant', 'Actor', 'Actuary', 'Agricultural Engineer', 'Air Traffic Controller', 'Ambassador', 'Archaeologist',
            'Architect', 'Army Officer', 'Artist', 'Assistant Commissioner', 'Attorney', 'Auditor', 'Auto Mechanic', 'Baker',
            'Banker', 'Barber', 'Beautician', 'Biomedical Engineer', 'Blacksmith', 'Bookkeeper', 'Bricklayer', 'Bus Driver',
            'Butcher', 'Call Center Agent', 'Carpenter', 'Cashier', 'Chef', 'Civil Engineer', 'Clerk', 'Computer Programmer',
            'Construction Worker', 'Consultant', 'Cook', 'Corporate Lawyer', 'Courier', 'Cricketer', 'Customs Officer',
            'Data Analyst', 'Data Entry Operator', 'Dentist', 'Designer', 'Detective', 'Diplomat', 'Doctor', 'Driver',
            'Economist', 'Editor', 'Electrician', 'Electronics Technician', 'Engineer', 'Event Planner', 'Factory Worker',
            'Farmer', 'Fashion Designer', 'Fisherman', 'Flight Attendant', 'Florist', 'Geologist', 'Graphic Designer',
            'Gynecologist', 'Hairdresser', 'Health Inspector', 'Historian', 'Homeopath', 'Hotel Manager', 'HR Manager',
            'Immigration Officer', 'Industrial Engineer', 'Insurance Agent', 'Interior Designer', 'Interpreter',
            'Investment Banker', 'IT Manager', 'Janitor', 'Journalist', 'Judge', 'Lab Technician', 'Lawyer', 'Lecturer',
            'Librarian', 'Logistics Manager', 'Machinist', 'Magistrate', 'Makeup Artist', 'Marketing Manager', 'Mason',
            'Mechanic', 'Medical Assistant', 'Merchant', 'Meteorologist', 'Miner', 'Model', 'Motorcycle Mechanic',
            'Musician', 'Nurse', 'Nutritionist', 'Occupational Therapist', 'Office Assistant', 'Optician', 'Painter',
            'Paramedic', 'Parliamentarian', 'Pathologist', 'Pension Officer', 'Pharmacist', 'Photographer',
            'Physical Therapist', 'Physicist', 'Pilot', 'Plumber', 'Police Officer', 'Politician', 'Postman', 'Principal',
            'Professor', 'Programmer', 'Project Manager', 'Property Dealer', 'Psychiatrist', 'Psychologist',
            'Public Relations Officer', 'Purchasing Officer', 'Radiologist', 'Receptionist', 'Researcher', 'Retail Manager',
            'Revenue Officer', 'Sales Executive', 'Sanitary Worker', 'Scientist', 'Security Guard', 'Social Worker',
            'Software Developer', 'Soldier', 'Statistician', 'Steward', 'Stock Broker', 'Store Keeper', 'Sub Inspector',
            'Surveyor', 'Tailor', 'Teacher', 'Technician', 'Telecom Engineer', 'Trader', 'Traffic Warden', 'Train Conductor',
            'Translator', 'Travel Agent', 'Truck Driver', 'TV Host', 'Typist', 'Urologist', 'Veterinarian', 'Video Editor',
            'Waiter', 'Ward Boy', 'Web Developer', 'Welder', 'Writer', 'Zoologist', 'Accounts Officer', 'AC Technician',
            'Admin Officer', 'Agriculturist', 'Air Force Officer', 'Android Developer', 'Animal Breeder', 'Animator',
            'Announcer', 'App Developer', 'Application Engineer', 'Armed Forces Member', 'Artist Manager', 'Assembler',
            'Assistant Director', 'Assistant Manager', 'ATM Officer', 'Automation Engineer', 'Bailiff', 'Bank Officer',
            'Billing Clerk', 'Biochemist', 'Bioinformatician', 'Block Maker', 'Boiler Operator', 'Broadcast Technician',
            'Business Analyst', 'Cameraman', 'Campaign Manager', 'Cancer Specialist', 'Cartographer', 'Cash Recovery Agent',
            'CCTV Operator', 'Ceramic Artist', 'Chartered Accountant', 'Chef de Partie', 'Chief Engineer', 'Chief Executive',
            'Cleaner', 'Client Service Executive', 'Clinical Psychologist', 'Coach', 'Community Health Worker',
            'Compliance Officer', 'Compositor', 'Computer Technician', 'Content Writer', 'Control Room Officer',
            'Coordinator', 'Copywriter', 'Corporate Executive', 'Counselor', 'Creative Director', 'Credit Officer',
            'Criminal Lawyer', 'Cultural Attaché', 'Curator', 'Customer Service Officer', 'Customs Clearing Agent',
            'Database Administrator', 'Delivery Boy', 'Dermatologist', 'Design Engineer', 'Dietitian', 'Director',
            'Dispatch Officer', 'Distributor', 'Documentation Officer', 'Domestic Worker', 'Draftsman', 'Drama Teacher',
            'Driller', 'Dry Cleaner', 'E-Commerce Manager', 'Econometrics Specialist', 'Education Consultant',
            'Electrical Engineer', 'Embassy Staff', 'Emergency Officer', 'Energy Consultant', 'Engraver', 'Entrepreneur',
            'Environmentalist', 'Examiner', 'Executive Assistant', 'Export Manager', 'Fabricator', 'Field Assistant',
            'Financial Advisor', 'Financial Analyst', 'Firefighter', 'Fitness Trainer', 'Flight Instructor',
            'Foreign Affairs Officer', 'Forensic Analyst', 'Forester', 'Front Desk Officer', 'Fundraiser', 'Furniture Maker',
            'Game Developer', 'Garbage Collector', 'Gas Fitter', 'General Physician', 'Geneticist', 'Governess',
            'Graphic Illustrator', 'Groundskeeper', 'Guidance Counselor', 'Gym Instructor', 'Handicrafts Maker',
            'Hardware Engineer', 'Health Officer', 'Heavy Vehicle Driver', 'Helpdesk Technician', 'Herbalist', 'Historian',
            'Home Tutor', 'Housekeeper', 'HVAC Technician', 'Hydrologist', 'Illustrator', 'Import Manager',
            'Industrial Designer', 'Infantry Officer', 'Information Officer', 'Infrastructure Engineer', 'Instrument Technician',
            'Intelligence Officer', 'Internal Auditor', 'Inventory Officer', 'Investment Analyst', 'Islamic Scholar',
            'IT Support Officer', 'Jeweler', 'Judicial Clerk', 'Labourer', 'Land Surveyor', 'Landscaper', 'Language Teacher',
            'Law Enforcement Officer', 'Legal Advisor', 'Liaison Officer', 'Lift Operator', 'Lighting Technician',
            'Loan Officer', 'Logistics Officer', 'Maintenance Officer', 'Management Consultant', 'Manpower Officer',
            'Marine Biologist', 'Marketing Executive', 'Masseur', 'Mathematician', 'Meat Inspector', 'Mechanical Engineer',
            'Media Consultant', 'Medical Examiner', 'Medical Representative', 'Microbiologist', 'Midwife',
            'Military Officer', 'Mobile Technician', 'Molecular Biologist', 'Monitoring Officer', 'Mortician', 'Museum Guide',
            'Music Teacher', 'Neurologist', 'NGO Worker', 'Nuclear Scientist', 'Nutrition Consultant', 'Obstetrician',
            'Occupational Health Specialist', 'Oceanographer', 'Operations Manager', 'Ornithologist', 'Orthodontist',
            'Orthopedic Surgeon', 'Paleontologist', 'Pediatrician', 'Pen Tester', 'Petroleum Engineer', 'Phlebotomist',
            'Physiologist', 'Pilot Trainer', 'Plant Operator', 'Political Analyst', 'Pollution Control Officer', 'Porter',
            'Postal Clerk', 'Print Technician', 'Private Tutor', 'Procurement Officer', 'Production Manager',
            'Project Coordinator', 'Proofreader', 'Protocol Officer', 'Psychometrician', 'Public Health Officer',
            'Public Prosecutor', 'Publisher', 'Quality Assurance Officer', 'Quality Control Inspector', 'Quantity Surveyor',
            'Quarantine Inspector', 'R&D Officer', 'Radio Jockey', 'Real Estate Agent', 'Recruiter', 'Rehabilitation Counselor',
            'Religious Scholar', 'Remittance Officer', 'Reporter', 'Research Analyst', 'Restaurant Manager',
            'Risk Manager', 'Road Inspector', 'Robotics Engineer', 'Safety Officer', 'Sanitation Engineer',
            'Satellite Technician', 'School Counselor', 'Scientific Officer', 'Script Writer', 'Security Analyst',
            'Securities Broker', 'Service Engineer', 'Shoe Maker', 'Site Engineer', 'Skin Specialist', 'Smartphone Repairer',
            'Software Architect', 'Solar Technician', 'Sound Engineer', 'Speech Therapist', 'Statistician',
            'Steel Fixer', 'Stenographer', 'Strategist', 'Structural Engineer', 'Studio Manager', 'Surgeon', 'Survey Officer',
            'Sustainability Officer', 'Systems Analyst', 'Tax Consultant', 'Technical Writer', 'Telemarketer',
            'Textile Engineer', 'Theater Director', 'Theologian', 'Ticket Collector', 'Tour Guide', 'Toxicologist',
            'Traffic Analyst', 'Training Manager', 'Transport Officer', 'Treasury Officer', 'Tutor', 'Typographer',
            'Urban Planner', 'Vehicle Inspector', 'Veterinary Technician', 'Video Game Tester', 'Voice Over Artist',
            'Volunteer Coordinator', 'Warehouse Manager', 'Watchman', 'Water Treatment Officer', 'Weather Forecaster',
            'Wedding Planner', 'Welfare Officer', 'Wood Cutter', 'Workshop Manager', 'Youth Counselor'
        ];


        foreach ($occupations as $occupation) {
            \App\Models\Occupation::create(['name' => $occupation]);
        }

        // Fill up to 300+ by generating dummy entries
        for ($i = count($occupations); $i < 300; $i++) {
            \App\Models\Occupation::create(['name' => 'Occupation ' . ($i + 1)]);
        }
    }

}
