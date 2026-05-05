<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            // ✅ tambah field alamat lengkap
            $table->string('provinsi')->nullable()->after('alamat');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');

            // ✅ pastikan foto_blob = longText (base64)
            $table->longText('foto_blob')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            // rollback field
            $table->dropColumn(['provinsi', 'kota', 'kecamatan', 'kelurahan']);

            // balik ke semula (optional)
            $table->longText('foto_blob')->nullable()->change();
        });
    }
};