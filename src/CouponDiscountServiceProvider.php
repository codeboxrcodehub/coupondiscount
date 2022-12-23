<?php

namespace Codeboxr\CouponDiscount;

use Illuminate\Support\ServiceProvider;

class CouponDiscountServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $time = time();

        $this->publishes([
            __DIR__ . '/../database/migrations/create_coupons_table.stub'          => database_path('migrations/' . date('Y_m_d_His', $time) . '_create_coupons_table.php'),
            __DIR__ . '/../database/migrations/create_coupon_histories_table.stub' => database_path('migrations/' . date('Y_m_d_His', $time + 1) . '_create_coupon_histories_table.php'),
        ], 'migrations');
    }


    /**
     * Register application services
     *
     * @return void
     */
    public function register()
    {

    }

}
