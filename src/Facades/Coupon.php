<?php

namespace Codeboxr\CouponDiscount\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Coupon facade
 *
 * Class Coupon
 * @package Codeboxr\CouponDiscount\Facades
 * @method static \Codeboxr\CouponDiscount\Services\CouponService list()
 * @method static \Codeboxr\CouponDiscount\Services\CouponService history()
 * @method static \Codeboxr\CouponDiscount\Services\CouponService add(array $array)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService update(array $array, int $id)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService remove($couponId)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService apply(array $data)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService addHistory(array $data)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService applyValidation(array $data)
 * @method static \Codeboxr\CouponDiscount\Services\CouponService validity(string $couponCode, float $amount, string $userId, string $deviceName = null, string $ipaddress = null, string $vendorId = null, array $skip = [])
 * @method static \Codeboxr\CouponDiscount\Services\CouponService historyDelete(int $historyId)
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
