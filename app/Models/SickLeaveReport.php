<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SickLeaveReport extends Model
{
    protected $fillable = [
        'service_code', 'report_type', 'admission_date', 'discharge_date',
        'leave_duration_days', 'issue_date', 'report_time', 'national_id',
        'patient_name_ar', 'patient_name_en', 'nationality', 'employer',
        'practitioner_name_ar', 'practitioner_name_en', 'job_title_ar',
        'job_title_en', 'hospital_name_ar', 'hospital_name_en',
        'hospital_type', 'hospital_logo_path'
    ];

    protected $casts = [
        'admission_date' => 'date:Y-m-d',
        'discharge_date' => 'date:Y-m-d',
        'issue_date' => 'date:Y-m-d',
        'report_time' => 'datetime:H:i:s',
        'leave_duration_days' => 'integer',
    ];
}
