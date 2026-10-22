CREATE DATABASE IF NOT EXISTS seha_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE seha_db;

CREATE TABLE sick_leave_reports (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  service_code VARCHAR(50) NOT NULL UNIQUE,
  report_type VARCHAR(100) NOT NULL,
  admission_date DATE NOT NULL,
  discharge_date DATE NOT NULL,
  leave_duration_days SMALLINT UNSIGNED NOT NULL,
  issue_date DATE NOT NULL,
  report_time TIME NULL,
  national_id VARCHAR(10) NOT NULL,
  patient_name_ar VARCHAR(200) NOT NULL,
  patient_name_en VARCHAR(200) NULL,
  nationality VARCHAR(100) NULL,
  employer VARCHAR(200) NULL,
  practitioner_name_ar VARCHAR(200) NULL,
  practitioner_name_en VARCHAR(200) NULL,
  job_title_ar VARCHAR(200) NULL,
  job_title_en VARCHAR(200) NULL,
  hospital_name_ar VARCHAR(200) NULL,
  hospital_name_en VARCHAR(200) NULL,
  hospital_type ENUM('government','private') NULL,
  hospital_logo_path VARCHAR(255) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  UNIQUE KEY sick_leave_national_service_unique (national_id, service_code),
  KEY sick_leave_national_id_index (national_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
