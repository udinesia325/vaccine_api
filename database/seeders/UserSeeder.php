<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "id_card_number" => 1 ,
            "password" => Hash::make("test"),
            "name" => "test",
            "born_date" => "2003-10-18",
            "gender" => "male",
            "address" => "malang",
            "regional_id" => 1
        ]);
    }
}
