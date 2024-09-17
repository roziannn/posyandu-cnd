<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('pendaftarans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
      $table->string('nama_posyandu', 20);
      $table->string('nik', 16)->unique();
      $table->string('nama_balita', 50);
      $table->string('tempat_lahir', 50);
      $table->date('tanggal_lahir');
      $table->string('jenis_kelamin', 50);
      $table->float('bb_lahir', 5, 2);
      $table->string('nama_ortu', 50);
      $table->string('no_telepon', 13);
      $table->string('dukuh', 20);
      $table->string('rt', 2);
      $table->string('rw', 2);
      $table->string('pekerjaan', 50);

      $table->string('username', 10);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pendaftarans');
  }
};
