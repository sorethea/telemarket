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
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('channel');
            $table->string('bot');
            $table->foreignId('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('is_subscribed')->default(false);
            $table->boolean('is_forward')->default(false);
            $table->timestamps();
            $table->primary(['id','bot']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
