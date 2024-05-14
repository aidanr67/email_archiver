<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class SeedEmailTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Email::factory()->count(5)->create();
    }
}
