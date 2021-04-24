<?php


Route::get('/', 'HomeController@bodyFront');
Route::get('contact', 'HomeController@contact');
Route::get('reserve/appointment', 'HomeController@home');
Route::get('check-range-product/{name}', 'ShopController@rangerProduct');

Route::get('busket', 'CartController@index');
Route::get('checkout', 'CartController@checkout');
Route::get('checkout/{id}', 'CartController@checkoutAuth');
Route::post('checkout/complete', 'CartController@checkoutComplete');
Route::post('checkout/complete2', 'CartController@checkoutCompleteAuth');
Route::get('check-vat-acc-Country', 'CartController@checkVatAccordingCountry');
Route::get('app-cart-delete/{id}/{date}', 'CartController@deleteAppCart');

Route::get('order-success', 'CartController@orderSuccess');
Route::get('create-account', 'LoginController@createAccount');
Route::post('create-account', 'LoginController@saveAccount');

Route::get('shop/category', 'ShopController@index');
Route::get('add-to-shop', 'ShopController@addCart');
Route::get('update-cart', 'ShopController@updateCart');

Route::get('option-product/{id}/select', 'ShopController@checkOptionProduct');
Route::get('cart-delete/{id}/item', 'ShopController@deleteCart')->where('id', '[0-9]+');

Route::get('shop/category/{id}/products', 'ShopController@products');
Route::get('shop/product/{id}/{name}/overview', 'ShopController@overview');
Route::get('appointment-types/{id}/select', 'HomeController@selectType');
Route::get('appointment-types', 'HomeController@appointmentTypes');

Route::get('appointments-available-check', 'HomeController@appointmentsAvailable');
Route::get('select-user/{id}/select', 'HomeController@selectUser');
Route::get('appointments-create', 'CartController@appointmentCart');
Route::get('payment/paymentcheck/{id}','molliePaymentController@paymentCheck');
Route::post('payment/apicall/','molliePaymentController@webHookMollie');

Route::middleware(['user_auth'])->group(function () {
  Route::get('payment/apicall/{id}','molliePaymentController@apiCallMollie');
Route::post('payment/cancel/id','molliePaymentController@cancelOrder');

Route::get('my-account', 'ClientController@myAccount');
Route::get('my-account/requst-funds', 'ClientController@requestFund');
Route::get('my-account/edit', 'ClientController@editMyInfo');
Route::get('my-account/change-password', 'ClientController@passwordChange');
Route::post('my-account/change-password', 'ClientController@savepasswordChange');
Route::post('edit-my-account', 'ClientController@editMyAccount');
Route::get('my-account/my-appointments', 'ClientController@myAppointments');
Route::get('my-account/list-history', 'ClientController@history');
Route::get('my-account/unpaid-appointment', 'ClientController@unPaidAppointment');
Route::get('my-account/my-invoice', 'ClientController@myInvoice');
Route::get('my-account/my-orders', 'ClientController@myOrder');
Route::get('my-account/my-orders/{id}/details', 'ClientController@orderDetails');
Route::get('my-account/appointments/{id}/details', 'ClientController@appDetails');
Route::post('update_appointment', 'FrontAppointmentController@updateAppointment');
Route::get('my-account/appointments/{id}/edit', 'ClientController@loadAppointment');
Route::get('my-account/appointments/{id}/delete', 'molliePaymentController@cancelOrder');

Route::get('request-refund', 'ClientController@requestreFund');
Route::get('order/payment/{id}', 'ClientController@orderPayment');
Route::get('unpaidAppointment/payment/{id}', 'ClientController@unpaidAppointmentPayment');

Route::get('invoices/{id}/download', 'PDFController@invoicesDownload');
});

Route::get('logout', 'LoginController@logout');

