<?php

namespace Codeboxr\CouponDiscount\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $guarded = [];

    /**
     * Has many relation between coupon_histories table
     *
     * @return HasMany
     */
    public function couponHistories()
    {
        return $this->hasMany(CouponHistory::class, "coupon_id", "id");
    }
}
