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
        Schema::create('medical', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("spot_id")->nullable(false);
            $table->unsignedBigInteger("doctor_id")->nullable(false);
            $table->enum("role",["doctor","officer"]);
            $table->string("name");
            $table->timestamps();

            $table->foreign("spot_id")->on("spots")->references("id");
            $table->foreign("doctor_id")->on("doctor")->references("id");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical');
    }
};
