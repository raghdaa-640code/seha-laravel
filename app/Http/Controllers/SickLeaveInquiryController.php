<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SickLeaveInquiryController extends Controller
{
    public function show(Request $request)
    {
        $validated = $request->validate([
            'PatientId' => ['required', 'digits:10'],
            'NormalizedServiceCode' => ['required', 'string', 'max:50'],
        ]);

        $baseUrl = rtrim(config('services.seha.url', ''), '/');
        $secret = config('services.seha.secret', '');

        if ($baseUrl === '' || $secret === '') {
            Log::error('Seha Worker configuration is missing.');

            return response()->json([
                'ok' => false,
                'message' => 'Service temporarily unavailable',
            ], 503);
        }

        try {
            $response = Http::acceptJson()
                ->withToken($secret)
                ->connectTimeout(5)
                ->timeout(15)
                ->get($baseUrl . '/api/inquiries/sick-leave-details', [
                    'PatientId' => $validated['PatientId'],
                    'NormalizedServiceCode' => $validated['NormalizedServiceCode'],
                ]);

            if (!$response->successful()) {
                Log::warning('Seha Worker inquiry failed.', [
                    'status' => $response->status(),
                ]);

                return response()->json([
                    'ok' => false,
                    'message' => 'Service temporarily unavailable',
                ], 503);
            }

            $result = $response->json();

            if (!is_array($result) || !array_key_exists('data', $result)) {
                Log::error('Invalid response from Seha Worker.');

                return response()->json([
                    'ok' => false,
                    'message' => 'Service temporarily unavailable',
                ], 502);
            }

            if ($result['data'] === null) {
                return response()->json([
                    'ok' => true,
                    'data' => null,
                ]);
            }

            $row = $result['data'];

            return response()->json([
                'ok' => true,
                'data' => [
                    'service_code' => $row['service_code'] ?? null,
                    'report_type' => $row['report_type'] ?? null,
                    'admission_date' => $row['admission_date'] ?? null,
                    'discharge_date' => $row['discharge_date'] ?? null,
                    'leave_duration_days' => isset($row['leave_duration_days'])
                        ? (int) $row['leave_duration_days']
                        : null,
                    'issue_date' => $row['issue_date'] ?? null,
                    'report_time' => $row['report_time'] ?? null,
                    'national_id' => $row['national_id'] ?? null,
                    'patient_name_ar' => $row['patient_name_ar'] ?? null,
                    'patient_name_en' => $row['patient_name_en'] ?? null,
                    'nationality' => $row['nationality'] ?? null,
                    'employer' => $row['employer'] ?? null,
                    'practitioner_name_ar' => $row['practitioner_name_ar'] ?? null,
                    'practitioner_name_en' => $row['practitioner_name_en'] ?? null,
                    'job_title_ar' => $row['job_title_ar'] ?? null,
                    'job_title_en' => $row['job_title_en'] ?? null,
                    'hospital_name_ar' => $row['hospital_name_ar'] ?? null,
                    'hospital_name_en' => $row['hospital_name_en'] ?? null,
                    'hospital_type' => $row['hospital_type'] ?? null,
                    'hospital_logo_path' => $row['logo_url'] ?? null,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Seha Worker connection failed.', [
                'exception' => get_class($e),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Service temporarily unavailable',
            ], 503);
        }
    }
}
