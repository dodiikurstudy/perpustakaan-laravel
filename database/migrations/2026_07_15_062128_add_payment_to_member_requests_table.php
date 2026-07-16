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
        Schema::table('member_requests', function (Blueprint $table) {


            $table->integer('jumlah')
                ->default(0)
                ->after('status');


            $table->string('bukti_pembayaran')
                ->nullable()
                ->after('jumlah');


            $table->timestamp('tanggal_bayar')
                ->nullable()
                ->after('bukti_pembayaran');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_requests', function (Blueprint $table) {
            //
        });
    }
};
