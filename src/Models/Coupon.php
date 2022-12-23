<?php

namespace Codeboxr\CouponDiscount\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $guarded = [];

    protected $appends = ['validity'];

    /**
     * coupon validity
     */
    public function getValidityAttribute()
    {
        if ($this->attributes['end_date']) {
            if ($this->attributes['end_date'] < Carbon::today()->toDateTimeString()) {
                return "Expired";
            } else {
                return "Continue";
            }
        } else {
            return "Unlimited";
        }
    }

    /**
     * Has many relation between coupon_histories table
     *
     * @return HasMany
     */
    public function couponHistories()
    {
        return $this->hasMany(CouponHistory::class, "coupon_id", "id");
    }

    /**
     * @param int $limit
     * @param int $page
     *
     * @return mixed
     */
    public static function paginate(int $limit = 10, int $page = 1)
    {
        return self::paginate($limit, "*", "page", $page);
    }
}
