<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingOptionalController;
use App\Http\Controllers\Auth\ChangePasswordController;

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
    return redirect('/dashboard');
});

Auth::routes();

Route::get('activate/{token}', 'ActivateUserController');

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $data = [
            'pageTitle' => __('Dashboard'),
            'pageHeader' => __('Dashboard'),
            'pageSubHeader' => __('All stats summary in one page')
        ];
        return view('dashboard.index', $data);
    })->name('dashboard');

    Route::resource('/rooms', 'RoomController');
    Route::post('/bookings/search', 'BookingController@search')->name('bookings.search');
    Route::post('/bookings/cancel', 'BookingController@cancel')->name('bookings.cancel');
    Route::resource('/bookings', 'BookingController');
    Route::resource('/users', 'UserController');

    Route::get('/booking/all','FullcalendarController@getBookingAll')->name('fullcalendar.bookingall');
    Route::get('/booking/all/eur','FullcalendarController@getBookingEur')->name('fullcalendar.bookingeur');
    Route::get('/booking/all/boezio','FullcalendarController@getBookingBoezio')->name('fullcalendar.bookingboezio');
    Route::get('/booking/all/regolo','FullcalendarController@getBookingRegolo')->name('fullcalendar.bookingregolo');

    Route::get('/room/all','FullcalendarController@getRoomAll')->name('fullcalendar.roomall');
    Route::get('/room/all/eur','FullcalendarController@getRoomEur')->name('fullcalendar.roomeur');
    Route::get('/room/all/boezio','FullcalendarController@getRoomBoezio')->name('fullcalendar.roomboezio');
    Route::get('/room/all/regolo','FullcalendarController@getRoomRegolo')->name('fullcalendar.roomregolo');

    Route::get('/calendar/all', function () {
        $pageHeader = 'Booking Calendar';
        $pageTitle = 'Booking Calendar';
        $pageSubHeader = '';
        return view('dashboard.rooms-all')->with([
            'pageHeader' => $pageHeader,
            'pageSubHeader' => $pageSubHeader,
            'pageTitle' => $pageTitle
        ]);
    })->name('total_calendar_booking');

    Route::get('/calendar/eur', function () {
        $pageHeader = 'Booking Calendar Eur';
        $pageSubHeader = '';
        $pageTitle = 'Booking Calendar Eur';
        return view('dashboard.rooms-eur')->with([
            'pageHeader' => $pageHeader,
            'pageSubHeader' => $pageSubHeader,
            'pageTitle' => $pageTitle
        ]);
    })->name('total_calendar_booking_eur');

    Route::get('/calendar/boezio', function () {
        $pageHeader = 'Booking Calendar Boezio';
        $pageSubHeader = '';
        $pageTitle = 'Booking Calendar Boezio';
        return view('dashboard.rooms-boezio')->with([
            'pageHeader' => $pageHeader,
            'pageSubHeader' => $pageSubHeader,
            'pageTitle' => $pageTitle
        ]);
    })->name('total_calendar_booking_boezio');

    Route::get('/calendar/regolo', function () {
        $pageHeader = 'Booking Calendar Regolo';
        $pageSubHeader = '';
        $pageTitle = 'Booking Calendar Regolo';
        return view('dashboard.rooms-regolo')->with([
            'pageHeader' => $pageHeader,
            'pageSubHeader' => $pageSubHeader,
            'pageTitle' => $pageTitle
        ]);
    })->name('total_calendar_booking_regolo');


    Route::resource('/security', 'SecurityController');

   // Route::resource('/options','OptionalController');
   // Route::get('/options','OptionalController@create')->name('optional.create');
    Route::resource('bookingoptionals', 'BookingOptionalController');
    Route::post('bookingoptional/storenewoptional','BookingOptionalController@storenewoptional')->name('storenewoptional');

    Route::get('bookingoptionals/optionalcreate/{id}','BookingOptionalController@optionalcreate')->name('optionalcreate');

    Route::get('change-password', [ChangePasswordController::class, 'show'])->name('change-password.show');
    Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
});

Route::prefix('datatables')->group(function () {
    Route::get('rooms', 'DatatableController@getRooms')->name('datatables.rooms');
    Route::get('bookings', 'DatatableController@getBookings')->name('datatables.bookings');
    Route::get('users', 'DatatableController@getUsers')->name('datatables.users');
    Route::get('roles', 'DatatableController@getRoles')->name('datatables.roles');
});

Route::prefix('fullcalendar')->group(function () {
    Route::get('room/{id}', 'FullcalendarController@getBookingByRoomId')->name('fullcalendar.room');
});

Route::get('mybookings','MyBookingController@show')->name('mybookings')->middleware('auth');


Route::get('/privacy', function () {
    return view('privacy');
});





