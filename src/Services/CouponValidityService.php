<?php

namespace Codeboxr\CouponDiscount\Services;

use Carbon\Carbon;
use Codeboxr\CouponDiscount\Models\Coupon;
use Codeboxr\CouponDiscount\Exceptions\CouponException;
use Codeboxr\CouponDiscount\Exceptions\CouponValidationException;
use Codeboxr\CouponDiscount\Exceptions\CouponHistoryValidationException;

class CouponValidityService
{
    /**
     * Coupon add validation
     *
     * @param array $array
     *
     * @throws CouponValidationException|CouponException
     */
    protected function validation($array)
    {
        if (!is_array($array)) {
            throw new \TypeError("Argument must be of the type array");
        }

        if (!count($array)) {
            throw new CouponValidationException("Invalid data!", 422);
        }

        $requiredFields = ['coupon_code', 'discount_type', 'discount_amount', 'start_date', 'end_date'];
        $this->fieldValidation($array, $requiredFields);

        if (!in_array($array["discount_type"], ["fixed", "percentage"])) {
            throw new CouponValidationException("discount_type must be fixed or percentage value", 422);
        }

        if (isset($array['use_limit']) && gettype($array['use_limit']) != "integer") {
            throw new CouponValidationException("use_limit accepted integer value", 422);
        }

        if (isset($array['use_same_ip_limit']) && gettype($array['use_same_ip_limit']) != "integer") {
            throw new CouponValidationException("use_same_ip_limit accepted integer value", 422);
        }

        if (isset($array['user_limit']) && gettype($array['user_limit']) != "integer") {
            throw new CouponValidationException("user_limit accepted integer value", 422);
        }

    }

    /**
     * Coupon history validation
     *
     * @param array $array
     *
     * @throws CouponHistoryValidationException|CouponException|CouponValidationException
     */
    protected function historyValidation($array)
    {
        if (!count($array)) {
            throw new CouponHistoryValidationException("Invalid data!", 422);
        }

        $requiredFields = ['user_id', 'coupon_id', 'order_id', 'discount_amount'];
        $this->fieldValidation($array, $requiredFields);
    }

    /**
     * Apply coupon validation
     *
     * @param array $array
     *
     * @throws CouponException|CouponValidationException
     */
    protected function applyValidation($array)
    {
        if (!is_array($array)) {
            throw new \TypeError("Argument must be of the type array");
        }

        if (!count($array)) {
            throw new CouponException("Invalid data!", 422);
        }

        $this->fieldValidation($array, ["code", "amount", "user_id", "order_id"]);
    }

    /**
     * Array data validation
     *
     * @param array $array
     * @param array $requiredFields
     *
     * @throws CouponException|CouponValidationException
     */
    private function fieldValidation(array $array, array $requiredFields)
    {
        if (!count($array)) {
            throw new CouponException("Invalid data!", 422);
        }

        if (!count($requiredFields)) {
            throw new CouponException("Invalid data!", 422);
        }

        $requiredColumns = array_diff($requiredFields, array_keys($array));

        if (count($requiredColumns)) {
            throw new CouponValidationException($requiredColumns, 422);
        }

        foreach ($requiredFields as $filed) {
            if (isset($data[$filed]) && empty($data[$filed])) {
                throw new CouponValidationException("$filed is required", 422);
            }
        }
    }

    /**
     * Check coupon validity
     *
     * @param int $couponId
     * @param float $amount
     *
     * @param string $userId
     * @param string|null $ipaddress
     * @param string|null $deviceName
     *
     * @return array
     * @throws CouponException
     */
    public function validity($couponId, float $amount, string $userId, string $deviceName = null, string $ipaddress = null)
    {
        $coupon = Coupon::query()->find($couponId);

        if (!$coupon) {
            throw new CouponException("Invalid coupon code!", 500);
        }

        if ($coupon->start_date >= Carbon::today()->toDateTimeString() || $coupon->end_date < Carbon::today()->toDateTimeString()) {
            throw new CouponException("Coupon apply failed! This coupon has expired.", 500);
        }

        if ($coupon->use_limit_per_user) {
            $couponHistories = $coupon->couponHistories->where("user_id", $userId);
            if ($couponHistories && $couponHistories->count() == $coupon->use_limit_per_user) {
                throw new CouponException("Coupon apply failed! You have exceeded the usage limit.", 500);
            }
        }

        if ($coupon->use_limit) {
            if ($coupon->couponHistories->count() && $coupon->couponHistories->count() == $coupon->use_limit) {
                throw new CouponException("Coupon apply failed! Because of exceeding the usage limit.", 500);
            }
        }

        if ($coupon->minimum_spend && $coupon->minimum_spend > $amount) {
            throw new CouponException("Invalid Amount! To apply this coupon minimum {$coupon->minimum_spend} amount is required", 500);
        }

        if ($coupon->maximum_spend && $coupon->maximum_spend < $amount) {
            throw new CouponException("Invalid Amount! To apply this coupon maximum {$coupon->minimum_spend} amount is required", 500);
        }

        if ($coupon->use_device) {
            if (empty($deviceName)) {
                throw new CouponException("Coupon apply failed! Not found any device name");
            }

            if ($coupon->use_device != $deviceName) {
                throw new CouponException("Coupon apply failed! This coupon only apply to " . ucfirst($coupon->use_device));
            }
        }

        if ($coupon->same_ip_limit) {
            if (empty($ipaddress)) {
                throw new CouponException("Coupon apply failed! Not found any IP address");
            }

            if (!filter_var($ipaddress, FILTER_VALIDATE_IP)) {
                throw new CouponException("Invalid IP address!");
            }

            $couponHistories = $coupon->couponHistories->where("user_ip", $ipaddress);
            if ($couponHistories && $coupon->same_ip_limit <= $couponHistories->count()) {
                throw new CouponException("Sorry, there are lots of order happened from your ip location using this coupon, we are not accepting more orders from your ip location for this coupon.");
            }
        }

        return [
            "coupon_code" => $coupon->code,
            "type"        => $coupon->type,
            "amount"      => $coupon->amount,
        ];

    }

}
