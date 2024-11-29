<?php

use App\Proposal;
use Illuminate\Support\Facades\Route;

Route::get('test', function () 
{

    
    $proposals = Proposal::where('user_id', 4)
    ->where('status', 'active')
    ->where('quotation_id', 7)->with('vendor')->get()->toArray();

    dd($proposals[0]['vendor']['name']);


});

Route::get('clear', function () {
    // // app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    print "Cache has been cleared successfully!";
});

// CronJob Controller
Route::get('/cron', 'CronJobController@index')->name('cronjob');

Route::get('/', 'SiteController@index')->name('index');
Route::get('/contact-us', 'SiteController@contact_us')->name('contact_us');
Route::post('/contact', 'SiteController@contact')->name('contact');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// Shipment Controller
Route::post('/get_quote_step1', 'SiteController@get_quote_step1')->name('get_quote_step1');
Route::get('/get_quote_step2', 'SiteController@get_quote_step2')->name('get_quote_step2');
Route::post('/form_quote_step2', 'SiteController@form_quote_step2')->name('form_quote_step2');

// User Routes
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/profile', 'UserController@profile')->name('user.profile');
Route::post('/user/update_profile', 'UserController@update_profile')->name('user.update_profile');

// vendor Routes
Route::get('/ven', 'VendorController@index')->name('vendor');
Route::get('/ven/profile', 'VendorController@profile')->name('vendor.profile');
Route::post('/ven/update_profile', 'VendorController@update_profile')->name('vendor.update_profile');

// admin Routes
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/profile', 'AdminController@profile')->name('admin.profile');
Route::post('/admin/update_profile', 'AdminController@update_user_profile')->name('admin.update_profile');
Route::get('/view_user/{id}', 'AdminController@view_user')->name('admin.view_user');
Route::get('/all_users', 'AdminController@all_users')->name('admin.all_users');
Route::get('/all_vendors', 'AdminController@all_vendors')->name('admin.all_vendors');

// Quotation Routes
Route::resource('/quotation', 'QuotationController');
Route::get('/quotations', 'QuotationController@view_all')->name('quotations.view_all');
Route::post('/quotations', 'QuotationController@search')->name('quotations.search');
Route::get('/store_pending_form', 'QuotationController@store_pending_form')->name('store_pending_form');

Route::post('/quotations', 'QuotationController@search')->name('quotations.search');
Route::get('/mail_view_quotation/{token}', 'SiteController@mail_view_quotation')->name('quotation.mail_view');


// Proposal Routes
Route::resource('/proposal', 'ProposalController');
Route::get('/proposals', 'ProposalController@view_all')->name('proposals.view_all');
Route::get('/make_proposal/{id}', 'ProposalController@make_proposal')->name('proposal.make');
Route::get('proposals_received/', 'ProposalController@proposals_received')->name('proposals.received');
Route::get('/accept_proposal/{id}', 'ProposalController@accept_proposal')->name('proposal.accept');
Route::get('/mail_view_proposal/{token}', 'SiteController@mail_view_proposal')->name('proposal.mail_view');

// Merging translated file scripts
Route::get('merge_them', function () {

    $arabic="";
    foreach(file( url('public/trans/variables.json') ) as $line) 
    {
        $arabic=$arabic.$line.'+<br>';
    }
    foreach(file( url('public/trans/arabic_translation.json') ) as $line) 
    {
        $from = '/'.preg_quote('+', '/').'/';
        $arabic = preg_replace($from, $line, $arabic, 1);
        // print_r( $arabic);
        // return;
    }
    print_r( $arabic);
});