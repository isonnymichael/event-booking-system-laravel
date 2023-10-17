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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255)->nullable(false);
            $table->text("description")->nullable(true);
            $table->date("date")->nullable(false);
            $table->time("time")->nullable(false);
            $table->string("location", 100)->nullable(false);
            $table->integer("slots_available")->nullable(false);
            $table->unsignedBigInteger("created_by_user_id")->nullable(false);
            $table->timestamps();

            $table->index("created_by_user_id");
            $table->foreign("created_by_user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
