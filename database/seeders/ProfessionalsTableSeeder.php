<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Professional;

class ProfessionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('professionals')->insert([
            'name' => 'Dr. Jane Doe',
            'email' => 'janedoe@example.com',
            'specialization' => 'Psychologist',
            'bio' => 'Dr. Jane Doe has over 10 years of experience in clinical psychology.',
        ]);

        // You can add more insertions here if needed
    }
}
