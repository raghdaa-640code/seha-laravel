<?php

use App\Http\Controllers\SickLeaveInquiryController;
use Illuminate\Support\Facades\Route;

Route::get('/seha/inquiries/sick-leave-details', [SickLeaveInquiryController::class, 'show']);
