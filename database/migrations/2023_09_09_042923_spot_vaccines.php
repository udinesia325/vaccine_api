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
        Schema::create('spot_vaccines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("spot_id");
            $table->unsignedBigInteger("vaccine_id");
            $table->timestamps();

            $table->foreign("spot_id")->on("spots")->references("id");
            $table->foreign("vaccine_id")->on("vaccines")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_vaccines');
    }
};
