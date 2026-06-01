-- ShopExpress Database Schema (draw.io import)
-- 39 tables. Import via draw.io: Arrange -> Insert -> Advanced -> From SQL

CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255),
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `commission_rate` decimal(5,2),
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`)
);

CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL,
  `chat_id` bigint(20) unsigned NOT NULL,
  `sender_id` bigint(20) unsigned,
  `body` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `deleted_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `chat_participants` (
  `id` bigint(20) unsigned NOT NULL,
  `chat_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `last_read_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `chats` (
  `id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `funded_by` enum('platform','seller') NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL,
  `max_uses` int(10) unsigned,
  `used_count` int(10) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `discount` varchar(255),
  `expiry_date` date,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255),
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `customer_wallets` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `lifetime_credit` decimal(10,2) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `exchange_rates` (
  `id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `rate` decimal(15,8) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `homepage_banners` (
  `id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(255),
  `subtitle` varchar(255),
  `button_text` varchar(255),
  `button_link` varchar(255),
  `order` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `original_filename` varchar(255),
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned,
  `alt` varchar(255),
  `type` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
);

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255),
  `product_image` varchar(255),
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`)
);

CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned,
  `seller_id` bigint(20) unsigned,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_fee_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled','completed') NOT NULL,
  `payment_status` enum('pending','awaiting_verification','paid','failed','refunded') NOT NULL,
  `payment_method` varchar(255),
  `payment_proof` varchar(255),
  `payment_reference` varchar(255),
  `payment_verified_by` bigint(20) unsigned,
  `payment_verified_at` timestamp,
  `payment_verification_note` text,
  `payment_id` varchar(255),
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255),
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_postal_code` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL,
  `billing_address` text,
  `billing_city` varchar(255),
  `billing_state` varchar(255),
  `billing_postal_code` varchar(255),
  `billing_country` varchar(255),
  `payout_released` tinyint(1) NOT NULL,
  `notes` text,
  `coupon_code` varchar(255),
  `discount_amount` decimal(10,2) NOT NULL,
  `shipped_at` timestamp,
  `delivered_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `payout_requests` (
  `id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `phone` varchar(255),
  `seller_note` text,
  `status` enum('pending','approved','paid','rejected') NOT NULL,
  `processed_by` bigint(20) unsigned,
  `processed_at` timestamp,
  `transaction_reference` varchar(255),
  `admin_note` text,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`)
);

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `platform_transactions` (
  `id` bigint(20) unsigned NOT NULL,
  `type` enum('order_received','seller_payout','commission_earned','refund','payment_fee') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `balance_after` decimal(15,2) NOT NULL,
  `description` varchar(255),
  `order_id` bigint(20) unsigned,
  `seller_id` bigint(20) unsigned,
  `payout_request_id` bigint(20) unsigned,
  `admin_id` bigint(20) unsigned,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
);

CREATE TABLE `platform_wallet` (
  `id` bigint(20) unsigned NOT NULL,
  `balance` decimal(15,2) NOT NULL,
  `total_revenue` decimal(15,2) NOT NULL,
  `total_commission` decimal(15,2) NOT NULL,
  `total_paid_out` decimal(15,2) NOT NULL,
  `total_payment_fees` decimal(15,2) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned,
  `seller_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2),
  `sale_price` decimal(10,2),
  `on_sale` tinyint(1) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `page_views` bigint(20) unsigned NOT NULL,
  `sku` varchar(255) NOT NULL,
  `image` varchar(255),
  `gallery` longtext,
  `images` longtext,
  `specifications` longtext,
  `is_featured` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `meta_title` varchar(255),
  `meta_description` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `refunds` (
  `id` bigint(20) unsigned NOT NULL,
  `reference` varchar(40) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `return_request_id` bigint(20) unsigned,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `refund_type` enum('original_payment','store_credit','bank_transfer') NOT NULL,
  `status` enum('pending','processing','completed','failed') NOT NULL,
  `gateway_refund_id` varchar(100),
  `failure_reason` text,
  `processed_by` bigint(20) unsigned,
  `processed_at` timestamp,
  `notes` text,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`)
);

CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `user_id` bigint(20) unsigned,
  `status` varchar(255) NOT NULL,
  `images` longtext,
  `is_read` tinyint(1) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `return_request_attachments` (
  `id` bigint(20) unsigned NOT NULL,
  `return_request_id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `original_name` varchar(255),
  `type` enum('photo','document') NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`)
);

CREATE TABLE `return_request_items` (
  `id` bigint(20) unsigned NOT NULL,
  `return_request_id` bigint(20) unsigned NOT NULL,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_refund` decimal(10,2) NOT NULL,
  `line_refund` decimal(10,2) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`),
  FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`)
);

CREATE TABLE `return_requests` (
  `id` bigint(20) unsigned NOT NULL,
  `reference` varchar(40) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `vendor_order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `reason_code` enum('damaged','wrong_item','not_as_described','defective','changed_mind','never_received','other') NOT NULL,
  `reason_description` text,
  `refund_method` enum('original_payment','store_credit') NOT NULL,
  `refund_amount` decimal(10,2) NOT NULL,
  `return_items_required` tinyint(1) NOT NULL,
  `status` enum('pending_seller_review','approved','rejected','in_transit','received','refunded','completed','disputed','cancelled') NOT NULL,
  `seller_response` text,
  `seller_responded_at` timestamp,
  `admin_id` bigint(20) unsigned,
  `admin_notes` text,
  `resolved_at` timestamp,
  `return_tracking_number` varchar(100),
  `return_carrier` varchar(50),
  `refund_transaction_id` varchar(100),
  `refund_processed_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`vendor_order_id`) REFERENCES `vendor_orders` (`id`)
);

CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `rating` int(10) unsigned NOT NULL,
  `comment` text,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `seller_followers` (
  `id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `sellers` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `business_document` varchar(255),
  `status` enum('pending','approved','rejected') NOT NULL,
  `admin_comment` varchar(255),
  `store_logo` varchar(255),
  `store_banner` varchar(255),
  `contact_email` varchar(255),
  `address` varchar(255),
  `phone` varchar(255),
  `website` varchar(255),
  `facebook` varchar(255),
  `instagram` varchar(255),
  `tiktok` varchar(255),
  `ships_worldwide` tinyint(1) NOT NULL,
  `returns_days` smallint(5) unsigned,
  `shipping_summary` varchar(255),
  `response_time` varchar(255),
  `verified_at` timestamp,
  `commission_rate` decimal(5,2) NOT NULL,
  `promo_until` date,
  `created_at` timestamp,
  `updated_at` timestamp,
  `followers_count` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `store_reviews` (
  `id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `comment` text NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `on_sale` tinyint(1) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `user_reports` (
  `id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `user_id` bigint(20) unsigned,
  `status` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `images` text,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255),
  `role` enum('user','admin','seller') NOT NULL,
  `status` enum('active','suspended','banned') NOT NULL,
  `email_verified_at` timestamp,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100),
  `profile_image` varchar(255),
  `preferred_currency` varchar(3) NOT NULL,
  `preferred_language` varchar(2) NOT NULL,
  `timezone` varchar(255),
  `timezone_offset` int(11),
  `last_active_at` timestamp,
  `shipping_address` text,
  `billing_address` text,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`)
);

CREATE TABLE `vendor_orders` (
  `id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount_allocated` decimal(10,2) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `commission_source` varchar(20) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `payment_fee` decimal(10,2) NOT NULL,
  `seller_earnings` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `payout_status` enum('pending','available','paid') NOT NULL,
  `stripe_account_id` varchar(255),
  `stripe_transfer_id` varchar(255),
  `paid_out_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`)
);

CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `balance` decimal(15,2) NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`)
);

CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
