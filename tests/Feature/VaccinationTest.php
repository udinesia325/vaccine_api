<?php

namespace Tests\Feature;

use App\Models\Consultations;
use App\Models\User;
use App\Models\Vaccinations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VaccinationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_vaccination()
    {
        $user =  User::create([
            "id_card_number" => 1,
            "password" => Hash::make("test"),
            "name" => "test",
            "born_date" => "2003-10-18",
            "gender" => "male",
            "address" => "malang",
            "regional_id" => 1,
            "token" => md5(4)
        ]);

        $this->post("/api/v1/vaccinations", [
            "spot_id" => 1,
            "date" => "2023-09-16"
        ], [
            "token" => $user->token
        ])
            ->assertStatus(201)
            ->assertJson([
                "message" => "First vaccination registered successful"
            ]);

        $this->post("/api/v1/vaccinations", [
            "spot_id" => 1,
            "date" => "2023-09-17"
        ], [
            "token" => $user->token
        ])
            ->assertStatus(400)
            ->assertJson([
                "message" => "Your consultation must be accepted by doctor before"
            ]);
        $consultations = Consultations::create([
            "user_id" => $user->id,
            "doctor_id" => 1,
            "status" => "accepted",
            "disease_history" => "dizzy",
            "current_symptoms" => "headache",
            "notes" => "take a rest"
        ]);
        $this->post("/api/v1/vaccinations", [
            "spot_id" => 1,
            "date" => "2023-09-17"
        ], [
            "token" => $user->token
        ])
            ->assertStatus(400)
            ->assertJson([
                "message" => "Wait at least +30 days from 1st Vaccination"
            ]);

        $this->post("/api/v1/vaccinations", [
            "spot_id" => 1,
            "date" => "2023-10-17"
        ], [
            "token" => $user->token
        ])
            ->assertStatus(201)
            ->assertJson([
                "message" => "Second vaccination registered successful"
            ]);
        DB::delete("delete from vaccinations where user_id = '$user->id'");
        $consultations->forceDelete();
        $user->forceDelete();
    }
    public function test_invalid_validation()
    {
        $user =  User::create([
            "id_card_number" => 1,
            "password" => Hash::make("test"),
            "name" => "test",
            "born_date" => "2003-10-18",
            "gender" => "male",
            "address" => "malang",
            "regional_id" => 1,
            "token" => md5(4)
        ]);
        $this->post("/api/v1/vaccinations", [
            "spot_id" => null,
            "date" => "invalid"
        ], [
            "token" => $user->token
        ])
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "spot_id" => [
                        "The spot id field is required."
                    ],
                    "date" => [
                        "The date field must match the format Y-m-d."
                    ]
                ]
            ]);
        $user->forceDelete();
    }
    public function test_get_vaccinatons()
    {
        $this->get("/api/v1/vaccinations", headers: [
            "token" => md5("test_vaccination")
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "vaccinations" => [
                    "first" => [
                        "queue", "vaccination_date", "spot" => [
                            "id",
                            "regional_id",
                            "name",
                            "address",
                            "serve",
                            "capacity",
                            "regional" => [
                                "id",
                                "province",
                                "district"
                            ]
                        ],
                        "status",
                        "vaccine" => [
                            "id",
                            "name"
                        ],
                        "vaccinator" => [
                            "id",
                            "role",
                            "name"
                        ]
                    ]
                ]

            ]);
    }
}
