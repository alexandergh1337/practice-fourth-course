<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("applications", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("service_id")->constrained()->onDelete("cascade");
            $table->text("details")->nullable();
            $table->date("date")->nullable();
            $table->time("time")->nullable();
            $table->integer("guests")->default(1);
            $table->string("phone");
            $table->string("payment_method")->nullable();
            $table->string("status")->default("Новая");
            $table->text("cancel_reason")->nullable();
            $table->text("review")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("applications");
    }
};
