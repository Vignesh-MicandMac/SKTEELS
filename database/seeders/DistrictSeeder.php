<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('districts')->forceDelete();
        // $districts = [
        //     ['id' => 1, 'state_id' => 12, 'district_name' => 'Alappuzha'],
        //     ['id' => 2, 'state_id' => 12, 'district_name' => 'Ernakulam'],
        //     ['id' => 3, 'state_id' => 12, 'district_name' => 'Idukki'],
        //     ['id' => 4, 'state_id' => 12, 'district_name' => 'Kannur'],
        //     ['id' => 5, 'state_id' => 12, 'district_name' => 'Kasaragod'],
        //     ['id' => 6, 'state_id' => 12, 'district_name' => 'Kollam'],
        //     ['id' => 7, 'state_id' => 12, 'district_name' => 'Kottayam'],
        //     ['id' => 8, 'state_id' => 12, 'district_name' => 'Kozhikode'],
        //     ['id' => 9, 'state_id' => 12, 'district_name' => 'Malappuram'],
        //     ['id' => 10, 'state_id' => 12, 'district_name' => 'Palakkad'],
        //     ['id' => 11, 'state_id' => 12, 'district_name' => 'Pathanamthitta'],
        //     ['id' => 12, 'state_id' => 12, 'district_name' => 'Thiruvananthapuram'],
        //     ['id' => 13, 'state_id' => 12, 'district_name' => 'Thrissur'],
        //     ['id' => 14, 'state_id' => 12, 'district_name' => 'Wayanad'],
        //     ['id' => 15, 'state_id' => 23, 'district_name' => 'Ariyalur'],
        //     ['id' => 16, 'state_id' => 23, 'district_name' => 'Chengalpattu'],
        //     ['id' => 17, 'state_id' => 23, 'district_name' => 'Chennai'],
        //     ['id' => 18, 'state_id' => 23, 'district_name' => 'Coimbatore'],
        //     ['id' => 19, 'state_id' => 23, 'district_name' => 'Cuddalore'],
        //     ['id' => 20, 'state_id' => 23, 'district_name' => 'Dharmapuri'],
        //     ['id' => 21, 'state_id' => 23, 'district_name' => 'Dindigul'],
        //     ['id' => 22, 'state_id' => 23, 'district_name' => 'Erode'],
        //     ['id' => 23, 'state_id' => 23, 'district_name' => 'Kallakurichi'],
        //     ['id' => 24, 'state_id' => 23, 'district_name' => 'Kanchipuram'],
        //     ['id' => 25, 'state_id' => 23, 'district_name' => 'Kanyakumari'],
        //     ['id' => 26, 'state_id' => 23, 'district_name' => 'Karur'],
        //     ['id' => 27, 'state_id' => 23, 'district_name' => 'Krishnagiri'],
        //     ['id' => 28, 'state_id' => 23, 'district_name' => 'Madurai'],
        //     ['id' => 29, 'state_id' => 23, 'district_name' => 'Nagapattinam'],
        //     ['id' => 30, 'state_id' => 23, 'district_name' => 'Namakkal'],
        //     ['id' => 31, 'state_id' => 23, 'district_name' => 'Nilgiris'],
        //     ['id' => 32, 'state_id' => 23, 'district_name' => 'Perambalur'],
        //     ['id' => 33, 'state_id' => 23, 'district_name' => 'Pudukkottai'],
        //     ['id' => 34, 'state_id' => 23, 'district_name' => 'Ramanathapuram'],
        //     ['id' => 35, 'state_id' => 23, 'district_name' => 'Ranipet'],
        //     ['id' => 36, 'state_id' => 23, 'district_name' => 'Salem'],
        //     ['id' => 37, 'state_id' => 23, 'district_name' => 'Sivaganga'],
        //     ['id' => 38, 'state_id' => 23, 'district_name' => 'Tenkasi'],
        //     ['id' => 39, 'state_id' => 23, 'district_name' => 'Thanjavur'],
        //     ['id' => 40, 'state_id' => 23, 'district_name' => 'Theni'],
        //     ['id' => 41, 'state_id' => 23, 'district_name' => 'Thiruvallur'],
        //     ['id' => 42, 'state_id' => 23, 'district_name' => 'Thiruvarur'],
        //     ['id' => 43, 'state_id' => 23, 'district_name' => 'Tuticorin'],
        //     ['id' => 44, 'state_id' => 23, 'district_name' => 'Tiruchirappalli'],
        //     ['id' => 45, 'state_id' => 23, 'district_name' => 'Tirunelveli'],
        //     ['id' => 46, 'state_id' => 23, 'district_name' => 'Tirupathur'],
        //     ['id' => 47, 'state_id' => 23, 'district_name' => 'Tiruppur'],
        //     ['id' => 48, 'state_id' => 23, 'district_name' => 'Tiruvannamalai'],
        //     ['id' => 49, 'state_id' => 23, 'district_name' => 'Vellore'],
        //     ['id' => 50, 'state_id' => 23, 'district_name' => 'Viluppuram'],
        //     ['id' => 51, 'state_id' => 23, 'district_name' => 'Virudhunagar'],
        // ];

        $districts = [

            // Tamil Nadu (state_id: 1)
            ['id' => 15, 'state_id' => 1, 'district_name' => 'Ariyalur'],
            ['id' => 16, 'state_id' => 1, 'district_name' => 'Chengalpattu'],
            ['id' => 17, 'state_id' => 1, 'district_name' => 'Chennai'],
            ['id' => 18, 'state_id' => 1, 'district_name' => 'Coimbatore'],
            ['id' => 19, 'state_id' => 1, 'district_name' => 'Cuddalore'],
            ['id' => 20, 'state_id' => 1, 'district_name' => 'Dharmapuri'],
            ['id' => 21, 'state_id' => 1, 'district_name' => 'Dindigul'],
            ['id' => 22, 'state_id' => 1, 'district_name' => 'Erode'],
            ['id' => 23, 'state_id' => 1, 'district_name' => 'Kallakurichi'],
            ['id' => 24, 'state_id' => 1, 'district_name' => 'Kanchipuram'],
            ['id' => 25, 'state_id' => 1, 'district_name' => 'Kanyakumari'],
            ['id' => 26, 'state_id' => 1, 'district_name' => 'Karur'],
            ['id' => 27, 'state_id' => 1, 'district_name' => 'Krishnagiri'],
            ['id' => 28, 'state_id' => 1, 'district_name' => 'Madurai'],
            ['id' => 29, 'state_id' => 1, 'district_name' => 'Mayiladuthurai'],
            ['id' => 30, 'state_id' => 1, 'district_name' => 'Nagapattinam'],
            ['id' => 31, 'state_id' => 1, 'district_name' => 'Namakkal'],
            ['id' => 32, 'state_id' => 1, 'district_name' => 'Nilgiris'],
            ['id' => 33, 'state_id' => 1, 'district_name' => 'Perambalur'],
            ['id' => 34, 'state_id' => 1, 'district_name' => 'Pudukkottai'],
            ['id' => 35, 'state_id' => 1, 'district_name' => 'Ramanathapuram'],
            ['id' => 36, 'state_id' => 1, 'district_name' => 'Ranipet'],
            ['id' => 37, 'state_id' => 1, 'district_name' => 'Salem'],
            ['id' => 38, 'state_id' => 1, 'district_name' => 'Sivaganga'],
            ['id' => 39, 'state_id' => 1, 'district_name' => 'Tenkasi'],
            ['id' => 40, 'state_id' => 1, 'district_name' => 'Thanjavur'],
            ['id' => 41, 'state_id' => 1, 'district_name' => 'Theni'],
            ['id' => 42, 'state_id' => 1, 'district_name' => 'Thiruvallur'],
            ['id' => 43, 'state_id' => 1, 'district_name' => 'Thiruvarur'],
            ['id' => 44, 'state_id' => 1, 'district_name' => 'Thoothukudi'], // Corrected name for Tuticorin
            ['id' => 45, 'state_id' => 1, 'district_name' => 'Tiruchirappalli'],
            ['id' => 46, 'state_id' => 1, 'district_name' => 'Tirunelveli'],
            ['id' => 47, 'state_id' => 1, 'district_name' => 'Tirupathur'],
            ['id' => 48, 'state_id' => 1, 'district_name' => 'Tiruppur'],
            ['id' => 49, 'state_id' => 1, 'district_name' => 'Tiruvannamalai'],
            ['id' => 50, 'state_id' => 1, 'district_name' => 'Vellore'],
            ['id' => 51, 'state_id' => 1, 'district_name' => 'Viluppuram'],
            ['id' => 52, 'state_id' => 1, 'district_name' => 'Virudhunagar'],


            // Kerala (state_id: 2)
            ['id' => 1, 'state_id' => 2, 'district_name' => 'Alappuzha'],
            ['id' => 2, 'state_id' => 2, 'district_name' => 'Ernakulam'],
            ['id' => 3, 'state_id' => 2, 'district_name' => 'Idukki'],
            ['id' => 4, 'state_id' => 2, 'district_name' => 'Kannur'],
            ['id' => 5, 'state_id' => 2, 'district_name' => 'Kasaragod'],
            ['id' => 6, 'state_id' => 2, 'district_name' => 'Kollam'],
            ['id' => 7, 'state_id' => 2, 'district_name' => 'Kottayam'],
            ['id' => 8, 'state_id' => 2, 'district_name' => 'Kozhikode'],
            ['id' => 9, 'state_id' => 2, 'district_name' => 'Malappuram'],
            ['id' => 10, 'state_id' => 2, 'district_name' => 'Palakkad'],
            ['id' => 11, 'state_id' => 2, 'district_name' => 'Pathanamthitta'],
            ['id' => 12, 'state_id' => 2, 'district_name' => 'Thiruvananthapuram'],
            ['id' => 13, 'state_id' => 2, 'district_name' => 'Thrissur'],
            ['id' => 14, 'state_id' => 2, 'district_name' => 'Wayanad'],


            // Karnataka (state_id: 3)
            ['id' => 53, 'state_id' => 3, 'district_name' => 'Bagalkot'],
            ['id' => 54, 'state_id' => 3, 'district_name' => 'Ballari'],
            ['id' => 55, 'state_id' => 3, 'district_name' => 'Belagavi'],
            ['id' => 56, 'state_id' => 3, 'district_name' => 'Bengaluru Rural'],
            ['id' => 57, 'state_id' => 3, 'district_name' => 'Bengaluru Urban'],
            ['id' => 58, 'state_id' => 3, 'district_name' => 'Bidar'],
            ['id' => 59, 'state_id' => 3, 'district_name' => 'Chamarajanagar'],
            ['id' => 60, 'state_id' => 3, 'district_name' => 'Chikkaballapur'],
            ['id' => 61, 'state_id' => 3, 'district_name' => 'Chikkamagaluru'],
            ['id' => 62, 'state_id' => 3, 'district_name' => 'Chitradurga'],
            ['id' => 63, 'state_id' => 3, 'district_name' => 'Dakshina Kannada'],
            ['id' => 64, 'state_id' => 3, 'district_name' => 'Davangere'],
            ['id' => 65, 'state_id' => 3, 'district_name' => 'Dharwad'],
            ['id' => 66, 'state_id' => 3, 'district_name' => 'Gadag'],
            ['id' => 67, 'state_id' => 3, 'district_name' => 'Hassan'],
            ['id' => 68, 'state_id' => 3, 'district_name' => 'Haveri'],
            ['id' => 69, 'state_id' => 3, 'district_name' => 'Kalaburagi'],
            ['id' => 70, 'state_id' => 3, 'district_name' => 'Kodagu'],
            ['id' => 71, 'state_id' => 3, 'district_name' => 'Kolar'],
            ['id' => 72, 'state_id' => 3, 'district_name' => 'Koppal'],
            ['id' => 73, 'state_id' => 3, 'district_name' => 'Mandya'],
            ['id' => 74, 'state_id' => 3, 'district_name' => 'Mysuru'],
            ['id' => 75, 'state_id' => 3, 'district_name' => 'Raichur'],
            ['id' => 76, 'state_id' => 3, 'district_name' => 'Ramanagara'],
            ['id' => 77, 'state_id' => 3, 'district_name' => 'Shivamogga'],
            ['id' => 78, 'state_id' => 3, 'district_name' => 'Tumakuru'],
            ['id' => 79, 'state_id' => 3, 'district_name' => 'Udupi'],
            ['id' => 80, 'state_id' => 3, 'district_name' => 'Uttara Kannada'],
            ['id' => 81, 'state_id' => 3, 'district_name' => 'Vijayanagara'],
            ['id' => 82, 'state_id' => 3, 'district_name' => 'Vijayapura'],
            ['id' => 83, 'state_id' => 3, 'district_name' => 'Yadgir'],

            // Andhra Pradesh (state_id: 4)
            ['id' => 84, 'state_id' => 4, 'district_name' => 'Alluri Sitharama Raju'],
            ['id' => 85, 'state_id' => 4, 'district_name' => 'Anakapalli'],
            ['id' => 86, 'state_id' => 4, 'district_name' => 'Anantapur'],
            ['id' => 87, 'state_id' => 4, 'district_name' => 'Annamayya'],
            ['id' => 88, 'state_id' => 4, 'district_name' => 'Bapatla'],
            ['id' => 89, 'state_id' => 4, 'district_name' => 'Chittoor'],
            ['id' => 90, 'state_id' => 4, 'district_name' => 'Dr. B.R. Ambedkar Konaseema'],
            ['id' => 91, 'state_id' => 4, 'district_name' => 'East Godavari'],
            ['id' => 92, 'state_id' => 4, 'district_name' => 'Eluru'],
            ['id' => 93, 'state_id' => 4, 'district_name' => 'Guntur'],
            ['id' => 94, 'state_id' => 4, 'district_name' => 'Kadapa'],
            ['id' => 95, 'state_id' => 4, 'district_name' => 'Krishna'],
            ['id' => 96, 'state_id' => 4, 'district_name' => 'Kurnool'],
            ['id' => 97, 'state_id' => 4, 'district_name' => 'Manyam'],
            ['id' => 98, 'state_id' => 4, 'district_name' => 'Nandyal'],
            ['id' => 99, 'state_id' => 4, 'district_name' => 'Nellore'],
            ['id' => 100, 'state_id' => 4, 'district_name' => 'Palnadu'],
            ['id' => 101, 'state_id' => 4, 'district_name' => 'Parvathipuram'],
            ['id' => 102, 'state_id' => 4, 'district_name' => 'Prakasam'],
            ['id' => 103, 'state_id' => 4, 'district_name' => 'Sri Balaji'],
            ['id' => 104, 'state_id' => 4, 'district_name' => 'Sri Potti Sriramulu Nellore'],
            ['id' => 105, 'state_id' => 4, 'district_name' => 'Sri Sathya Sai'],
            ['id' => 106, 'state_id' => 4, 'district_name' => 'Srikakulam'],
            ['id' => 107, 'state_id' => 4, 'district_name' => 'Visakhapatnam'],
            ['id' => 108, 'state_id' => 4, 'district_name' => 'Vizianagaram'],
            ['id' => 109, 'state_id' => 4, 'district_name' => 'West Godavari'],
        ];

        foreach ($districts as $district) {
            District::updateOrCreate(['id' => $district['id']], $district);
        }
    }
}
