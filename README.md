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

| Action Name         | Method                   | Explanation                                                                                                                                                                                      |
| -------------       | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| [Create Coupon](https://github.com/codeboxrcodehub/coupondiscount#1-create-new-coupon)       | add($array)              | Create coupon code by add() method it taken a array. Array formate given below                                                                                                                   |
| [Update Coupon](https://github.com/codeboxrcodehub/coupondiscount#2-update-coupon)       | update($array,$couponId) | Coupon Update by update() method it's taken two parameter first parameter is an array and second parameter is coupon id                                                                          |
| [Remove Coupon](https://github.com/codeboxrcodehub/coupondiscount#3-remove-coupon)       | remove($couponId)        | Coupon Remove by remove() method it's taken one parameter. Parameter is Coupon id                                                                        |
| [Coupon List](https://github.com/codeboxrcodehub/coupondiscount#4-coupon-list)         | list()                   | Fetch coupon list by list() method. You can chain any operation in Eluquarant after this method. For example: `list()->where('status',1)->get();`,`list()->take(5)->get();`,`list()->first();` etc |
| [Coupon Validity](https://github.com/codeboxrcodehub/coupondiscount#5-coupon-validity-check)    | validity($couponCode, float $amount, string $userId, string $deviceName = null, string $ipaddress = null, string $vendorId = null)   | check coupon code validity by validity() method. It's take 6 parameter 3 parameter are required. 1st parameter is coupon code,second parameter is total amount,third parameter is user id,fourth parameter (optional) device name,fifth parameter (optional) is IP address and sixth parameter (optional) is vendor id or shop id |
| [Coupon Apply](https://github.com/codeboxrcodehub/coupondiscount#6-coupon-apply)        | apply($array)            | Apply coupon in a cart amount by apply() method. apply method taken one parameter is array, example given below |
| [Coupon History List](https://github.com/codeboxrcodehub/coupondiscount#7-coupon-history-list) | history()                | Fetch coupon history list by history() method. You can chain any operation in Eluquarant after this method. For example: `history()->where('user_id',1)->get();`,`history()->take(5)->get();`,`history()->first();` etc |
| [Remove History](https://github.com/codeboxrcodehub/coupondiscount#8-delete-coupon-history)      | historyDelete($historyId)| Coupon History Remove by historyDelete() method it's taken one parameter. Parameter is Coupon history id                                                                        |

### 1. Create new coupon

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;
Coupon::add([
    'coupon_code'       => "", // (required) Coupon code
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
    'vendor_id'         => ""  // (optional) if coupon code use specific shop or vendor
]);
```

`*** For Using Raw php or other php framwork`

```
use Codeboxr\CouponDiscount\Services\CouponService;

$copuon = new CouponService([
    "driver"   => "", // (optional) database driver. By default it takes `mysql`
    "host"     => "", // (optional) database host. By default it takes `localhost`
    "username  => "", // (required) database user name.
    "password" => ""  // (required) database password,
]);

$copuon->add([
    'coupon_code'       => "", // (required) Coupon code
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

### 2. Update coupon

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;
Coupon::update([
    'coupon_code'       => "", // (required) Coupon code
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
], $couponId);
```

`*** For Using Raw php or other php framwork`

```
$copuon->update([
    'coupon_code'       => "", // (required) Coupon code
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
], $couponId);

```

### 3. Remove coupon

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::remove($couponId)
```

`*** For Using Raw php or other php framwork`

```
$copuon->remove($couponId);
```

### 4. Coupon List

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::list()->get();
```

`*** For Using Raw php or other php framwork`

```
$copuon->list()->get();
```

### 5. Coupon validity check

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::validity("CBX23",1200,1,"app","192.168.0.1",5);
```

`*** For Using Raw php or other php framwork`

```
$copuon->validity("CBX23",1200,1,"app","192.168.0.1",5);
```

``note: validity() method first 3 method parameter are required others optional``

### 6. Coupon apply

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::apply([
    "code"        => "", // coupon code. (required)
    "amount"      => "", // total amount to apply coupon. must be a numberic number (required)
    "user_id"     => "", // user id (required)
    "order_id"    => "", // order id (required)
    "device_name" => "", // device name (optional)
    "ip_address"  => "", // ip address (optional)
]);
```

`*** For Using Raw php or other php framwork`

```
$copuon->apply([
    "code"        => "", // coupon code. (required)
    "amount"      => "", // total amount to apply coupon. must be a numberic number (required)
    "user_id"     => "", // user id (required)
    "order_id"    => "", // order id (required)
    "device_name" => "", // device name (optional)
    "ip_address"  => "", // ip address (optional)
]);
```

### 7. Coupon history list

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::history()->get();
```

`*** For Using Raw php or other php framwork`

```
$copuon->history()->get();
```

### 8. Delete coupon history

`*** For Using Laravel Application`

```
use Codeboxr\CouponDiscount\Facades\Coupon;

Coupon::historyDelete($historyId)
```

`*** For Using Raw php or other php framwork`

```
$copuon->historyDelete($historyId);
```

## Contributing

Contributions to the Coupon Discount package are welcome. Please note the following guidelines before submitting your pull request.

- Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.

## License

Coupon Discount package is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2023 [Codeboxr](https://codeboxr.com)
