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
        Schema::create('send_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('type');
            $table->string('from');
            $table->text('to');
            $table->string('status')->nullable();
            $table->integer('message_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_messages');
    }
};
