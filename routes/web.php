<?php

use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

// CronJob Controller
Route::get('/cron', 'CronJobController@index')->name('cronjob');

Route::get('/', 'SiteController@index')->name('index');
Route::get('/contact-us', 'SiteController@contact_us')->name('contact_us');
Route::post('/contact', 'SiteController@contact')->name('contact');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// Shipment Controller
Route::post('/get_quote_step1', 'SiteController@getQuoteStepOne')->name('get_quote_step1');
Route::get('/get_quote_step2', 'SiteController@getQuoteStepTwo')->name('get_quote_step2');
Route::post('/form-quote-final-step', 'SiteController@formQuoteFinalStep')->name('frontend.quote_final_step');

// User Routes
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/profile', 'UserController@profile')->name('user.profile');
Route::post('/user/update_profile', 'UserController@update_profile')->name('user.update_profile');

// admin Routes
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/profile', 'AdminController@profile')->name('admin.profile');
Route::post('/admin/update_profile', 'AdminController@update_user_profile')->name('admin.update_profile');
Route::get('/view_user/{id}', 'AdminController@view_user')->name('admin.view_user');
Route::get('/all_users', 'AdminController@all_users')->name('admin.all_users');

// Quotation Routes
Route::resource('/quotation', 'QuotationController');
Route::get('/quotation/summary-download/{quotation}', [QuotationController::class, 'downloadQuotationSummary'])->name('quotation.summary.download');
Route::get('/quotations', 'QuotationController@view_all')->name('quotations.view_all');
Route::post('/quotations', 'QuotationController@search')->name('quotations.search');
Route::get('/store_pending_form', 'QuotationController@storePendingForm')->name('store_pending_form');
Route::post('/quotations', 'QuotationController@search')->name('quotations.search');
Route::get('/mail_view_quotation/{token}', 'SiteController@mail_view_quotation')->name('quotation.mail_view');

// Routes
Route::resource('/location', 'LocationController');
Route::get('/location-import', 'LocationController@importLocationsView')->name('location.import.view');
Route::post('/location/import', 'ImportController@importLocations')->name('location.import');
Route::resource('/route', 'RouteController');

// Payment
use App\Http\Controllers\PaymentController;

Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment/success', [PaymentController::class, 'executePayment'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');


// Merging translated file scripts
Route::get('merge_them', function () {


});
Route::get('/merge_them', 'SiteController@merge_them')->name('merge_them');

