<?php

namespace Codeboxr\CouponDiscount\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Coupon facade
 *
 * Class Coupon
 * @package Codeboxr\CouponDiscount\Facades
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