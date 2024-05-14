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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('sender_address')->nullable(false);
            $table->string('recipient_address')->nullable(false);
            $table->string('subject')->nullable(false);
            $table->longText('body')->nullable();
            $table->longText('body_plain')->nullable();
            $table->string('eml_location')->nullable(false);
            $table->json('attachments')->default(null)->nullable();
            $table->json('tags')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
