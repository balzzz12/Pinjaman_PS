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
    Schema::create('sewas', function (Blueprint $table) {
        $table->id();

        // RELASI USER
        $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');

        // RELASI PLAYSTATION
        $table->foreignId('playstation_id')
            ->constrained('play_stations')
            ->onDelete('cascade');

        // DURASI SEWA
        $table->integer('durasi');

        // WAKTU MULAI
        $table->timestamp('waktu_mulai')->nullable();

        // TANGGAL SEWA
        $table->date('tanggal_mulai')->nullable();
        $table->date('tanggal_selesai')->nullable();

        // DOKUMEN JAMINAN
        $table->text('dokumen')->nullable();

        // AKSI
        $table->string('aksi')->nullable();

        // TOTAL HARGA
        $table->integer('total_harga')->nullable();

        // STATUS
        $table->string('status')->default('menunggu');

        // KODE BOOKING
        $table->string('booking_code', 50)->nullable()->unique();

        // =========================
        // 🔥 FITUR PENGEMBALIAN
        // =========================
        $table->enum('kondisi', ['baik', 'rusak'])->nullable();
        $table->text('catatan_kembali')->nullable();
        $table->string('foto_kembali')->nullable();
        $table->integer('denda')->default(0);

        // =========================
        // 🔔 NOTIF (ANTI SPAM)
        // =========================
        $table->boolean('notif_15_menit')->default(false);
        $table->boolean('notif_habis')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
