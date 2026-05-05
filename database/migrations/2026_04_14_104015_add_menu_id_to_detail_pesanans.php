<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable()->after('barang_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');
        });
    }
};