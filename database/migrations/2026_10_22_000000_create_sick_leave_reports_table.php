<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sick_leave_reports', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 50)->unique();
            $table->string('report_type', 100);
            $table->date('admission_date');
            $table->date('discharge_date');
            $table->unsignedSmallInteger('leave_duration_days');
            $table->date('issue_date');
            $table->time('report_time')->nullable();
            $table->string('national_id', 10)->index();
            $table->string('patient_name_ar', 200);
            $table->string('patient_name_en', 200)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('employer', 200)->nullable();
            $table->string('practitioner_name_ar', 200)->nullable();
            $table->string('practitioner_name_en', 200)->nullable();
            $table->string('job_title_ar', 200)->nullable();
            $table->string('job_title_en', 200)->nullable();
            $table->string('hospital_name_ar', 200)->nullable();
            $table->string('hospital_name_en', 200)->nullable();
            $table->enum('hospital_type', ['government', 'private'])->nullable();
            $table->string('hospital_logo_path')->nullable();
            $table->timestamps();
            $table->unique(['national_id', 'service_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sick_leave_reports');
    }
};
