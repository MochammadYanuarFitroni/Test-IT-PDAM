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
        Schema::create('pegawais', function (Blueprint $table) {
            // $table->id('nip', 11);
            $table->integer('nip',11);
            $table->primary('nip');
            $table->string('nama', 200);
            $table->string('alamat', 200);
            $table->dateTime('tgl_lahir');
            $table->integer('id_ruangan');
            $table->timestamps();

            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
