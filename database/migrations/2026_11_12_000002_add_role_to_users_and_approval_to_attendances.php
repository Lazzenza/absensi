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
        // 1. Tambah kolom role di tabel users jika belum ada
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });
        }

        // 2. Tambah kolom approval_status, approved_by, approval_note di attendances
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'approval_status')) {
                $table->string('approval_status')->default('approved')->after('status');
            }
            if (!Schema::hasColumn('attendances', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approval_status');
            }
            if (!Schema::hasColumn('attendances', 'approval_note')) {
                $table->text('approval_note')->nullable()->after('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'approval_note')) {
                $table->dropColumn('approval_note');
            }
            if (Schema::hasColumn('attendances', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }
            if (Schema::hasColumn('attendances', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
