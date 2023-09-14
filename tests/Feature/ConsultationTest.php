<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ConsultationSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ConsultationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_consultation(): void
    {
        $this->get("/api/v1/consultations", headers: [
            "token" => md5(1)
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "consultation" => [
                    "id",
                    "status",
                    "current_symptoms",
                    "disease_history",
                    "notes",
                    "doctor" => ["name"]
                ]
            ]);
    }
    function test_request_consultation(): void
    {
        $this->post("/api/v1/consultations", [
            "current_symptoms" => "test",
            "disease_history" => "test",
        ], [
            "token" => md5(1)
        ])
            ->assertStatus(201)
            ->assertJson([
                "message" => "Request consultation sent successful"
            ]);
    }
    function test_request_consultation_failed() :void {
        $this->post("/api/v1/consultations", headers: [
            "token" => md5(1)
        ])
            ->assertStatus(400)
            ->assertJson([
                "errors"=> [
                    "disease_history"=> [
                        "The disease history field is required."
                    ],
                    "current_symptoms"=> [
                        "The current symptoms field is required."
                    ]
                ]
            ]);
    }
}
