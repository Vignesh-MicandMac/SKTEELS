<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['id' => 1, 'state_id' => 12, 'district_name' => 'Alappuzha'],
            ['id' => 2, 'state_id' => 12, 'district_name' => 'Ernakulam'],
            ['id' => 3, 'state_id' => 12, 'district_name' => 'Idukki'],
            ['id' => 4, 'state_id' => 12, 'district_name' => 'Kannur'],
            ['id' => 5, 'state_id' => 12, 'district_name' => 'Kasaragod'],
            ['id' => 6, 'state_id' => 12, 'district_name' => 'Kollam'],
            ['id' => 7, 'state_id' => 12, 'district_name' => 'Kottayam'],
            ['id' => 8, 'state_id' => 12, 'district_name' => 'Kozhikode'],
            ['id' => 9, 'state_id' => 12, 'district_name' => 'Malappuram'],
            ['id' => 10, 'state_id' => 12, 'district_name' => 'Palakkad'],
            ['id' => 11, 'state_id' => 12, 'district_name' => 'Pathanamthitta'],
            ['id' => 12, 'state_id' => 12, 'district_name' => 'Thiruvananthapuram'],
            ['id' => 13, 'state_id' => 12, 'district_name' => 'Thrissur'],
            ['id' => 14, 'state_id' => 12, 'district_name' => 'Wayanad'],
            ['id' => 15, 'state_id' => 23, 'district_name' => 'Ariyalur'],
            ['id' => 16, 'state_id' => 23, 'district_name' => 'Chengalpattu'],
            ['id' => 17, 'state_id' => 23, 'district_name' => 'Chennai'],
            ['id' => 18, 'state_id' => 23, 'district_name' => 'Coimbatore'],
            ['id' => 19, 'state_id' => 23, 'district_name' => 'Cuddalore'],
            ['id' => 20, 'state_id' => 23, 'district_name' => 'Dharmapuri'],
            ['id' => 21, 'state_id' => 23, 'district_name' => 'Dindigul'],
            ['id' => 22, 'state_id' => 23, 'district_name' => 'Erode'],
            ['id' => 23, 'state_id' => 23, 'district_name' => 'Kallakurichi'],
            ['id' => 24, 'state_id' => 23, 'district_name' => 'Kanchipuram'],
            ['id' => 25, 'state_id' => 23, 'district_name' => 'Kanyakumari'],
            ['id' => 26, 'state_id' => 23, 'district_name' => 'Karur'],
            ['id' => 27, 'state_id' => 23, 'district_name' => 'Krishnagiri'],
            ['id' => 28, 'state_id' => 23, 'district_name' => 'Madurai'],
            ['id' => 29, 'state_id' => 23, 'district_name' => 'Nagapattinam'],
            ['id' => 30, 'state_id' => 23, 'district_name' => 'Namakkal'],
            ['id' => 31, 'state_id' => 23, 'district_name' => 'Nilgiris'],
            ['id' => 32, 'state_id' => 23, 'district_name' => 'Perambalur'],
            ['id' => 33, 'state_id' => 23, 'district_name' => 'Pudukkottai'],
            ['id' => 34, 'state_id' => 23, 'district_name' => 'Ramanathapuram'],
            ['id' => 35, 'state_id' => 23, 'district_name' => 'Ranipet'],
            ['id' => 36, 'state_id' => 23, 'district_name' => 'Salem'],
            ['id' => 37, 'state_id' => 23, 'district_name' => 'Sivaganga'],
            ['id' => 38, 'state_id' => 23, 'district_name' => 'Tenkasi'],
            ['id' => 39, 'state_id' => 23, 'district_name' => 'Thanjavur'],
            ['id' => 40, 'state_id' => 23, 'district_name' => 'Theni'],
            ['id' => 41, 'state_id' => 23, 'district_name' => 'Thiruvallur'],
            ['id' => 42, 'state_id' => 23, 'district_name' => 'Thiruvarur'],
            ['id' => 43, 'state_id' => 23, 'district_name' => 'Tuticorin'],
            ['id' => 44, 'state_id' => 23, 'district_name' => 'Tiruchirappalli'],
            ['id' => 45, 'state_id' => 23, 'district_name' => 'Tirunelveli'],
            ['id' => 46, 'state_id' => 23, 'district_name' => 'Tirupathur'],
            ['id' => 47, 'state_id' => 23, 'district_name' => 'Tiruppur'],
            ['id' => 48, 'state_id' => 23, 'district_name' => 'Tiruvannamalai'],
            ['id' => 49, 'state_id' => 23, 'district_name' => 'Vellore'],
            ['id' => 50, 'state_id' => 23, 'district_name' => 'Viluppuram'],
            ['id' => 51, 'state_id' => 23, 'district_name' => 'Virudhunagar'],
        ];


        foreach ($districts as $district) {
            District::updateOrCreate(['id' => $district['id']], $district);
        }
    }
}
