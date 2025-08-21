<?php

namespace Database\Seeders;

use App\Models\States;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->delete();
        $states = [
            ['id' => 1, 'state_code' => 'TN', 'state_name' => 'Tamil Nadu'],
            ['id' => 2, 'state_code' => 'KL', 'state_name' => 'Kerala'],
            ['id' => 3, 'state_code' => 'KA', 'state_name' => 'Karnataka'],
            ['id' => 4, 'state_code' => 'AP', 'state_name' => 'Andhra Pradesh'],
        ];

        foreach ($states as $state) {
            States::updateOrCreate(['id' => $state['id']], $state);
        }
    }
}
