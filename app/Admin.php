<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [];
    public function getImageAttribute($value)
    {
        return !is_null($value) ? asset(Storage::url($value)) : '';
    }

    /*
                     Route::group(['middleware' => ['permission:add_notifications',
            'permission:edit_notifications', 'permission:delete_notifications',
            'permission:show_notifications']], function () {

            Route::get('/my_cards/reportTable', 'MyCardController@reportTable');
            Route::group(['prefix' => 'reports'], function () {
                Route::get('/coupons/reportTable', 'CouponController@reportTable');

                Route::get('/transactions', 'TransactionController@report');
                Route::get('/transfers', 'TransferController@report');
                Route::get('/coupons', 'CouponController@report');

                Route::get('/cards', 'MyCardController@report');
            });
        });

     * */
}
