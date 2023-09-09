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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable(false); 
            $table->unsignedBigInteger("doctor_id")->nullable(false); 
            $table->enum("status",["pending","accepted","declined"]);
            $table->text("disease_history");
            $table->text("current_symptoms");

            $table->foreign("user_id")->on("user")->references("id");
            $table->foreign("doctor_id")->on("doctor")->references("id");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
