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
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });
        }

        // Backfill username dengan NIM/NIP (nomer_induk) untuk user yang ada
        $users = DB::table('users')->whereNull('username')->get(['id', 'nomer_induk']);
        foreach ($users as $u) {
            $base = trim((string) ($u->nomer_induk ?? ''));
            if ($base === '') {
                $base = 'user' . $u->id;
            }
            // normalisasi sederhana agar aman sebagai username
            $base = strtolower(preg_replace('/[^a-zA-Z0-9_.]/', '_', $base));
            $base = substr($base, 0, 30);
            if ($base === '') $base = 'user' . $u->id;
            $candidate = $base;
            $i = 1;
            while (DB::table('users')->where('username', $candidate)->where('id', '!=', $u->id)->exists()) {
                $suffix = '_' . $i;
                $candidate = substr($base, 0, max(1, 30 - strlen($suffix))) . $suffix;
                $i++;
            }
            DB::table('users')->where('id', $u->id)->update(['username' => $candidate]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            });
        }
    }
};
