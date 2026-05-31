<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login ');
});

Route::get('/test-sms/{no}','AccesscodeController@sendSms');

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);





Route::get('/419', function () {
    return redirect('/');
});

Route::get('/verify', function () {

    $phone = Session::get('phone');
    if($phone != null)

    return view('verify');
    else
    return redirect('register_customer/create');
});

Route::get('/mainregister', function () {

    $user_id = Session::get('user_id');
    if($user_id != null)

    return view('mainregister');
    else
    return redirect('register_customer/create');
});

Route::get('/register', function () {


    if(Auth::user())

    return redirect('/home');
    else
    return redirect('/register');
});


Route::get('/test-sms/{phone}/{message}', 'SearchController@TestSms');





Auth::routes();

Route::Resource('/register_customer', 'CustomerSideRegisterController');

Route::Resource('/findproperty', 'ProductSearchController');



Route::group(['middleware' => 'App\Http\Middleware\StaffMiddleware'], function()
{
    Route::Resource('/customerreg', 'CustomerRegistrationController');
Route::Resource('/customer', 'CustomerController');

    Route::post('/profile_step1', 'StaffRegistrationController@profile_step1')->name('profile_step1');
    Route::post('/profile_step2', 'StaffRegistrationController@profile_step2')->name('profile_step2');
    Route::post('/profile_step3', 'StaffRegistrationController@profile_step3')->name('profile_step3');
    Route::post('/profile_step4', 'StaffRegistrationController@profile_step4')->name('profile_step4');


Route::get('/home', 'HomeController@index')->name('home');
Route::Resource('/package', 'PlotTypeController');
Route::Resource('/plot', 'PlotController');
Route::post('/saleproperty', 'PlotController@saleProperty')->name('saleproperty.store');
Route::post('/get_customer', 'PlotController@get_customer')->name('get_customer');
Route::post('/get_dro', 'PlotController@get_dro')->name('get_dro');
Route::Resource('/product', 'ProductController');
Route::Resource('/staffreg', 'StaffRegistrationController');
Route::Resource('/branch', 'BranchController');

Route::Resource('/staffprofile', 'StaffProfileController');
Route::Resource('/staff', 'StaffController');
Route::Resource('/pendingstaffreg', 'PendingStaffRegistrationController');
Route::Resource('/deposittxn', 'AdminDepositController');
Route::get('/arriers', 'AdminDepositController@arriers')->name('arriers');
Route::get('/topup', 'AdminDepositController@topup')->name('topup');
Route::get('/withdrawals', 'AdminTransactionController@withdrawal')->name('withdrawal');
Route::get('/investments', 'AdminTransactionController@investment')->name('investment');

Route::get('/liquidation-request', 'AdminTransactionController@liquidationRequest')->name('liquidation_request');

Route::patch('/liquidation-request/{id}', 'AdminTransactionController@approveLiquidationRequest')->name('liquidation_request.approve');


Route::get('/general-settings', 'GeneralSettingController@index')->name('general_settings');

Route::post('/general-settings', 'GeneralSettingController@store')->name('general_settings.store');
Route::patch('/approve-withdrawal/{id}', 'AdminTransactionController@approveWithdrawal')->name('withdrawal.approve');
Route::patch('/decline-withdrawal/{id}', 'AdminTransactionController@declineWithdrawal')->name('withdrawal.decline');
Route::get('/arriers/{id}', 'AdminDepositController@arriers_show')->name('arriers.show');
Route::get('/ajax_arrier', 'AdminDepositController@ajax_arriers')->name('ajax_arriers');
Route::Resource('/sales', 'StaffPropertyController');
Route::get('/depositrecord/{id}', 'StaffPropertyController@deposit_history')->name('depositrecord');

Route::get('/installmentsales', 'StaffPropertyController@install_index')->name('installmentsales');

Route::get('/installmentsales/{id}', 'StaffPropertyController@install_show')->name('installmentsales.show');
Route::get('/installmentsales/{id}/edit', 'StaffPropertyController@install_edit')->name('installmentsales.edit');
Route::put('/installmentsales/{id}', 'StaffPropertyController@install_update')->name('installmentsales.update');

Route::get('/pmcustomerproduct/{id}', 'PMController@product')->name('pmcustomerproduct.product');
Route::get('/pmcustomerproductdetails/{id}', 'PMController@productdetails')->name('pmcustomerproduct.productdetails');

Route::get('/droportal', 'BDMController@dro')->name('droportal');

Route::get('/bdmdroprofile/{id}', 'BDMController@dro_show')->name('bdmdroprofile.show');

Route::get('/bdmdrocustomer/{id}', 'BDMController@dro_customer')->name('bdmdrocustomer.show');
Route::get('/bdmdrohbdm/{id}', 'BDMController@dro_hbdm')->name('bdmdrohbdm.show');
Route::get('/bdmdrocustomerproduct/{id}', 'BDMController@dro_customer_product')->name('bdmdrocustomerproduct.show');

Route::get('/bdmsales/', 'BDMController@bdmsales')->name('bdmdsales');

Route::get('/bdmcustomers', 'BDMController@bdmcustomers')->name('bdmcustomers');

Route::get('/bdmcustomers/{id}', 'BDMController@bdmcustomers_show')->name('bdmcustomers.show');

//hbdm
Route::get('/hbdmbdolist', 'HBDMController@bdo')->name('hbdmbdolist');
Route::get('/hbdmbdolist/{id}', 'HBDMController@show_bdo')->name('hbdmbdolist.show');

Route::get('/hbdmbdmlist', 'HBDMController@bdm')->name('hbdmbdmlist');
Route::get('/hbdmbdmlist/{id}', 'HBDMController@show_bdm')->name('hbdmbdmlist.show');

Route::get('/hbdmcustomerslist', 'HBDMController@search_by_state')->name('hbdmcustomerslist');
Route::post('/hbdmcustomerslist', 'HBDMController@customers_by_state')->name('hbdmcustomerslist.store');
Route::get('/hbdmcustomerslist/{id}', 'HBDMController@show_customer_profile')->name('hbdmcustomerslist.show');

Route::get('/hbdmsales', 'HBDMController@show_sales')->name('hbdmsales');
Route::post('/hbdmsales/store', 'HBDMController@show_sales_by_state')->name('hbdmsales.store');
Route::get('/hbdmsales/{id}', 'HBDMController@show_sales_details')->name('hbdmsales.show');

Route::get('/transaction', 'HBDMController@transaction_all')->name('transaction');
Route::get('/transaction/create', 'HBDMController@transaction_create')->name('transaction.create');
Route::post('/transaction/store', 'HBDMController@transaction')->name('transaction.store');
Route::get('/transaction/{id}', 'HBDMController@show_transaction')->name('transaction.show');
Route::get('/defaulters/create', 'HBDMController@defaulters_create')->name('defaulters.create');
Route::get('/defaulters', 'HBDMController@defaulters_all')->name('defaulters');
Route::post('/defaulters/store', 'HBDMController@defaulters')->name('defaulters.store');

Route::get('/customerpayment/{id}', 'TransactionController@customerpayment')->name('customerpayment.show');
Route::post('/customerrevoke/store', 'TransactionController@revoke')->name('customerrevoke.store');
Route::get('/customerrevoke/show', 'TransactionController@revokeuser_index')->name('customerrevoke.show');
//search route
Route::post('/get_customer_search/', 'SearchController@customer')->name('get_customer_search');
Route::post('/get_customer_search/store', 'SearchController@customer')->name('get_customer_search.store');

Route::post('/get_staff_search/store', 'SearchController@staff')->name('get_staff_search.store');
Route::post('/get_stock_search/store', 'SearchController@stock')->name('get_stock_search.store');
Route::post('/get_plot_search/store', 'SearchController@plot')->name('get_plot_search.store');
Route::post('/get_ui_search/store', 'SearchController@ui')->name('get_ui_search.store');
Route::post('/get_sold_search/store', 'SearchController@sold')->name('get_sold_search.store');
Route::post('/get_deposit_search/store', 'SearchController@deposit')->name('get_sold_deposit.store');

Route::post('/postpayment/store', 'TransactionController@postpayment')->name('postpayment.store');
Route::get('/export_und/{type}', 'TransactionController@export');
Route::get('/export_sold/{type}', 'TransactionController@exportSold');

Route::get('/staff-birthday', 'EventController@staffBirthday');
Route::get('/customer-birthday', 'EventController@customerBirthday');
Route::post('/customer-birthday', 'EventController@saveCustomerBirthday');
Route::post('/staff-birthday', 'EventController@saveStaffBirthday');
Route::get('/holiday-wishes', 'EventController@wishes');
Route::get('/edit-wish/{id}', 'EventController@editWish');
Route::get('/create-wish', 'EventController@createWish');
Route::post('/store-wish', 'EventController@storeWish');
Route::put('/update-wish/{id}', 'EventController@updateWish');
Route::delete('/delete-wish/{id}', 'EventController@deleteWish');
Route::get('/customer-followup/{id}', 'OutboxController@index');
Route::post('/create-email-followup', 'OutboxController@createEmail');
Route::post('/create-sms-followup', 'OutboxController@createSms');
Route::put('/send-followup/{id}', 'OutboxController@Send');
Route::delete('/delete-followup/{id}', 'OutboxController@destroy');


Route::get('/manage-appointments', 'AdminAppointmentController@index');
Route::PATCH('/approve-appointment/{app_id}', 'AdminAppointmentController@approve')->name('appointment.approve');
Route::PATCH('/decline-appointment/{app_id}', 'AdminAppointmentController@decline')->name('appointment.decline');
Route::PATCH('/reschedule-appointment/{app_id}', 'AdminAppointmentController@reschedule')->name('appointment.reschedule');



Route::get('/manage-ads', 'AdsController@index');
Route::get('/create-ad', 'AdsController@create');
Route::get('/edit-ad/{ad_id}', 'AdsController@edit');
Route::post('/store-ad', 'AdsController@store')->name('ads.store');
Route::PATCH('/update-ad/{ad_id}', 'AdsController@update')->name('ads.update');
Route::delete('/delete-ad/{ad_id}', 'AdsController@destroy')->name('ads.destroy');

Route::get('/search-performance', 'StaffPerformance@index');
Route::get('/sales-performance-result', 'StaffPerformance@salesReport');

Route::post('/search-performance', 'StaffPerformance@search')->name('staff_performance.search');

});


