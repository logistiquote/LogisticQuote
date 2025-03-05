<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\DHLExpressController;
use App\Http\Controllers\DHLShipmentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// CronJob Routes
Route::get('/cron', [CronJobController::class, 'index'])->name('cronjob');

// Public Routes
Route::get('/', [SiteController::class, 'index'])->name('index');
Route::get('/contact-us', [SiteController::class, 'contact_us'])->name('contact_us');
Route::post('/contact', [SiteController::class, 'contact'])->name('contact');

// Authentication Routes
Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Shipment Routes
Route::post('/get_quote_step1', [SiteController::class, 'getQuoteStepOne'])->name('get_quote_step1');
Route::get('/get_quote_step2', [SiteController::class, 'getQuoteStepTwo'])->name('get_quote_step2');
Route::post('/form-quote-final-step', [SiteController::class, 'formQuoteFinalStep'])->name('frontend.quote_final_step');

Route::post('/dhl/quote', [DHLExpressController::class, 'getQuote'])->name('dhl.quote');
Route::post('/dhl/quote-formation', [DHLExpressController::class, 'getQuoteFormation'])->name('dhl.quote-formation');
Route::get('/dhl/tracking/{tracking_number}', function($tracking_number) {
    return view('dhl.tracking', compact('tracking_number'));
})->name('dhl.tracking');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dhl/shipment', [DHLShipmentController::class, 'createShipment'])->name('dhl.shipment');

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);
    // Quotation Routes
    Route::resource('/quotation', QuotationController::class);
    Route::get('/quotation/summary-download/{quotation}', [QuotationController::class, 'downloadQuotationSummary'])->name('quotation.summary.download');
    Route::get('/quotations', [QuotationController::class, 'view_all'])->name('quotations.view_all');
    Route::post('/quotations', [QuotationController::class, 'search'])->name('quotations.search');
    Route::get('/store_pending_form', [QuotationController::class, 'storePendingForm'])->name('store_pending_form');
    Route::get('/mail_view_quotation/{token}', [SiteController::class, 'mail_view_quotation'])->name('quotation.mail_view');

    // User Routes
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.list')->middleware('role:admin');
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::post('/update_profile', [UserController::class, 'update_profile'])->name('user.update_profile');
    });

    // Admin Routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('/view_user/{id}', [AdminController::class, 'view_user'])->name('admin.view_user');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');

        // Location Routes
        Route::resource('/location', LocationController::class);
        Route::get('/location-import', [LocationController::class, 'importLocationsView'])->name('location.import.view');
        Route::post('/location/import', [ImportController::class, 'importLocations'])->name('location.import');

        // Route Management
        Route::resource('/route', RouteController::class);

        // Export Routes
        Route::prefix('export')->group(function () {
            Route::get('/users', [ExportController::class, 'exportUsers'])->name('export.users');
        });
    });

    // Payment Routes
    Route::prefix('payment')->group(function () {
        Route::post('/create', [PaymentController::class, 'createPayment'])->name('payment.create');
        Route::get('/success', [PaymentController::class, 'executePayment'])->name('payment.success');
        Route::get('/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
    });
});

// Merging Files
Route::get('/merge_them', [SiteController::class, 'merge_them'])->name('merge_them');
