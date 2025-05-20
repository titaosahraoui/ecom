<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the column exists before trying to drop it
        if (Schema::hasColumn('galleries', 'image')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }
};
