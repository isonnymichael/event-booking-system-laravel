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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable(false);
            $table->unsignedBigInteger("event_id")->nullable(false);
            $table->timestamp("booked_at")->nullable(false)->useCurrent();

            $table->index("user_id");
            $table->index("event_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("event_id")->references("id")->on("event");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
