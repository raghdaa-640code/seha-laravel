# مشروع صحة — Laravel + MySQL

## ملاحظات مهمة
- ملفات HTML/CSS/JS الأصلية من الأرشيف المرسل موجودة داخل المشروع؛ تم تغيير مسارات ربط CSS/JS لتعمل داخل Laravel، وتغيير `api.js` ليتصل بالـ API المحلي.
- التصميم لا يحتاج إلى إعادة كتابة. الصور الأصلية غير مضمنة لأنكِ ذكرتِ أنها موجودة عندكِ بنفس الأسماء. انسخيها إلى `public/views/assets/images/` مع الحفاظ على أسماء الملفات والمسارات الأصلية الموجودة في HTML/CSS.
- لا توجد صفحة لإضافة التقارير من الموقع. البوت هو الذي يكتب في قاعدة البيانات.
- هذه حزمة ملفات المشروع والتكامل، وليست نسخة Laravel مع مجلد `vendor`؛ شغّلي أوامر التثبيت أدناه بعد إنشاء مشروع Laravel أو دمج الملفات في مشروع Laravel موجود.

## تشغيل محليًا (Windows / XAMPP)
1. ثبتي PHP وComposer وMySQL/MariaDB.
2. أنشئي مشروع Laravel جديدًا: `composer create-project laravel/laravel seha`
3. انسخي مجلدات `app`, `routes`, `database`, `resources`, `public` من هذه الحزمة إلى مشروع Laravel الجديد، واسمحي بالدمج مع الاحتفاظ بالملفات الموجودة عند الحاجة.
4. في `.env` ضعي إعدادات قاعدة البيانات: `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3306` (أو منفذ MariaDB لديكِ), `DB_DATABASE=seha_db`, `DB_USERNAME=...`, `DB_PASSWORD=...`.
5. فعّلي API routes حسب إصدار Laravel. في Laravel 11/12/13 إذا لم يكن `routes/api.php` مفعّلًا، نفّذي `php artisan install:api` ثم احتفظي بالمسار الموجود في الحزمة.
6. شغّلي `php artisan migrate` لإنشاء الجدول. بديلًا عن ذلك، استوردي `database/seha_sick_leave_reports.sql` من phpMyAdmin. لا تستخدمي الطريقتين معًا على نفس الجدول.
7. شغّلي `php artisan serve` وافتحي `http://127.0.0.1:8000`.

## ربط البوت
أرسلي للمطوّر `docs/BOT_INTEGRATION_AR.md` وملف SQL. شاركيه أسماء الأعمدة فقط، وأرسلي بيانات الاتصال بطريقة آمنة خارج GitHub. يجب أن يكتب البوت في جدول `sick_leave_reports`.

## حقول قاعدة البيانات
`service_code`, `report_type`, `admission_date`, `discharge_date`, `leave_duration_days`, `issue_date`, `report_time`, `national_id`, `patient_name_ar`, `patient_name_en`, `nationality`, `employer`, `practitioner_name_ar`, `practitioner_name_en`, `job_title_ar`, `job_title_en`, `hospital_name_ar`, `hospital_name_en`, `hospital_type`, `hospital_logo_path`.

## النشر
ارفعي مشروع Laravel على استضافة تدعم PHP وComposer وMySQL، واضبطي document root على مجلد `public`. اضبطي متغيرات `.env` على بيانات قاعدة الإنتاج، ثم نفّذي `composer install --no-dev --optimize-autoloader`, `php artisan key:generate` (مرة واحدة فقط بعد ضبط `.env`), `php artisan migrate --force`, `php artisan config:cache`, `php artisan route:cache`. استخدمي HTTPS، ولا ترفعي `.env` أو بيانات القاعدة إلى GitHub. تأكدي أن بيئة البوت يمكنها الوصول إلى قاعدة البيانات بأمان.

## ملاحظات تقنية
- API endpoint: `GET /api/seha/inquiries/sick-leave-details?PatientId=...&NormalizedServiceCode=...`
- يعيد `data: null` عند عدم وجود سجل، أو سجلًا واحدًا عند التطابق.
- الواجهة الحالية تعرض الاسم العربي وتاريخ الإصدار والدخول والخروج والمدة واسم الممارس والمسمى الوظيفي، مثل عناصر التصميم الموجودة. بيانات بقية الحقول محفوظة في قاعدة البيانات ويمكن عرضها لاحقًا عند الحاجة.
- تحققي من توافق أسماء الصور داخل `public/views/assets/images/`؛ لم يتم تضمين الصور في الحزمة.
