<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_success(): void
    {
        $this->post("/api/v1/auth/login", [
            "id_card_number" => "1",
            "password" => "test"
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id_card_number",
                "password",
                "name",
                "born_date",
                "gender",
                "address",
                "regional_id",
                "token",
                "regional" => [
                    "id",
                    "province",
                    "district"
                ]
            ]);
    }
    public function test_login_failed()
    {
        $this->post("/api/v1/auth/login", [
            "id_card_number" => "1",
            "password" => "wrong"
        ])
            ->assertStatus(401)
            ->assertJson([
                "message" => "ID Card Number or Password incorrect"
            ]);
    }
    function test_failed_login_validation()
    {
        $this->post("/api/v1/auth/login", [
            "id_card_number" => "1",
            "password" => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates cupiditate placeat officia eaque rem enim expedita, dolores rerum corporis numquam quidem. Commodi explicabo adipisci ipsam molestias hic, necessitatibus odio ratione accusamus inventore dicta libero, reprehenderit eos delectus quibusdam blanditiis repudiandae voluptate reiciendis similique quasi cupiditate sint perferendis assumenda atque laborum. Ipsum facere omnis quibusdam eveniet illum numquam. Animi, labore veniam odio doloribus itaque iste nemo aliquid, repellendus sunt reprehenderit libero aperiam! Dolore eaque, aspernatur exercitationem minus eum deserunt quae facilis odio ad nostrum repellat architecto sint neque inventore at officia esse voluptatem illo veniam cumque? Sint maxime dolores fuga eveniet.
            "
        ])
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "password" => ["The password field must not be greater than 100 characters."]
                ]
            ]);
    }
    function test_logout()
    {
        $this->post("/api/v1/auth/logout", headers: [
            "token" => md5(1)
        ])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Logout success"
            ]);
        // token should deleted
        $loggedOut = User::where("name","test")->first();
        self::assertEquals($loggedOut->token,null);
        $loggedOut->token = md5(1);
        $loggedOut->save();
    }
}
