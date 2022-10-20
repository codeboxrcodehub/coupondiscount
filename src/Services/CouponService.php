<?php

namespace Codeboxr\CouponDiscount\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use Codeboxr\CouponDiscount\Models\Coupon;
use Codeboxr\CouponDiscount\Models\CouponHistory;
use Codeboxr\CouponDiscount\Exceptions\CouponException;
use Codeboxr\CouponDiscount\Exceptions\CouponValidationException;
use Codeboxr\CouponDiscount\Exceptions\CouponHistoryValidationException;

class CouponService extends CouponValidityService
{

    public function __construct(array $connection = [])
    {
        if (!class_exists("Illuminate\Foundation\Application")) {
            if (!count($connection)) {
                throw new \Exception("Database connection information is missing");
            }

            $capsule           = new Manager();
            $connection_params = [
                "driver"   => isset($connection['driver']) ? $connection['driver'] : "mysql",
                "host"     => isset($connection['host']) ? $connection['host'] : "localhost",
                "database" => isset($connection["database"]) ? $connection["database"] : "",
                "username" => isset($connection["username"]) ? $connection["username"] : "",
                "password" => isset($connection["password"]) ? $connection["password"] : "",
            ];

            $capsule->addConnection($connection_params);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        }
    }

    /**
     * Add coupon
     *
     * @param array $array
     *
     * @return Builder|Model
     * @throws CouponValidationException|CouponException
     */
    public function add($array)
    {
        $this->validation($array);

        $object_type = "product";
        if (isset($array['object_type'])) {
            $object_type = $array['object_type'];
        }

        return Coupon::query()
            ->create([
                "object_type"        => $object_type,
                "code"               => $array["coupon_code"],
                "type"               => $array["discount_type"],
                "amount"             => $array["discount_amount"],
                "minimum_spend"      => $array["minimum_spend"],
                "maximum_spend"      => $array["maximum_spend"],
                "start_date"         => $array["start_date"],
                "end_date"           => $array["end_date"],
                "use_limit"          => $array["use_limit"],
                "same_ip_limit"      => $array["use_same_ip_limit"],
                "use_limit_per_user" => $array['user_limit'],
                "use_device"         => $array['use_device']
            ]);
    }

    /**
     * Coupon remove
     *
     * @param int $couponId
     *
     * @return bool
     * @throws CouponException
     */
    public function remove($couponId)
    {
        if (!is_int($couponId)) {
            throw new \TypeError("Argument must be of the type integer");
        }

        $coupon = Coupon::query()->find($couponId);
        if ($coupon) {
            CouponHistory::query()->where("coupon_id", $couponId)->delete();
            $coupon->delete();
        } else {
            throw new CouponException("Invalid coupon id");
        }

        return true;
    }

    /**
     * Apply coupon
     *
     * @param array $data
     *
     * @return bool
     * @throws CouponException|CouponValidationException
     */
    public function apply(array $data)
    {
        $this->applyValidation($data);

        $code       = $data["code"];
        $amount     = $data["amount"];
        $userId     = $data["user_id"];
        $orderId    = $data["order_id"];
        $deviceName = isset($data['device_name']) ? $data['device_name'] : null;
        $ipaddress  = isset($data['ip_address']) ? $data['ip_address'] : null;

        $coupon = Coupon::query()->where("code", $code)->first();
        if (!$coupon) {
            throw new CouponException("Invalid coupon code!", 500);
        }

        // check applied coupon code code validity
        $couponValidity = $this->validity($coupon->id, $amount, $userId, $deviceName, $ipaddress);

        if (count($couponValidity)) {
            try {
                // calculate discount amount
                $discountAmount = 0;
                if ($coupon->type == "fixed") {
                    $discountAmount = $coupon->amount;
                } else {
                    $discountAmount = ($coupon->amount * $amount) / 100;
                }

                $couponHistory = $this->addHistory([
                    "user_id"         => $userId,
                    "coupon_id"       => $coupon->id,
                    "order_id"        => $orderId,
                    "object_type"     => $coupon->object_type,
                    "discount_amount" => $discountAmount,
                    "user_ip"         => $ipaddress,
                ]);
                return true;
            } catch (\Exception $e) {
                throw new CouponException($e->getMessage(), $e->getCode());
            }
        } else {
            throw new CouponException("Invalid data!", 500);
        }
    }

    /**
     * Add coupon history
     *
     * @param array $data
     *
     * @return Builder|Model
     * @throws CouponHistoryValidationException|CouponException|CouponValidationException
     */
    public function addHistory(array $data)
    {
        $this->historyValidation($data);

        try {
            DB::beginTransaction();

            $object_type = "product";
            if (isset($array['object_type']) && !empty($array['object_type'])) {
                $object_type = $array['object_type'];
            }

            $couponHistory = CouponHistory::query()
                ->create([
                    "user_id"         => $data['user_id'],
                    "coupon_id"       => $data["coupon_id"],
                    "order_id"        => $data['order_id'],
                    "object_type"     => $object_type,
                    "discount_amount" => $data['discount_amount'],
                    "user_ip"         => isset($data['user_ip']) ? $data['user_ip'] : null,
                ]);;

            $coupon            = Coupon::query()->find($data['order_id']);
            $coupon->total_use = $coupon->total_use + 1;
            $coupon->save();

            DB::commit();
            return $couponHistory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CouponException($e->getMessage(), $e->getCode());
        }
    }

}
