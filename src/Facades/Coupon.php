<?php

namespace Codeboxr\CouponDiscount\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Coupon facade
 *
 * Class Coupon
 * @package Codeboxr\CouponDiscount\Facades
 * @method static \Codeboxr\CouponDiscount\Services\CouponService list()
 * @method static \Codeboxr\CouponDiscount\Services\CouponService add(array $array)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService remove($couponId)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService apply(array $data)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService addHistory(array $data)
 *
 * @see \Codeboxr\CouponDiscount\Services\CouponService
 */
class Coupon extends Facade
{
    /**
     * Coupon
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'coupon';
    }
}
