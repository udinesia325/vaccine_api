<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Doctor;
use App\Models\Medical;
use App\Models\Regional;
use App\Models\Spot;
use App\Models\SpotVaccines;
use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $vaccines = [
            "Sinovac",
            "AstraZeneca",
            "Moderna",
            "Pfizer",
            "Sinnopharm"
        ];
        foreach ($vaccines as $vaccine) {
            Vaccine::create([
                "name" => $vaccine
            ]);
        }
        Doctor::create([
            "username"=> "Dr." . fake()->firstNameMale(),
            "password" => Hash::make("rahasia")
        ]);
        Regional::create([
            "province" => "East Java",
            "district" => "Malang"
        ]);
        Spot::create([
            "regional_id" => 1,
            "name" => "Rumah sakit islam",
            "address"=> "Jl kh hasyim asyari",
            "serve" => "2",
            "capacity"=>20
        ]);
        $spotVaccines = [
            ["spot_id" => 1,"vaccine_id"=>1],
            ["spot_id" => 1,"vaccine_id"=>2],
            ["spot_id" => 1,"vaccine_id"=>4]
        ];
        foreach ($spotVaccines as $spv) {
            SpotVaccines::create($spv);
        }

        Medical::create([
            "spot_id"=> 1,
            "doctor_id" => 1,
            "role" => "doctor"
        ]);
    }
}
