<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Models\Vaccine;
use GuzzleHttp\Psr7\Header;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpotTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all_vaccine_spots(): void
    {
        $vaccines = Vaccine::all("name");
        $vaccine_name = [];
        foreach ($vaccines as $vc) {
            $vaccine_name[] = $vc["name"];
        }
        $response = $this->get('/api/v1/spots', headers: [
            "token" => "c4ca4238a0b923820dcc509a6f75849b"
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "spots" => [
                    [
                        "name", "address", "serve", "capacity", "available_vaccines" => $vaccine_name
                    ]
                ]
            ]);
    }
    function test_get_spot_by_id_and_date()
    {
        $spot = Spot::all()->first();
        $this->get("/api/v1/spots/" . $spot->id, headers: [
            "token" => "c4ca4238a0b923820dcc509a6f75849b"
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "date", "spot", "vaccinations_count"
            ]);

        $date = date("Y-m-d", strtotime($spot->created_at));
        $this->get("/api/v1/spots/" . $spot->id . "/?date=" . $date, headers: [
            "token" => "c4ca4238a0b923820dcc509a6f75849b"
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "date", "spot", "vaccinations_count"
            ]);
    }
}
