<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Offer extends Model
{
    use SoftDeletes, HasTranslations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];
    public $appends = ['image', 'locale_title', 'locale_description', 'category_name', 'coupon_name', 'status_text'];
    public $translatable = ['title', 'description'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function services()
    {
        return $this->belongsToMany(Service::class, 'offer_services');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function images()
    {
        return $this->hasMany(OfferImage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getStatusTextAttribute($value)
    {
        $arr = [1 => __('common.active'), 0 => __('common.inactive')];
        return $arr[$this->status];
    }
    public function getCategoryNameAttribute($value)
    {
        return @$this->category->name;
    }
    public function getCouponNameAttribute($value)
    {
        return @$this->coupon->name;
    }
    public function getLocaleTitleAttribute($value)
    {
        return $this->title;
    }
    public function getLocaleDescriptionAttribute($value)
    {
        return $this->description;
    }
    public function getImageAttribute ($value)
    {
        return @$this->images->first()->image;
    }

    /*
       |--------------------------------------------------------------------------
       | MUTATORS
       |--------------------------------------------------------------------------
       */

    /*
    |--------------------------------------------------------------------------
    | BOOTS
    |--------------------------------------------------------------------------
    */


}
