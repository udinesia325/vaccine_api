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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string("id_card_number",8)->nullable("false");
            $table->string("password");
            $table->string("name");
            $table->date("born_date");
            $table->enum("gender",['male','female']);
            $table->text("address");
            $table->unsignedBigInteger("regional_id")->nullable(false);
            $table->string("token");
            $table->timestamps();
            $table->foreign("regional_id")->on("regional")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
