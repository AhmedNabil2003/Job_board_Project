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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('status')->default('pending'); // أو قم بتحديد النوع المناسب حسب احتياجاتك
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('notifications', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
