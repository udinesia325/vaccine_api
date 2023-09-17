<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("dose");
            $table->date("date");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("spot_id");
            $table->unsignedBigInteger("vaccine_id");
            $table->unsignedBigInteger("medical_id");

            $table->foreign("user_id")->on("user")->references("id");
            $table->foreign("spot_id")->on("spots")->references("id");
            $table->foreign("vaccine_id")->on("vaccines")->references("id");
            $table->foreign("medical_id")->on("medical")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
