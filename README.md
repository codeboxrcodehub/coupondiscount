<h1 align="center">Coupon Discount php/laravel package</h1>
<p align="center" >
<img src="https://img.shields.io/packagist/dt/codeboxr/coupondiscount">
<img src="https://img.shields.io/packagist/stars/codeboxr/coupondiscount">
</p>

This is a PHP/Laravel package for Coupon Discount. This package can be used in laravel or without laravel/php projects. You can use this package for headless/rest implementation as well as blade or regular mode development. We created this
package while working for a project and thought to made it release for all so that it helps. This package is available as regular php [composer package](https://packagist.org/packages/codeboxr/coupondiscount).

## Requirements

- PHP >=7.4

## Installation

```bash
composer require codeboxr/coupondiscount
```

## Usage

If you are using laravel this package in laravel you have to publish migration first and migrate by the following command.

```bash
php artisan vendor:publish --provider="Codeboxr\CouponDiscount\CouponDiscountServiceProvider"
```

```bash
php artisan migrate
```

coupons and coupon_histories two db table are created.

`Note:` If you are using raw PHP or other PHP framework you can have to import `copuondiscount/database/sql` SQL file manually in your database.

### 1. Create new coupon

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;
Coupon::add([
    'coupon_code'       => "",  // (required) Coupon code
    'discount_type'     => "", // (required) coupon discount type. two type are accepted (1. percentage and 2. fixed)
    'discount_amount'   => "", // (required) discount amount or percentage value
    'start_date'        => "", // (required) coupon start date
    'end_date'          => "", // (required) coupon end date
    'status'            => "", // (required) two status are accepted. (for active 1 and for inactive 0)
    'minimum_spend'     => "", // (optional) for apply this coupon minimum spend amount. if set empty then it's take unlimited
    'maximum_spend'     => "", // (optional) for apply this coupon maximum spend amount. if set empty then it's take unlimited
    'use_limit'         => "", // (optional) how many times are use this coupon. if set empty then it's take unlimited
    'use_same_ip_limit' => "", // (optional) how many times are use this coupon in same ip address. if set empty then it's take unlimited
    'user_limit'        => "", // (optional) how many times are use this coupon a user. if set empty then it's take unlimited
    'use_device'        => "", // (optional) This coupon can be used on any device
    'multiple_use'      => "", // (optional) you can check manually by this multiple coupon code use or not
    'vendor_id'         => "" // (optional) if coupon code use specific shop or vendor
]);
```

`*** For Using Raw php or other framwork`

```
use Codeboxr\CouponDiscount\Services\CouponService;

$copuon = new CouponService([
    "driver"   => "", // (optional) database driver. By default it takes `mysql`
    "host"     => "", // (optional) database host. By default it takes `localhost`
    "username  => "", // (required) database user name.
    "password" => ""  // (required) database password,
]);

$copuon->add([
    'coupon_code'       => "",  // (required) Coupon code
    'discount_type'     => "", // (required) coupon discount type. two type are accepted (1. percentage and 2. fixed)
    'discount_amount'   => "", // (required) discount amount or percentage value
    'start_date'        => "", // (required) coupon start date
    'end_date'          => "", // (required) coupon end date
    'status'            => "", // (required) two status are accepted. (for active 1 and for inactive 0)
    'minimum_spend'     => "", // (optional) for apply this coupon minimum spend amount. if set empty then it's take unlimited
    'maximum_spend'     => "", // (optional) for apply this coupon maximum spend amount. if set empty then it's take unlimited
    'use_limit'         => "", // (optional) how many times are use this coupon. if set empty then it's take unlimited
    'use_same_ip_limit' => "", // (optional) how many times are use this coupon in same ip address. if set empty then it's take unlimited
    'user_limit'        => "", // (optional) how many times are use this coupon a user. if set empty then it's take unlimited
    'use_device'        => "", // (optional) This coupon can be used on any device
    'multiple_use'      => "", // (optional) you can check manually by this multiple coupon code use or not
    'vendor_id'         => "" // (optional) if coupon code use specific shop or vendor
]);

```
