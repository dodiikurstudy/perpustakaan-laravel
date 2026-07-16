<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();


            // PEMILIK PEMBAYARAN
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');


            // PEMINJAMAN YANG MEMILIKI DENDA
            $table->foreignId('borrowing_id')
                ->constrained()
                ->onDelete('cascade');


            // NOMINAL YANG DIBAYAR
            $table->integer('jumlah');


            // BUKTI PEMBAYARAN
            $table->string('bukti')
                ->nullable();


            // STATUS PEMBAYARAN
            $table->enum('status', [

                'menunggu',
                'lunas',
                'ditolak'

            ])
            ->default('menunggu');


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};