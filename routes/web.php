<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/storage_shortcut', function () {
    symlink(storage_path('app/public'), public_path('/storage'));
});

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('login_admin');
    Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin_login');
    Route::post('admin/logout', 'Admin\Auth\LoginController@logout')->name('admin_logout');

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
        Route::get('/', function () {
            return redirect('admin/profile');
        });
        Route::get('/profile', function () {
            return view('admin.profile');
        });

        Route::put('/profile', 'ProfileController@update');

        Route::put('/password', 'ProfileController@changePassword');
        Route::get('/get_user', function (\Illuminate\Http\Request $request) {
            $customers = \App\User::query()->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')->
                orWhere('email', 'like', '%' . $request->q . '%')->
                orWhere('mobile', 'like', '%' . $request->q . '%');
            })->get();
            $json = [];
            foreach ($customers as $customer) {
                $json[] = [
                    'id' => $customer->id,
                    'text' => $customer->name,
                ];
            }
            return json_encode($json);

        });

        Route::group(['prefix' => 'users'], function () {
            Route::group(['middleware' => ['permission:add_users']], function () {
                Route::get('/create', 'UserController@create');
                Route::post('', 'UserController@store');
            });
            Route::group(['middleware' => ['permission:edit_users']], function () {
                Route::get('/{id}/edit', 'UserController@edit');
                Route::put('/update_status', 'UserController@updateStatus');
                Route::put('/{id}', 'UserController@update');
            });
            Route::group(['middleware' => ['permission:delete_users']], function () {
                Route::delete('/{id}', 'UserController@destroy');
            });
            Route::group(['middleware' => ['permission:add_users|edit_users|delete_users|show_users']], function () {
                Route::get('/indexTable', 'UserController@indexTable');
                Route::get('', 'UserController@index');
                Route::get('/{id}', 'UserController@show');
            });
        });
        Route::group(['prefix' => 'admins'], function () {
            Route::group(['middleware' => ['permission:add_admins']], function () {
                Route::get('/create', 'AdminController@create');
                Route::post('', 'AdminController@store');
            });
            Route::group(['middleware' => ['permission:edit_admins']], function () {
                Route::get('/{id}/edit', 'AdminController@edit');
                Route::put('/update_status', 'AdminController@updateStatus');
                Route::put('/{id}', 'AdminController@update');
            });
            Route::group(['middleware' => ['permission:delete_admins']], function () {
                Route::delete('/{id}', 'AdminController@destroy');
            });
            Route::group(['middleware' => ['permission:add_admins|edit_admins|delete_admins|show_admins']], function () {
                Route::get('/indexTable', 'AdminController@indexTable');
                Route::get('', 'AdminController@index');
                Route::get('/{id}', 'AdminController@show');
            });
        });
        Route::group(['prefix' => '/categories'], function () {
            Route::group(['middleware' => ['permission:add_categories']], function () {
                Route::get('/create', 'CategoryController@create');
                Route::post('', 'CategoryController@store');
            });
            Route::group(['middleware' => ['permission:edit_categories']], function () {
                Route::get('/{id}/edit', 'CategoryController@edit');
                Route::put('/update_status', 'CategoryController@updateStatus');
                Route::put('/{id}', 'CategoryController@update');
            });
            Route::group(['middleware' => ['permission:delete_categories']], function () {
                Route::delete('/{id}', 'CategoryController@destroy');
            });
            Route::group(['middleware' => ['permission:add_categories|edit_categories|delete_categories|show_categories']], function () {
                Route::get('/indexTable', 'CategoryController@indexTable');
                Route::get('', 'CategoryController@index');
                Route::get('/{id}', 'CategoryController@show');
            });
        });
        Route::group(['prefix' => '/coupons'], function () {
            Route::group(['middleware' => ['permission:add_coupons']], function () {
                Route::get('/create', 'CouponController@create');
                Route::post('', 'CouponController@store');
            });
            Route::group(['middleware' => ['permission:edit_coupons']], function () {
                Route::get('/{id}/edit', 'CouponController@edit');
                Route::put('/update_status', 'CouponController@updateStatus');
                Route::put('/{id}', 'CouponController@update');
            });
            Route::group(['middleware' => ['permission:delete_coupons']], function () {
                Route::delete('/{id}', 'CouponController@destroy');
            });
            Route::group(['middleware' => ['permission:add_coupons|edit_coupons|delete_coupons|show_coupons']], function () {
                Route::get('/indexTable', 'CouponController@indexTable');
                Route::get('', 'CouponController@index');
                Route::get('/{id}', 'CouponController@show');
            });
        });
        Route::group(['prefix' => '/gifts'], function () {
            Route::group(['middleware' => ['permission:add_gifts']], function () {
                Route::get('/create', 'GiftController@create');
                Route::post('', 'GiftController@store');
            });
            Route::group(['middleware' => ['permission:edit_gifts']], function () {
                Route::get('/{id}/edit', 'GiftController@edit');
                Route::put('/update_status', 'GiftController@updateStatus');
                Route::put('/{id}', 'GiftController@update');
            });
            Route::group(['middleware' => ['permission:delete_gifts']], function () {
                Route::delete('/{id}', 'GiftController@destroy');
            });
            Route::group(['middleware' => ['permission:add_gifts|edit_gifts|delete_gifts|show_gifts']], function () {
                Route::get('/indexTable', 'GiftController@indexTable');
                Route::get('', 'GiftController@index');
                Route::get('/{id}', 'GiftController@show');
            });
        });
        Route::group(['prefix' => '/services'], function () {
            Route::group(['middleware' => ['permission:add_services']], function () {
                Route::get('/create', 'ServiceController@create');
                Route::post('', 'ServiceController@store');
            });
            Route::group(['middleware' => ['permission:edit_services']], function () {
                Route::get('/{id}/edit', 'ServiceController@edit');
                Route::put('/update_status', 'ServiceController@updateStatus');
                Route::put('/{id}', 'ServiceController@update');
            });
            Route::group(['middleware' => ['permission:delete_services']], function () {
                Route::delete('/{id}', 'ServiceController@destroy');
            });
            Route::group(['middleware' => ['permission:add_services|edit_services|delete_services|show_services']], function () {
                Route::get('/indexTable', 'ServiceController@indexTable');
                Route::get('', 'ServiceController@index');
                Route::get('/{id}', 'ServiceController@show');
            });
        });
        Route::group(['prefix' => '/offers'], function () {
            Route::group(['middleware' => ['permission:add_offers']], function () {
                Route::get('/create', 'OfferController@create');
                Route::post('', 'OfferController@store');
            });
            Route::group(['middleware' => ['permission:edit_offers']], function () {
                Route::get('/{id}/edit', 'OfferController@edit');
                Route::put('/update_status', 'OfferController@updateStatus');
                Route::put('/{id}', 'OfferController@update');
            });
            Route::group(['middleware' => ['permission:delete_offers']], function () {
                Route::delete('/{id}', 'OfferController@destroy');
            });
            Route::group(['middleware' => ['permission:add_offers|edit_offers|delete_offers|show_offers']], function () {
                Route::get('/indexTable', 'OfferController@indexTable');
                Route::get('', 'OfferController@index');
                Route::get('/{id}', 'OfferController@show');
            });
        });
        Route::group(['prefix' => '/user_offers'], function () {
            Route::group(['middleware' => ['permission:add_user_offers']], function () {
                Route::get('/create', 'UserOfferController@create');
                Route::post('', 'UserOfferController@store');
            });
            Route::group(['middleware' => ['permission:edit_user_offers']], function () {
                Route::get('/{id}/edit', 'UserOfferController@edit');
                Route::put('/update_status', 'UserOfferController@updateStatus');
                Route::put('/{id}', 'UserOfferController@update');
            });
            Route::group(['middleware' => ['permission:delete_user_offers']], function () {
                Route::delete('/{id}', 'UserOfferController@destroy');
            });
            Route::group(['middleware' => ['permission:add_user_offers|edit_user_offers|delete_user_offers|show_user_offers']], function () {
                Route::get('/indexTable', 'UserOfferController@indexTable');
                Route::get('', 'UserOfferController@index');
                Route::get('/{id}', 'UserOfferController@show');
            });
        });
        Route::group(['prefix' => '/user_gifts'], function () {
            Route::group(['middleware' => ['permission:add_user_gifts']], function () {
                Route::get('/create', 'UserGiftController@create');
                Route::post('', 'UserGiftController@store');
            });
            Route::group(['middleware' => ['permission:edit_user_gifts']], function () {
                Route::get('/{id}/edit', 'UserGiftController@edit');
                Route::put('/update_status', 'UserGiftController@updateStatus');
                Route::put('/{id}', 'UserGiftController@update');
            });
            Route::group(['middleware' => ['permission:delete_user_gifts']], function () {
                Route::delete('/{id}', 'UserGiftController@destroy');
            });
            Route::group(['middleware' => ['permission:add_user_gifts|edit_user_gifts|delete_user_gifts|show_user_gifts']], function () {
                Route::get('/indexTable', 'UserGiftController@indexTable');
                Route::get('', 'UserGiftController@index');
                Route::get('/{id}', 'UserGiftController@show');
            });
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
