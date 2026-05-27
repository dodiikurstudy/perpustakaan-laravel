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
        Schema::create('member_requests', function (Blueprint $table) {

            $table->id();

            // USER YANG MENGAJUKAN
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // STATUS PENGAJUAN
            $table->string('status')
                ->default('pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_requests');
    }
};