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
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'location_id')) {
            $table->foreignId('location_id')->nullable()->after('user_id')->constrained('locations');
        }
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['location_id']);
        $table->dropColumn('location_id');
    });
}
};
