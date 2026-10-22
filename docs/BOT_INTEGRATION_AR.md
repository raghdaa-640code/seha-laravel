# ربط بوت Telegram بقاعدة البيانات

## الفكرة
الموقع لا يضيف تقارير من الواجهة. البوت هو الذي يضيف/يحدّث السجلات في جدول `sick_leave_reports`، والموقع يقرأ السجل باستخدام `service_code` و`national_id`. يجب أن يستخدم البوت نفس قاعدة البيانات ونفس أسماء الأعمدة.

## الحقول المطلوبة
- `service_code`: رمز الخدمة الفريد الظاهر للمستخدم.
- `report_type`: نوع التقرير.
- `admission_date`, `discharge_date`: تاريخا الدخول والخروج بصيغة `YYYY-MM-DD`.
- `leave_duration_days`: مدة الإجازة بالأيام.
- `issue_date`: تاريخ إصدار التقرير.
- `report_time`: الوقت بصيغة `HH:MM:SS` أو NULL.
- `national_id`: رقم الهوية من 10 أرقام كنص، للحفاظ على أي أصفار في البداية.
- `patient_name_ar`, `patient_name_en`, `nationality`, `employer`.
- `practitioner_name_ar`, `practitioner_name_en`, `job_title_ar`, `job_title_en`.
- `hospital_name_ar`, `hospital_name_en`, `hospital_type` (`government` أو `private`), `hospital_logo_path`.

## مثال SQL للإضافة أو التحديث
```sql
INSERT INTO sick_leave_reports
(service_code, report_type, admission_date, discharge_date, leave_duration_days, issue_date, report_time, national_id, patient_name_ar, patient_name_en, nationality, employer, practitioner_name_ar, practitioner_name_en, job_title_ar, job_title_en, hospital_name_ar, hospital_name_en, hospital_type, hospital_logo_path, created_at, updated_at)
VALUES
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
ON DUPLICATE KEY UPDATE
report_type=VALUES(report_type), admission_date=VALUES(admission_date), discharge_date=VALUES(discharge_date), leave_duration_days=VALUES(leave_duration_days), issue_date=VALUES(issue_date), report_time=VALUES(report_time), patient_name_ar=VALUES(patient_name_ar), patient_name_en=VALUES(patient_name_en), nationality=VALUES(nationality), employer=VALUES(employer), practitioner_name_ar=VALUES(practitioner_name_ar), practitioner_name_en=VALUES(practitioner_name_en), job_title_ar=VALUES(job_title_ar), job_title_en=VALUES(job_title_en), hospital_name_ar=VALUES(hospital_name_ar), hospital_name_en=VALUES(hospital_name_en), hospital_type=VALUES(hospital_type), hospital_logo_path=VALUES(hospital_logo_path), updated_at=NOW();
```
Use parameterized queries/prepared statements, not string concatenation. Store national IDs as strings, not integers. Keep database credentials in environment variables, never in the bot source or GitHub.

## Logo
Store the logo file in shared storage or the website's public storage and save only its relative path in `hospital_logo_path`; do not store the image bytes in the SQL column.

## Important
The report code must be unique. The bot and website should point to the same MySQL/MariaDB database and host. Do not expose database port publicly; allow access from the hosting network or use a private network.
