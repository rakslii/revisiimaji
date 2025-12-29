<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // HANYA tambahkan kolom yang BELUM ADA di tabel users
        
        // Cek dan tambah 'address' jika belum ada
        if (!Schema::hasColumn('users', 'address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('address')->nullable()->after('phone');
            });
        }
        
        // Cek dan tambah 'city' jika belum ada
        if (!Schema::hasColumn('users', 'city')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('city')->nullable()->after('address');
            });
        }
        
        // Cek dan tambah 'province' jika belum ada
        if (!Schema::hasColumn('users', 'province')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('province')->nullable()->after('city');
            });
        }
        
        // Cek dan tambah 'postal_code' jika belum ada
        if (!Schema::hasColumn('users', 'postal_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('postal_code')->nullable()->after('province');
            });
        }
        
        // Juga tambahkan 'updated_at' jika belum ada (safety check)
        if (!Schema::hasColumn('users', 'updated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            });
        }
    }

    public function down()
    {
        // Hapus kolom yang kita tambahkan (jika perlu rollback)
        Schema::table('users', function (Blueprint $table) {
            $columns = ['address', 'city', 'province', 'postal_code'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};