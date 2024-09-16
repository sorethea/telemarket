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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('type');
            $table->string('bot');
            $table->string('status')->nullable();
            $table->string('file')->nullable();
            $table->string('file_type')->nullable();
            $table->text('text')->nullable();
            $table->text('form')->nullable();
            $table->text('chat')->nullable();
            $table->text('location')->nullable();
            $table->text('contact')->nullable();
            $table->text('document')->nullable();
            $table->text('voice')->nullable();
            $table->text('video')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
