CREATE TABLE `coupon_histories`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `user_id`         bigint(20) UNSIGNED NOT NULL,
    `coupon_id`       bigint(20) UNSIGNED NOT NULL,
    `order_id`        bigint(20) UNSIGNED NOT NULL,
    `object_type`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `discount_amount` double(12, 2
) NOT NULL,
  `user_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupon_histories`
--
ALTER TABLE `coupon_histories`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupon_histories`
--
ALTER TABLE `coupon_histories`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;