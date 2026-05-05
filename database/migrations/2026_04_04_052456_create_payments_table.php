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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
    $table->string('metode'); // VA / QRIS
    $table->string('status')->default('pending'); // pending / paid
    $table->string('snap_token')->nullable(); // dari Midtrans
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
