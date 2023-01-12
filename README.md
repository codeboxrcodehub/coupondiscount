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
