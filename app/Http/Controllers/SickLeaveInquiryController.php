<?php

namespace App\Http\Controllers;

use App\Models\SickLeaveReport;
use Illuminate\Http\Request;

class SickLeaveInquiryController extends Controller
{
    public function show(Request $request)
    {
        $validated = $request->validate([
            'PatientId' => ['required', 'digits:10'],
            'NormalizedServiceCode' => ['required', 'string', 'max:50'],
        ]);

        $report = SickLeaveReport::query()
            ->where('national_id', $validated['PatientId'])
            ->where('service_code', $validated['NormalizedServiceCode'])
            ->first();

        if (!$report) {
            return response()->json(['ok' => true, 'data' => null]);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'service_code' => $report->service_code,
                'report_type' => $report->report_type,
                'admission_date' => optional($report->admission_date)->format('Y-m-d'),
                'discharge_date' => optional($report->discharge_date)->format('Y-m-d'),
                'leave_duration_days' => $report->leave_duration_days,
                'issue_date' => optional($report->issue_date)->format('Y-m-d'),
                'report_time' => $report->report_time,
                'national_id' => $report->national_id,
                'patient_name_ar' => $report->patient_name_ar,
                'patient_name_en' => $report->patient_name_en,
                'nationality' => $report->nationality,
                'employer' => $report->employer,
                'practitioner_name_ar' => $report->practitioner_name_ar,
                'practitioner_name_en' => $report->practitioner_name_en,
                'job_title_ar' => $report->job_title_ar,
                'job_title_en' => $report->job_title_en,
                'hospital_name_ar' => $report->hospital_name_ar,
                'hospital_name_en' => $report->hospital_name_en,
                'hospital_type' => $report->hospital_type,
                'hospital_logo_path' => $report->hospital_logo_path,
            ],
        ]);
    }
}
