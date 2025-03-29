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
        Schema::create('error_logs', function (Blueprint $table) {
        $table->id();
        $table->string('method')->nullable();  // e.g., 'customer', 'admin', 'staff'
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('error_code')->nullable();
        $table->text('error_message');
        $table->text('stack_trace')->nullable();
        $table->json('additional_data')->nullable();  // For any extra error-related data
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable();
        $table->string('url')->nullable();
        $table->string('request_method')->nullable();  // GET, POST, etc.
        $table->boolean('is_resolved')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
