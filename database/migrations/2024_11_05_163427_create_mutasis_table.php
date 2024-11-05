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
    Schema::create('mutasis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');
      $table->string('fromPosyandu');
      $table->string('toPosyandu');
      $table->string('username', 255);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('mutasis');
  }
};
