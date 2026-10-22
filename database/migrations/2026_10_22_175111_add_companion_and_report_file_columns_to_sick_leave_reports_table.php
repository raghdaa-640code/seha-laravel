
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sick_leave_reports', 'companion_name')) {
            Schema::table('sick_leave_reports', function (Blueprint $table) {
                $table->string('companion_name', 255)->nullable();
            });
        }

        if (!Schema::hasColumn('sick_leave_reports', 'relationship')) {
            Schema::table('sick_leave_reports', function (Blueprint $table) {
                $table->string('relationship', 100)->nullable();
            });
        }

        if (!Schema::hasColumn('sick_leave_reports', 'report_file_path')) {
            Schema::table('sick_leave_reports', function (Blueprint $table) {
                $table->string('report_file_path', 500)->nullable();
            });
        }
    }

    public function down(): void
    {
        // لا نحذف الأعمدة؛ لأنها كانت موجودة قبل هذه migration.
    }
};