Route::middleware(['auth'])->group(function () {
Route::middleware(['admin'])->group(function () {
Route::get('dashboard', 'HomeController@index');


// mollie payment

// webhook for mollie

Route::get('appointments-check-calender','AppointmentController@checkSelectAppointment');
// Route::resource('appointments','AppointmentController');
Route::get('appointments','AppointmentController@index');
Route::get('appointments/create/new','AppointmentController@create');
Route::post('appointments','AppointmentController@store');
Route::get('appointments/{id}','AppointmentController@update');
Route::get('appointments/{id}/details','AppointmentController@details')->where('id', '[0-9]+');
Route::get('appointments-times-check','AppointmentController@checkAppointment');
Route::get('product-check/{id}/select','AppointmentController@productCheckForAddCart');
Route::get('appointments/makeInvoice/new','AppointmentController@makeInvoice');
Route::get('appointments/{id}/edit','AppointmentController@edit');
Route::get('appointments/{id}/cencel','AppointmentController@appCencelNew');
Route::post('appointments/cancel','AppointmentController@appCancel');
Route::get('appointments-type-acc/{id}/find/{name}','HomeController@appFind');

Route::get('appointment-Select-Month/{name}','HomeController@monthlyBooking');
Route::get('appointments-personal','AppointmentController@personalAppointment');
Route::get('appointment-cancel-personal/{id}','AppointmentController@personalAppointmentRemove');
Route::get('appointment/makeOrder','AppointmentController@makeOrder');
Route::post('appointments/conframOrder','AppointmentController@conframOrderandAppointment');
Route::post('appointments/Orderupdate','AppointmentController@Orderupdated');

Route::post('orders/Orderupdate','AppointmentController@OrderUpdatedNew');
Route::resource('appointment/types', 'AppointmentTypeController');
Route::get('appointment/types/{id}/delete','AppointmentTypeController@destory');
Route::get('appointment/{id}/select','AppointmentController@personalAppointmentSelect');
Route::get('edit.personalAppointment','AppointmentController@editPersonalAppointment');

// Route::get('appointment/types/create','AppointmentTypeController@create');

Route::resource('orders', 'OrderController');
Route::get('orders/{id}/details','OrderController@details');
Route::post('orders/OrderupdateMoreApp','OrderController@OrderupdateMoreApp');
Route::post('invoices/conframinvoice','OrderController@updateInvoice');
Route::post('appointments/conframinvoice','OrderController@conframinvoice');
Route::get('invoices/{id}/details','OrderController@invoicesDetails');
Route::get('orders/makeCreditnote/new','OrderController@createCreditNote');
Route::get('invoices','OrderController@invoiceList');
Route::get('creditList','OrderController@creditList');
Route::get('credit-note-details/{id}','OrderController@creditNoteDetails');
// =============================start-Product=========================
Route::resource('products', 'ProductController');
Route::get('products/images/{id}/delete', 'ProductController@imagesDelete');
Route::get('products/{id}/delete', 'ProductController@destory');
Route::get('searchajax', 'ProductController@searchajaxproduct');
// =============================end-Product=========================

//=====================strat-clients==============================
Route::resource('clients', 'ClientController');
Route::get('clients/details/{id}','ClientController@details');
Route::get('client/import/','ClientController@import');
Route::post('client/import/','ClientController@handleImport')->name('bulk-import-user');
Route::get('clients/{id}/delete','ClientController@destory');
Route::get('wallet-requests','ClientController@walletRequests');
Route::get('refund-complete-status/{id}/{name}','ClientController@walletRequestsComplete');

//=====================end-clients==============================

Route::resource('users', 'UserController');
// =============================start-categories=========================
Route::resource('categories', 'CategoryController');
Route::get('categories/{id}/update', 'CategoryController@update');
Route::get('categories/{id}/delete', 'CategoryController@delete');

// =============================end-categories=========================
// =============================start-vat-class=========================
Route::resource('vat-class', 'GenarelSettingController');
Route::get('vat-class/{id}/update', 'GenarelSettingController@update');
Route::get('vat-class/{id}/delete', 'GenarelSettingController@delete');

// =============================end-vat-class=========================

Route::get('genarel-settings', 'GenarelSettingController@create');
Route::get('week-types/{id}/delete', 'GenarelSettingController@deleteWeekType');
Route::post('weekTypes', 'GenarelSettingController@storeWeekType');
Route::get('week-types/{id}/{weekId}/edit', 'GenarelSettingController@editWeekTypeDayTime');
Route::post('weekTypesDayTimesUpdate', 'GenarelSettingController@weekTypesDayTimesUpdate');


//=======================================Roles=========================
Route::resource('roles', 'RoleController');
Route::get('roles/{id}/delete', 'RoleController@destory');
Route::resource('country', 'CountryController');
Route::get('country/{id}/delete', 'CountryController@destory');
//==============================Availability=======================

Route::get('availability', 'AvailabilityController@index');
Route::post('day-availability', 'AvailabilityController@storeAvailability');
Route::get('date-range', 'AvailabilityController@saveDateRange');
Route::get('available-weekType', 'AvailabilityController@saveWeekTypes');
Route::get('availability/weekType/{id}/{name}', 'AvailabilityController@availabilityWeekType');

// =========================================PDF==========================
Route::get('invoices/{id}/pdf', 'PDFController@index');
Route::get('invoices/pdf/{id}/download', 'PDFController@download');
Route::get('invoice-send/{id}/pdf', 'PDFController@sendPDF');
Route::get('invoice/{id}/pdf-send', 'PDFController@sendPDFInvoice');
Route::get('credit/pdf/{id}/download', 'PDFController@Creditdownload');
// =========================================Email==========================

Route::get('appointment-send/{id}/reminder','EmailController@reminder');
Route::get('orders-send/{id}/reminder','EmailController@sendReminderOrder');
Route::get('invoices-send/{id}/reminder','EmailController@sendReminderInvoice');

Route::get('setting/company','GenarelSettingController@companyIndex');
Route::post('setting/company','GenarelSettingController@saveCompany');
Route::get('seacrh_appointment','HomeController@seacrhAppointment');

});

});

// Auth::routes();
Route::get('unavailavail-check-date/{date}/date', 'AvailabilityController@checkUnavail');
Route::get('unavailable-weekType/{date}', 'AvailabilityController@checkUnavailTime');
Route::get('availability/weekTypeTimes/{date}/', 'AvailabilityController@getCurrentTimetable');
Route::get('login','LoginController@index');
Route::post('login','LoginController@checkLogin');
Route::get('email-checker','ClientController@checkEmail');


Route::get('daily-reminderCheck','reminderController@index');
