<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("services", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("price", 10, 2);
            $table->timestamps();
        });

        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("service_id")->constrained()->onDelete("cascade");
            $table->string("address");
            $table->dateTime("scheduled_at");
            $table->string("payment_method");
            $table->string("status")->default("Новая");
            $table->text("cancel_reason")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("bookings");
        Schema::dropIfExists("services");
    }
};
