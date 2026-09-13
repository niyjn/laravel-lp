<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('cliente', 'role')) {
            Schema::table('cliente', function (Blueprint $table) {
                $table->string('role', 20)->default('usuario');
            });
        }

        if (! Schema::hasColumn('cliente', 'remember_token')) {
            Schema::table('cliente', function (Blueprint $table) {
                $table->rememberToken();
            });
        }

        if (Schema::hasColumn('cliente', 'is_admin')) {
            DB::table('cliente')->where('is_admin', true)->update(['role' => 'admin']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            if (Schema::hasColumn('cliente', 'remember_token')) {
                $table->dropRememberToken();
            }
            if (Schema::hasColumn('cliente', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
