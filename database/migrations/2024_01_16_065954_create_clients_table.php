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
        Schema::create('clients', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('companyId');
            $table->string('name');
            $table->string('vatNumber')->unique();
            $table->string('email');
            $table->string('phone');
            $table->string('street');
            $table->string('number');
            $table->string('box')->nullable();
            $table->string('zipCode');
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
