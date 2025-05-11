<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Prueba',
            'last_name' => 'Good',
            'email' => 'prueba@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->documents()->create([
            'document_type' => strtoupper('DNI'),
            'document_number' => '48969246',
        ]);
        
        $user->phones()->create([
            'number' => '937366147',
        ]);
    }
}
