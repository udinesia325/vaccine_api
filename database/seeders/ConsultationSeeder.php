<?php

namespace Database\Seeders;

use App\Models\Consultations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Consultations::create([
            "user_id" => 1,
            "doctor_id" => 1,
            "status" => "accepted",
            "disease_history" => "dizzy",
            "current_symptoms" => "headache",
            "notes" => "take a rest"
        ]);
    }
}
