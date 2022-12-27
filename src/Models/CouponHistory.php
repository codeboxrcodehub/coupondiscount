<?php

namespace Codeboxr\CouponDiscount\Models;

use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    protected $table = "coupon_histories";

    protected $guarded = [];

    /**
     * Get Coupon Info
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
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
