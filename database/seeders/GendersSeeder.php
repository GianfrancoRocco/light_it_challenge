<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            ['description' => 'male'],
            ['description' => 'female']
        ];
        
        foreach($genders as $gender) {
            if (!Gender::where('description', $gender)->exists()) {
                Gender::create($gender);
            }
        }
    }
}
