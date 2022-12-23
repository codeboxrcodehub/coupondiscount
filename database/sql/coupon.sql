CREATE TABLE `coupons`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `object_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `code`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `type`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `amount`      double(12, 2
) NOT NULL,
  `minimum_spend` double(12,2) DEFAULT NULL,
  `maximum_spend` double(12,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `use_limit` int(11) DEFAULT NULL,
  `same_ip_limit` int(11) DEFAULT NULL,
  `use_limit_per_user` int(11) DEFAULT NULL,
  `use_device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multiple_use` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `total_use` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