Route::post('/registerstaff', 'FrontController@registerstaff')->name('registerstaff');
Route::get('/success', 'FrontController@success_page')->name('success_page');



//customer area

Route::Resource('/pay', 'DepositController');


Route::Resource('/shelterproduct', 'CustomerPropertyController');

Route::get('/droprofile/{id}', 'CustomerPropertyController@droprofile')->name('droprofile');

Route::Resource('/dashboard', 'CustomerDashbard');

Route::Resource('/customerprofile', 'CustomerProfileController');


Route::get('/editpersonalinfo', 'CustomerProfileController@editpersonalinfo')->name('editpersonalinfo');


Route::get('/editnextkininfo', 'CustomerProfileController@editnextkininfo')->name('editnextkininfo');



Route::get('/editcontactinfo', 'CustomerProfileController@editcontactinfo')->name('editcontactinfo');

Route::get('/payment/callback', 'DepositController@handleGatewayCallback');
Route::post('/payment/webhook', 'DepositController@handleGatewayWebhook');
Route::get('/record/{id}', 'DepositController@record')->name('record.show');

Route::get('/otpview','OtpController@index');
Route::get('/staffaccesscode','AccesscodeController@index');


Route::post('/top-up', 'WalletController@topup')->name('topup');
Route::post('/withdraw', 'WalletController@withdraw')->name('withdraw');
Route::get('/appointments', 'AppointmentController@index');
Route::post('/schedule-appointment', 'AppointmentController@schedule')->name('schedule_appointment');
Route::PATCH('/user-approve-appointment/{app_id}', 'AppointmentController@approve')->name('user.appointment.approve');
Route::PATCH('/user-decline-appointment/{app_id}', 'AppointmentController@decline')->name('user.appointment.decline');

Route::get('/transaction-history', 'WalletController@transaction')->name('transaction_history');

Route::get('/investment-history', 'WalletController@investment')->name('investment_history');

Route::post('/create-investment', 'WalletController@invest')->name('create_investment');


Route::patch('/liquidate-investment/{id}', 'WalletController@liquidate')->name('liquidate_investment');

Route::get('/internal-transfer', 'CustomerDashbard@internalTransfer')->name('internal_transfer');


Route::post('/initiate-transfer', 'CustomerDashbard@initiateTransfer')->name('initiate_transfer');

Route::post('/transfer', 'CustomerDashbard@Transfer')->name('transfer');


