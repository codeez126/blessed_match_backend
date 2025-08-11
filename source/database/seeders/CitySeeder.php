<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use App\Models\Area;

class CitySeeder extends Seeder
{
    public function run()
    {
        $country = Country::where('name', 'Pakistan')->first();

        // Mapping of cities to provinces
        $provinceCityMap = [
            'Sindh' => [
                'Karachi', 'Hyderabad', 'Sukkur', 'Larkana', 'Nawabshah', 'Mirpur Khas',
                'Tando Adam', 'Khairpur', 'Tando Allahyar', 'Dadu', 'Tando Muhammad Khan',
                'Shahdadkot', 'Shikarpur', 'Matiari', 'Tando Bago', 'Thatta', 'Sanghar',
                'Umerkot', 'Badin', 'Naushahro Feroze', 'Jamshoro', 'Shahdadpur',
                'Ghotki', 'Hala', 'Jacobabad', 'Kandhkot', 'Kashmore', 'Moro', 'Sehwan', 'Tharparkar'
            ],
            'Punjab' => [
                'Lahore', 'Faisalabad', 'Rawalpindi', 'Gujranwala', 'Multan',
                'Bahawalpur', 'Sargodha', 'Sialkot', 'Sheikhupura', 'Rahim Yar Khan',
                'Jhang', 'Dera Ghazi Khan', 'Gujrat', 'Sahiwal', 'Kasur', 'Okara',
                'Chiniot', 'Kamoke', 'Burewala', 'Jhelum', 'Khanewal', 'Hafizabad',
                'Chakwal', 'Muzaffargarh', 'Khanpur', 'Gojra', 'Mandi Bahauddin',
                'Bahawalnagar', 'Samundri', 'Pakpattan', 'Jaranwala', 'Vihari',
                'Kamalia', 'Kot Addu', 'Gujar Khan', 'Hasilpur', 'Narowal',
                'Layyah', 'Lodhran', 'Mianwali', 'Pattoki', 'Daska', 'Attock',
                'Ahmadpur East', 'Arifwala', 'Bhakkar', 'Chichawatni', 'Chishtian',
                'Darya Khan', 'Dinga', 'Dipalpur', 'Fateh Jang', 'Ferozewala',
                'Haroonabad', 'Jampur', 'Jatoi', 'Kahna Nau', 'Kallar Kahar',
                'Kharian', 'Khushab', 'Lala Musa', 'Lalian', 'Mailsi',
                'Mian Channu', 'Muridke', 'Murree', 'Nankana Sahib', 'Pindi Bhattian',
                'Pind Dadan Khan', 'Qadirpur Ran', 'Rajanpur', 'Renala Khurd',
                'Sadiqabad', 'Shakargarh', 'Shorkot', 'Sillanwali', 'Toba Tek Singh',
                'Wazirabad', 'Zafarwal'
            ],

            'Khyber Pakhtunkhwa' => [
                'Peshawar', 'Mardan', 'Mingora', 'Abbottabad', 'Charsadda',
                'Kabal', 'Mansehra', 'Karak', 'Haripur', 'Swabi', 'Hangu',
                'Chitral', 'Timergara', 'Tank', 'Bannu', 'Kohat', 'Nowshera'
            ],
            'Balochistan' => [
                'Quetta', 'Khuzdar', 'Chaman', 'Turbat', 'Zhob', 'Loralai',
                'Dera Allah Yar', 'Gwadar', 'Sibi'
            ],
            'Gilgit-Baltistan' => [
                'Gilgit', 'Skardu'
            ],
            'Azad Kashmir' => [
                'Muzaffarabad', 'Kotli', 'Mirpur', 'Bhimber'
            ],
            'Islamabad Capital Territory' => [
                'Islamabad'
            ]

        ];

        // Areas for major cities
        $cityAreas = [
            'Karachi' => [
                // Major Towns and Zones
                'Clifton', 'Defence Housing Authority (DHA)', 'Saddar', 'Gulshan-e-Iqbal', 'North Nazimabad',
                'Gulistan-e-Jauhar', 'Malir', 'Korangi', 'Landhi', 'Shah Faisal Town',
                'Lyari', 'SITE Area', 'Orangi Town', 'Nazimabad', 'FB Area',
                'Garden East', 'Garden West', 'Jamshed Town', 'PECHS', 'Bahadurabad',
                'Tariq Road', 'Gulzar-e-Hijri', 'Surjani Town', 'New Karachi', 'Memon Society',

                // DHA Phases
                'DHA Phase 1', 'DHA Phase 2', 'DHA Phase 3', 'DHA Phase 4', 'DHA Phase 5',
                'DHA Phase 6', 'DHA Phase 7', 'DHA Phase 8', 'DHA Phase 9',
                'DHA Creek Vista', 'DHA Ocean View', 'DHA City',

                // Clifton and Surrounding
                'Clifton Block 1', 'Clifton Block 2', 'Clifton Block 3', 'Clifton Block 4',
                'Clifton Block 5', 'Clifton Block 7', 'Clifton Block 8', 'Clifton Block 9',
                'Seaview', 'Do Darya', 'Khayaban-e-Ittehad', 'Khayaban-e-Shamsheer',
                'Khayaban-e-Badar', 'Khayaban-e-Shujaat', 'Khayaban-e-Hafiz',

                // Gulshan Town
                'Gulshan-e-Iqbal Block 1', 'Gulshan-e-Iqbal Block 2', 'Gulshan-e-Iqbal Block 3',
                'Gulshan-e-Iqbal Block 4', 'Gulshan-e-Iqbal Block 5', 'Gulshan-e-Iqbal Block 6',
                'Gulshan-e-Iqbal Block 7', 'Gulshan-e-Iqbal Block 8', 'Gulshan-e-Iqbal Block 9',
                'Gulshan-e-Iqbal Block 10', 'Gulshan-e-Iqbal Block 11', 'Gulshan-e-Iqbal Block 13',
                'Gulshan-e-Iqbal Block 14', 'Gulshan-e-Iqbal Block 15', 'Gulshan-e-Iqbal Block 16',
                'Gulshan-e-Iqbal Block 17', 'Gulshan-e-Iqbal Block 18', 'Gulshan-e-Iqbal Block 19',

                // North Nazimabad
                'North Nazimabad Block A', 'North Nazimabad Block B', 'North Nazimabad Block C',
                'North Nazimabad Block D', 'North Nazimabad Block E', 'North Nazimabad Block F',
                'North Nazimabad Block G', 'North Nazimabad Block H', 'North Nazimabad Block I',
                'North Nazimabad Block J', 'North Nazimabad Block K', 'North Nazimabad Block L',
                'North Nazimabad Block M', 'North Nazimabad Block N', 'North Nazimabad Block P',

                // Gulistan-e-Jauhar
                'Gulistan-e-Jauhar Block 1', 'Gulistan-e-Jauhar Block 2', 'Gulistan-e-Jauhar Block 3',
                'Gulistan-e-Jauhar Block 4', 'Gulistan-e-Jauhar Block 5', 'Gulistan-e-Jauhar Block 6',
                'Gulistan-e-Jauhar Block 7', 'Gulistan-e-Jauhar Block 8', 'Gulistan-e-Jauhar Block 9',
                'Gulistan-e-Jauhar Block 10', 'Gulistan-e-Jauhar Block 11', 'Gulistan-e-Jauhar Block 12',
                'Gulistan-e-Jauhar Block 13', 'Gulistan-e-Jauhar Block 14', 'Gulistan-e-Jauhar Block 15',
                'Gulistan-e-Jauhar Block 16', 'Gulistan-e-Jauhar Block 17', 'Gulistan-e-Jauhar Block 18',
                'Gulistan-e-Jauhar Block 19', 'Gulistan-e-Jauhar Block 20',

                // Jamshed Town
                'Jamshed Quarter 1', 'Jamshed Quarter 2', 'Jamshed Quarter 3', 'Jamshed Quarter 4',
                'Jamshed Quarter 5', 'Jamshed Quarter 6', 'Jamshed Quarter 7', 'Jamshed Quarter 8',
                'Jamshed Quarter 9', 'Jamshed Quarter 10', 'Jamshed Quarter 11', 'Jamshed Quarter 12',

                // PECHS
                'PECHS Block 1', 'PECHS Block 2', 'PECHS Block 3', 'PECHS Block 4',
                'PECHS Block 5', 'PECHS Block 6', 'PECHS Block 7', 'PECHS Block 8',

                // Nazimabad
                'Nazimabad No. 1', 'Nazimabad No. 2', 'Nazimabad No. 3', 'Nazimabad No. 4',
                'Nazimabad No. 5', 'Nazimabad No. 6', 'Nazimabad No. 7',

                // FB Area
                'FB Area Block 1', 'FB Area Block 2', 'FB Area Block 3', 'FB Area Block 4',
                'FB Area Block 5', 'FB Area Block 6', 'FB Area Block 7', 'FB Area Block 8',
                'FB Area Block 9', 'FB Area Block 10', 'FB Area Block 11', 'FB Area Block 12',
                'FB Area Block 13', 'FB Area Block 14', 'FB Area Block 15', 'FB Area Block 16',

                // Korangi
                'Korangi No. 1', 'Korangi No. 2', 'Korangi No. 3', 'Korangi No. 4',
                'Korangi No. 5', 'Korangi No. 6', 'Korangi No. 7', 'Korangi No. 8',
                'Korangi Creek', 'Korangi Industrial Area', 'Korangi Crossing',

                // Landhi
                'Landhi No. 1', 'Landhi No. 2', 'Landhi No. 3', 'Landhi No. 4',
                'Landhi No. 5', 'Landhi No. 6', 'Landhi Industrial Area',

                // Orangi Town
                'Orangi Town Sector 1', 'Orangi Town Sector 2', 'Orangi Town Sector 3',
                'Orangi Town Sector 4', 'Orangi Town Sector 5', 'Orangi Town Sector 6',
                'Orangi Town Sector 7', 'Orangi Town Sector 8', 'Orangi Town Sector 9',
                'Orangi Town Sector 10', 'Orangi Town Sector 11', 'Orangi Town Sector 12',

                // New Karachi
                'New Karachi Sector 1', 'New Karachi Sector 2', 'New Karachi Sector 3',
                'New Karachi Sector 4', 'New Karachi Sector 5', 'New Karachi Sector 6',
                'New Karachi Sector 7', 'New Karachi Sector 8', 'New Karachi Sector 9',
                'New Karachi Sector 10', 'New Karachi Sector 11', 'New Karachi Sector 12',

                // Malir
                'Malir Cantt', 'Malir Colony', 'Malir City', 'Malir Model Colony',
                'Malir Kalaboard', 'Malir Saudabad', 'Malir Shah Faisal Colony',
                'Malir Halt', 'Malir Extension', 'Airport Housing Society',

                // Commercial Areas
                'II Chundrigar Road', 'M.A. Jinnah Road', 'Tariq Road', 'Zamzama Boulevard',
                'Bohri Bazaar', 'Saddar Electronics Market', 'Empress Market',
                'Jodia Bazaar', 'Hyderi Market', 'Gul Plaza', 'Millennium Mall',
                'Dolmen Mall', 'Lucky One Mall', 'Park Towers',

                // Industrial Areas
                'SITE Super Highway', 'SITE Kotri', 'SITE Limited', 'SITE No. 1',
                'SITE No. 2', 'SITE No. 3', 'SITE No. 4', 'SITE No. 5',
                'Korangi Industrial Area', 'Landhi Industrial Area',
                'Federal B Industrial Area', 'North Karachi Industrial Area',

                // Educational Areas
                'KU Campus', 'NED University', 'IBA', 'Dow Medical College',
                'Aga Khan University', 'SZABIST', 'Habib University',
                'Indus Valley School', 'Karachi Grammar School', 'Beaconhouse',

                // Transport Hubs
                'Jinnah International Airport', 'Karachi Port', 'Port Qasim',
                'Cantt Station', 'City Station', 'Karachi Bus Terminal',
                'Metroville Depot', 'Orangi Depot', 'Korangi Depot',

                // Islands and Coastal
                'Manora Island', 'Baba Bhit Island', 'Clifton Beach', 'French Beach',
                'Sandspit Beach', 'Hawke s Bay', 'Cape Monze',

//     Religious Sites
    'Abdullah Shah Ghazi Shrine', 'Mazar-e-Quaid', 'St. Patrick s Cathedral',
    'Memar-e-Pakistan', 'Wazir Mansion', 'Frere Hall',

    // Parks and Recreational
    'Safari Park', 'Hill Park', 'Baghe Ibne Qasim', 'Karachi Zoo',
    'Askari Park', 'Jheel Park', 'Rahmania Park',

    // Upcoming Developments
    'Bahria Town Karachi', 'Bahria Icon Tower', 'Karachi Circular Railway',
    'Bundal Island', 'Dolmen City', 'Emaar Pakistan',

    // Villages and Suburbs
    'Gadap Town', 'Manghopir', 'Gulshan-e-Maymar', 'Scheme 33',
    'Gulshan-e-Hadeed', 'Surjani Town', 'Gulshan-e-Bahar',
    'Gulshan-e-Zia', 'Gulshan-e-Saeed', 'Gulshan-e-Iqbal'
],
            'Lahore' => [
                // Main Sectors and Towns
                'Gulberg', 'Defence Housing Authority (DHA)', 'Model Town', 'Johar Town', 'Faisal Town',
                'Wapda Town', 'Cantt', 'Allama Iqbal Town', 'Samanabad', 'Shadman',
                'Iqbal Town', 'Garden Town', 'Muslim Town', 'Sabzazar', 'Township',
                'Valencia', 'Bahria Town', 'Lake City', 'Green Town', 'Jauhar Town',
                'PIA Society', 'Askari', 'Cavalry Ground', 'Wagah Town', 'Iqbal Park',

                // DHA Phases
                'DHA Phase 1', 'DHA Phase 2', 'DHA Phase 3', 'DHA Phase 4', 'DHA Phase 5',
                'DHA Phase 6', 'DHA Phase 7', 'DHA Phase 8', 'DHA Phase 9',

                // Gulberg Sectors
                'Gulberg I', 'Gulberg II', 'Gulberg III', 'Gulberg IV', 'Gulberg V',

                // Johar Town Blocks
                'Johar Town Block A', 'Johar Town Block B', 'Johar Town Block C',
                'Johar Town Block D', 'Johar Town Block E', 'Johar Town Block F',
                'Johar Town Block G', 'Johar Town Block H', 'Johar Town Block J',
                'Johar Town Block K', 'Johar Town Block L', 'Johar Town Block M',
                'Johar Town Block N', 'Johar Town Block O', 'Johar Town Block P',
                'Johar Town Block Q', 'Johar Town Block R', 'Johar Town Block S',

                // Model Town Sectors
                'Model Town A Block', 'Model Town B Block', 'Model Town C Block',
                'Model Town D Block', 'Model Town E Block', 'Model Town F Block',
                'Model Town G Block', 'Model Town H Block', 'Model Town J Block',
                'Model Town K Block', 'Model Town L Block', 'Model Town M Block',
                'Model Town N Block', 'Model Town P Block', 'Model Town Q Block',

                // Cantt Areas
                'Lahore Cantt', 'Walton Cantt', 'Raiwind Cantt', 'Badami Bagh Cantt',

                // Commercial Areas
                'Liberty Market', 'MM Alam Road', 'The Mall Road', 'Fortress Stadium',
                'Anarkali Bazaar', 'Ichhra Bazaar', 'Shah Alam Market', 'Barki Bazaar',
                'Azam Cloth Market', 'Harbanspura Market', 'Urdu Bazaar',

                // Educational Areas
                'Punjab University', 'LUMS', 'UET', 'GCU', 'FC College', 'LSE',
                'Kinnaird College', 'Aitchison College', 'LGS', 'Beaconhouse',

                // Housing Societies
                'Eden Housing', 'LDA Avenue', 'Al-Noor Orchard', 'Central Park',
                'Emirates City', 'Faisal Hills', 'Gulshan-e-Ravi', 'Harbanspura',
                'Izmir Town', 'Jinnah Garden', 'Kareem Block', 'Lajpat Nagar',
                'Mustafa Town', 'Naseerabad', 'Orchard Housing', 'Paragon City',
                'Qainchi', 'Raiwind Road', 'Sukh Chayn', 'Tajpura', 'Usman Town',
                'Village', 'Walled City', 'X-Block', 'Yasir Town', 'Zaman Park',

                // Industrial Areas
                'Kot Lakhpat', 'Sundar Industrial Estate', 'Quaid-e-Azam Industrial Estate',
                'Bhatta Chowk', 'Ferozepur Road Industrial Area',

                // Outer Areas
                'Thokar Niaz Beg', 'Jallo Mor', 'Shahdara', 'Barki', 'Kala Shah Kaku',
                'Manawan', 'Chung', 'Jati Umra', 'Mehmood Booti', 'Raiwind',

                // New Developments
                'LDA City', 'New Lahore City', 'Park View City', 'Al Jalil Garden',
                'Capital Smart City', 'Lahore Smart City', 'Sui Gas Society',

                // Historical Areas
                'Lahore Fort', 'Badshahi Mosque', 'Shalimar Gardens', 'Data Darbar',
                'Wazir Khan Mosque', 'Hazuri Bagh', 'Minar-e-Pakistan',

                // Transport Hubs
                'Lahore Junction', 'Lahore Bus Terminal', 'Allama Iqbal Airport',
                'Metro Stations', 'Orange Line', 'Speedo Bus Terminal',

                // Parks and Recreational
                'Jallo Park', 'Race Course Park', 'Jinnah Garden', 'Jilani Park',
                'Bagh-e-Jinnah', 'Changa Manga', 'Sozo Water Park',

                // Hospitals and Institutions
                'Mayo Hospital', 'Jinnah Hospital', 'Services Hospital', 'Shaukat Khanum',
                'Children Hospital', 'Punjab Institute of Cardiology',

                // Villages and Suburbs
                'Bhaipheru', 'Bhogiwal', 'Chah Miran', 'Dholanwal', 'Gajjumatta',
                'Hadiara', 'Jabbi', 'Khurd', 'Lalpura', 'Manga Mandi',
                'Niaz Beg', 'Pindorian', 'Qila Sattar Shah', 'Rakh Chandra',
                'Saggian', 'Tajoki', 'Umer Hayat', 'Virk', 'Wahndo', 'Yousafwala',
                'Ziauddin Park', 'other'
            ],
            'Islamabad' => [
                // Main Sectors
                'F-5', 'F-6', 'F-7', 'F-8', 'F-10', 'F-11',
                'G-5', 'G-6', 'G-7', 'G-8', 'G-9', 'G-10', 'G-11', 'G-13', 'G-14', 'G-15', 'G-16',
                'I-8', 'I-9', 'I-10', 'I-11', 'I-12', 'I-14', 'I-16',
                'H-8', 'H-9', 'H-10', 'H-11', 'H-12', 'H-13', 'H-15',
                'E-7', 'E-8', 'E-9', 'E-11', 'E-12', 'E-16',
                'D-10', 'D-12', 'D-13', 'D-15',
                'C-12', 'C-13', 'C-15', 'C-16',
                'B-17', 'B-18', 'B-19',

                // Sector Sub-Areas
                'F-6/1', 'F-6/2', 'F-6/3', 'F-7/1', 'F-7/2', 'F-7/3', 'F-7/4',
                'G-6/1', 'G-6/2', 'G-6/3', 'G-6/4', 'G-7/1', 'G-7/2', 'G-7/3', 'G-7/4',
                'I-8/1', 'I-8/2', 'I-8/3', 'I-8/4',

                // Housing Societies
                'Bahria Town', 'Bahria Enclave', 'Bahria Heights', 'DHA Phase 1', 'DHA Phase 2',
                'DHA Valley', 'Margalla Town', 'Margalla Hills', 'Bani Gala', 'Gulberg Greens',
                'Park View City', 'Capital Smart City', 'Top City', 'Swan Gardens', 'Seven Wonders',
                'Royal Orchard', 'Faisal Hills', 'Gulshan-e-Dhara', 'Lehtarar Scheme',

                // Commercial Areas
                'Blue Area', 'Jinnah Super Market', 'Super Market F-6', 'Jinnah Avenue',
                'Aabpara Market', 'Melody Market', 'Saddar', 'F-10 Markaz', 'F-11 Markaz',
                'G-9 Markaz', 'G-10 Markaz', 'I-8 Markaz', 'I-9 Markaz', 'I-10 Markaz',
                'H-9 Markaz', 'F-8 Markaz', 'Blue World City',

                // Diplomatic Enclave
                'Diplomatic Enclave', 'Sector G-5', 'Sector F-5',

                // Institutional Areas
                'Sector H-8 (Quaid-e-Azam University)', 'Sector H-9 (Air University)',
                'Sector H-12 (Shifa International)', 'Sector G-7 (PIMS Hospital)',
                'Sector G-5 (Supreme Court)', 'Sector F-5 (Parliament House)',
                'Sector E-8 (NUST)',

                // Rural Areas
                'Tarlai', 'Koral', 'Malot', 'Pind Begwal', 'Sihala', 'Tarnol', 'Sarai Kharboza',
                'Golra', 'Bhara Kahu', 'Shah Allah Ditta', 'Sohan', 'Jhang Syedan',

                // Landmarks
                'Faisal Mosque', 'Pakistan Monument', 'Lok Virsa', 'Shakarparian',
                'Daman-e-Koh', 'Pir Sohawa', 'Rawal Lake', 'Lake View Park',
                'Rose & Jasmine Garden', 'Fatima Jinnah Park',

                // Industrial Areas
                'I-9 Industrial Area', 'I-10 Industrial Area', 'Kahuta Industrial Triangle',

                // New Developments
                'New Islamabad Airport', 'CPEC Zone', 'ICT Model Zone',
                'Orchard Housing Scheme', 'OPF Housing Scheme', 'Senate Housing',

                // Roads & Highways
                'Srinagar Highway', 'Islamabad Highway', 'Margalla Road', 'Khayaban-e-Suharwardy',
                'Khayaban-e-Iqbal', 'Kashmir Highway', '9th Avenue', '7th Avenue',

                // Villages
                'Alipur Farash', 'Chak Shahzad', 'Humak', 'Kuri', 'Mohra Noor',
                'Noorpur Shahan', 'Phulgran', 'Shahpur', 'Sihala', 'other'
            ],
            'Rawalpindi' => [
                // Main Areas
                'Satellite Town', 'Chaklala Scheme I', 'Chaklala Scheme II', 'Chaklala Scheme III',
                'Westridge', 'Raja Bazaar', 'Bhabra Bazaar', 'Moti Bazaar', 'Sarafa Bazaar',
                'Pirwadhai', 'Adyala Road', 'Morgah', 'Tench Bhatta', 'Gulraiz', 'Gulzar-e-Quaid',
                'Bahria Town', 'DHA', 'Askari', 'Saddar', 'Cantt', 'People\'s Colony',
                'Sadiqabad', 'Misrial Road', 'Chak Jalal Din', 'Naseerabad', 'Khayaban-e-Sir Syed',

                // Housing Societies
                'Askari I', 'Askari II', 'Askari III', 'Askari IV', 'Askari V',
                'DHA Phase 1', 'DHA Phase 2', 'DHA Phase 3', 'DHA Phase 4',
                'Bahria Town Phase 1', 'Bahria Town Phase 2', 'Bahria Town Phase 3',
                'Bahria Town Phase 4', 'Bahria Town Phase 5', 'Bahria Town Phase 6',
                'Bahria Town Phase 7', 'Bahria Town Phase 8', 'Bahria Orchard',
                'Gulistan Colony', 'Gulrez Housing', 'Al-Haram City', 'Chaklala Heights',
                'Iqbal Town', 'Model Town', 'Muslim Town', 'PWD Housing', 'Rahimabad',

                // Commercial Areas
                'Commercial Market', 'Bank Road', 'Mareer Chowk', 'Bara Market',
                'Committee Chowk', 'Fawara Chowk', 'Lalkurti', 'Sadar Bazaar',
                'Trunk Bazaar', 'Jamiah Masjid Road', 'Mall Road', 'The Mall',
                'Haider Road', 'Liaquat Road', 'Murree Road', 'Iqbal Road',

                // Institutional Areas
                'Army Medical College', 'Military College', 'Punjab Medical College',
                'Rawalpindi Law College', 'Fatima Jinnah Women University',
                'Foundation University', 'Army Public School', 'FG Colleges',

                // Industrial Areas
                'Industrial Area', 'Koral Industrial Area', 'Kahuta Industrial Area',
                'Taxila Industrial Area', 'Wah Cantt Industrial Area',

                // Cantt Areas
                'Rawalpindi Cantt', 'Westridge Cantt', 'Chaklala Cantt',
                'General Headquarters (GHQ)', 'Army Housing', 'Peshawar Road Cantt',

                // Transport Hubs
                'Rawalpindi Railway Station', 'Pirwadhai Bus Stand', 'Soan Bus Terminal',
                'Faizabad Interchange', 'Zero Point', 'IJP Road', 'G.T. Road',
                'Islamabad Expressway', 'Airport Road',

                // Landmarks
                'Ayub National Park', 'Liaquat Bagh', 'Rawal Dam', 'Shah Faisal Mosque',
                'Army Museum', 'Golra Sharif', 'Taxila Museum', 'Sangjani Tunnel',

                // Villages & Suburbs
                'Gujar Khan', 'Kahuta', 'Kallar Syedan', 'Kotli Sattian', 'Murree',
                'Taxila', 'Wah Cantt', 'Adra', 'Bani', 'Chak Beli Khan',
                'Daultala', 'Dhamial', 'Ghari Khuda Bakhsh', 'Gulyana', 'Jand',
                'Jarma', 'Khanpur', 'Kuri', 'Mohra Shera', 'Phulgran',
                'Sihala', 'Tret', 'Tumair',

                // New Developments
                'Chakri Interchange', 'New Airport Housing', 'CPEC Route',
                'Ring Road Project', 'Rawalpindi Metro', 'Gwadar Avenue',

                // Religious Sites
                'Golra Sharif Shrine', 'Shah Chan Charagh', 'Imam Bara',
                'Kartarpura', 'Katra Khurd', 'Rawat Fort', 'other'
            ],
            'Faisalabad' => [
                'Madina Town', 'Peoples Colony', 'Jinnah Colony', 'D-Type Colony',
                'Gulberg', 'Samundri Road', 'Jaranwala Road', 'Sargodha Road',
                'Satiana Road', 'Millat Town', 'Lyallpur Town', 'Batala Colony',
                'Islamabad Colony', 'Nishatabad', 'Samanabad', 'Aminaabad', 'Kohinoor Town',
                'Ghulam Muhammadabad', 'Bhawana Colony', 'Abdullahpur', 'other'
            ],
            'Multan' => [
                'Cantt', 'Shah Rukn-e-Alam Colony', 'Bosan Town', 'Gulgasht Colony',
                'Shah Shams Colony', 'Sher Shah Town', 'DHA', 'Wapda Town',
                'Basti Daira', 'New Multan', 'Abdali Road', 'Kutchery Road',
                'Hussain Agahi', 'Bohar Gate', 'Lohari Gate', 'Haram Gate', 'Pak Gate',
                'Daulat Gate', 'Qila Kohna Qasim Bagh', 'Shah Abbas Colony', 'other'
            ],
            'Hyderabad' => [
                'Latifabad', 'Qasimabad', 'Hirabad', 'Saddar', 'Paretabad',
                'Jamia Millia', 'Market Tower', 'Station Road', 'Autobahn Road',
                'Sachal Goth', 'Hali Road', 'Shahbaz Nagar', 'SITE Area', 'Hussaini',
                'Risala Road', 'Kacha Jail Road', 'Tando Jam Road', 'National Highway',
                'Bahadur Yar Jang Colony', 'Jail Road', 'other'
            ],
            'Peshawar' => [
                'University Town', 'Hayatabad', 'Cantt', 'Gulbahar', 'Warsak Road',
                'Kohat Road', 'Charsadda Road', 'Sadar', 'Deans Trade Center',
                'Ring Road', 'Phase 1', 'Phase 2', 'Phase 3', 'Phase 4', 'Phase 5',
                'Phase 6', 'Phase 7', 'Jamrud Road', 'Khyber Road', 'Bara Road', 'other'
            ],
            'Quetta' => [
                'Jinnah Town', 'Samungli Road', 'Brewery Road', 'Prince Road',
                'Sariab Road', 'Airport Road', 'Spinny Road', 'Hanna Valley',
                'Koh-e-Murdar', 'Western Bypass', 'Eastern Bypass', 'Sabzal Road',
                'Mecongi Road', 'Kandahari Bazaar', 'Joint Road', 'Mian Ghundi',
                'Shahbaz Town', 'Model Town', 'Satellite Town', 'Killi Deba', 'other'
            ],
            'Gujranwala' => [
                'Cantt', 'Model Town', 'Nandipur', 'Khiyali', 'Sialkot Bypass',
                'Chenab Nagar', 'Eminabad', 'Kamoke', 'Kotli Loharan', 'Daska Road',
                'Sialkot Road', 'Lahore Road', 'Wapda Town', 'Ghakhar', 'Nizamabad',
                'Qila Didar Singh', 'Ali Pur Chatha', 'Aroop', 'Khiali Shahpur', 'Dholanwal', 'other'
            ],
            // Areas for other cities (shorter lists)
            'Bahawalpur' => ['Model Town', 'Cantt', 'Satellite Town', 'Islami Colony', 'Shahdani Colony', 'other'],
            'Sargodha' => ['Cantt', 'Satellite Town', 'Punjab Society', 'University Road', 'Jinnah Colony', 'other'],
            'Sialkot' => ['Cantt', 'Satellite Town', 'Model Town', 'Daska Road', 'Pasrur Road', 'other'],
            'Sukkur' => ['Rohri', 'Shikarpur Road', 'Airport Road', 'Military Road', 'Kannad', 'other'],
            'Larkana' => ['Cantt', 'Jinnah Bagh', 'Chowk', 'Railway Colony', 'Airport Road', 'other'],
            'Sheikhupura' => ['Model Town', 'Cantt', 'Farooqabad', 'Muridke', 'Ferozewala', 'other'],
            'Rahim Yar Khan' => ['Model Town', 'Cantt', 'Shaikh Zayed', 'Railway Colony', 'Sadiqabad Road', 'other'],
            'Jhang' => ['Satellite Town', 'Cantt', 'Shorkot Road', 'Chenab Nagar', 'Jhang Bazaar', 'other'],
            'Dera Ghazi Khan' => ['Cantt', 'Model Town', 'Taunsa Road', 'Sakhi Sarwar Road', 'Kot Chutta', 'other'],
            'Gujrat' => ['Cantt', 'Model Town', 'Kunjah Road', 'Sara-i-Alamgir', 'Kharian', 'other'],
            'Sahiwal' => ['Model Town', 'Cantt', 'Harappa Road', 'Jinnah Colony', 'Railway Colony', 'other'],
            'Kasur' => ['Model Town', 'Cantt', 'Chunian', 'Pattoki Road', 'Kot Radha Kishan', 'other'],
            'Okara' => ['Cantt', 'Model Town', 'Depalpur Road', 'Renala Khurd', 'Haveli Lakha', 'other'],
            'Chiniot' => ['Cantt', 'Lalian Road', 'Bhawana Road', 'Sargodha Road', 'Chenab Nagar', 'other'],
            'Kamoke' => ['Model Town', 'G.T. Road', 'Eminabad Road', 'Sialkot Road', 'Ghakhar', 'other'],
            'Burewala' => ['Model Town', 'Cantt', 'Vehari Road', 'Sahiwal Road', 'Mailsi Road', 'other'],
            'Jhelum' => ['Cantt', 'Model Town', 'GT Road', 'Kala Gujran', 'Pind Dadan Khan', 'other'],
            'Khanewal' => ['Model Town', 'Cantt', 'Kabirwala Road', 'Multan Road', 'Tulamba', 'other'],
            'Hafizabad' => ['Model Town', 'Sukheki', 'Pindi Bhattian', 'Jalalpur Bhattian', 'Gujranwala Road', 'other'],
            'Muzaffargarh' => ['Model Town', 'Cantt', 'Alipur Road', 'Kot Addu Road', 'Jatoi', 'other'],
            'Khanpur' => ['Model Town', 'Cantt', 'Liaquatpur Road', 'Rahim Yar Khan Road', 'Sadiqabad Road', 'other'],
            'Gojra' => ['Model Town', 'Cantt', 'Samundri Road', 'Jhang Road', 'Toba Tek Singh Road', 'other'],
            'Mandi Bahauddin' => ['Model Town', 'Cantt', 'Phalia', 'Malakwal', 'Kuthiala Sheikhan', 'other'],
            'Abbottabad' => ['Cantt', 'Model Town', 'Jinnahabad', 'Nathia Gali', 'Havelian', 'other'],
            'Turbat' => ['Model Town', 'Airport Road', 'Gokdan Road', 'Sarab Road', 'Kech', 'other'],
            'Dadu' => ['Model Town', 'Cantt', 'Sehwan Road', 'Johi Road', 'Mehar', 'other'],
            'Bahawalnagar' => ['Model Town', 'Cantt', 'Fort Abbas Road', 'Haroonabad Road', 'Chishtian', 'other'],
            'Pakpattan' => ['Model Town', 'Cantt', 'Arifwala Road', 'Sahiwal Road', 'Depalpur Road', 'other'],
            'Khuzdar' => ['Model Town', 'Cantt', 'Quetta Road', 'Kalat Road', 'Wadh', 'other'],
            'Chaman' => ['Model Town', 'Cantt', 'Afghan Border', 'Quetta Road', 'Spin Boldak', 'other'],
            'Gilgit' => ['Jutial', 'Nagar Road', 'Skardu Road', 'Juglot', 'Danyore', 'other'],
            'Muzaffarabad' => ['Model Town', 'Cantt', 'Neelum Road', 'Jhelum Road', 'Patika', 'other'],
            'Kotli' => ['Model Town', 'Cantt', 'Rawalakot Road', 'Mirpur Road', 'Sehnsa', 'other'],
            'Mirpur' => ['Model Town', 'Cantt', 'Islamgarh', 'Dadyal', 'Chakswari', 'other'],
        ];

        // Reverse mapping: city => province
        $cityToProvince = [];
        foreach ($provinceCityMap as $province => $cities) {
            foreach ($cities as $city) {
                $cityToProvince[$city] = $province;
            }
        }

        $cities = [
            'Karachi', 'Lahore', 'Faisalabad', 'Rawalpindi', 'Gujranwala',
            'Peshawar', 'Multan', 'Hyderabad', 'Islamabad', 'Quetta',
            'Bahawalpur', 'Sargodha', 'Sialkot', 'Sukkur', 'Larkana',
            'Sheikhupura', 'Rahim Yar Khan', 'Jhang', 'Dera Ghazi Khan',
            'Gujrat', 'Sahiwal', 'Wah Cantonment', 'Mardan', 'Kasur',
            'Okara', 'Mingora', 'Nawabshah', 'Mirpur Khas', 'Chiniot',
            'Kamoke', 'Burewala', 'Jacobabad', 'Jhelum', 'Khanewal',
            'Hafizabad', 'Dera Ismail Khan', 'Tando Adam', 'Chakwal',
            'Khairpur', 'Kohat', 'Muzaffargarh', 'Khanpur', 'Gojra',
            'Mandi Bahauddin', 'Abbottabad', 'Turbat', 'Dadu', 'Bahawalnagar',
            'Samundri', 'Tando Allahyar', 'Pakpattan', 'Khuzdar', 'Jaranwala',
            'Chaman', 'Vihari', 'Kamalia', 'Kot Addu', 'Gilgit', 'Jatoi',
            'Gujar Khan', 'Shikarpur', 'Hasilpur', 'Muzaffarabad', 'Narowal',
            'Charsadda', 'Tando Muhammad Khan', 'Mirpur', 'Kabal', 'Shahdadkot',
            'Mansehra', 'Layyah', 'Karak', 'Haripur', 'Lodhran', 'Mianwali',
            'Shikarpur', 'Matiari', 'Tando Bago', 'Tank', 'Thatta', 'Zhob',
            'Sanghar', 'Pattoki', 'Umerkot', 'Swabi', 'Attock', 'Badin',
            'Daska', 'Hangu', 'Chitral', 'Jhang', 'Naushahro Feroze', 'Timergara',
            'Kotli', 'Loralai', 'Jamshoro', 'Shahdadpur'
        ];

        foreach ($cities as $cityName) {
            $provinceName = $cityToProvince[$cityName] ?? 'Punjab'; // default to Punjab
            $province = Province::where('name', $provinceName)->first();

            if ($province) {
                $city = City::create([
                    'name' => $cityName,
                    'province_id' => $province->id,
                ]);

                // Add areas if they exist for this city
                if (isset($cityAreas[$cityName])) {
                    foreach ($cityAreas[$cityName] as $areaName) {
                        Area::create([
                            'name' => $areaName,
                            'city_id' => $city->id,
                        ]);
                    }
                } else {
                    // Add a default area for cities without specific areas defined
                    Area::create([
                        'name' => 'Main Town',
                        'city_id' => $city->id,
                    ]);
                }
            }
        }
    }
}
