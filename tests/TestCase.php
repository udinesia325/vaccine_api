<?php

namespace Tests;

use App\Models\Doctor;
use App\Models\Medical;
use App\Models\Regional;
use App\Models\Spot;
use App\Models\User;
use App\Models\Vaccinations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        // untuk test vaccination
        $doctor = Doctor::create([
            "username" => "test_vaccination",
            "password" => Hash::make("rahasia")
        ]);
        $regional = Regional::create([
            "province" => "test_vaccination",
            "district" => "Malang"
        ]);
        $spot = Spot::create([
            "regional_id" => 1,
            "name" => "test_vaccination",
            "address" => "Jl kh hasyim asyari",
            "serve" => "2",
            "capacity" => 20
        ]);
        $medical = Medical::create([
            "spot_id" => $spot->id,
            "doctor_id" => $doctor->id,
            "role" => "doctor",
            "name" => "test_vaccination"
        ]);
        $user = User::create([
            "id_card_number" => 1,
            "password" => Hash::make("test"),
            "name" => "test_vaccination",
            "born_date" => "2003-10-18",
            "gender" => "male",
            "address" => "malang",
            "regional_id" => $regional->id,
            "token" => md5("test_vaccination")
        ]);
        Vaccinations::create([
            "dose" => 1,
            "date" => "2000-09-16",
            "user_id" => $user->id,
            "spot_id" => $spot->id,
            "vaccine_id" => 1,
            "medical_id" => $medical->id
        ]);
    }
    protected function tearDown(): void
    {
        DB::delete("delete from vaccinations where date = '2000-09-16'");
        DB::delete("delete from user where name = 'test_vaccination'");
        DB::delete("delete from medical where name = 'test_vaccination'");
        DB::delete("delete from spots where name = 'test_vaccination'");
        DB::delete("delete from regional where province = 'test_vaccination'");
        DB::delete("delete from doctor where username = 'test_vaccination'");
    }
}
