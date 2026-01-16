-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 06, 2025 at 05:06 PM
-- Server version: 11.7.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('confirmed','cancelled') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `img` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`shop_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','business','admin') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `role`) VALUES
('customer1@example.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LeXt0y4MRUMKv.1yW', 'customer'),
('customer2@example.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LeXt0y4MRUMKv.1yW', 'customer'),
('store1@example.com', '$2y$12$6ZvLk8/.3iJN3j5K2qQTdeO8QSjJ8qQX2VzKj.9dVFYjxB9cQyQG', 'business'),
('store2@example.com', '$2y$12$6ZvLk8/.3iJN3j5K2qQTdeO8QSjJ8qQX2VzKj.9dVFYjxB9cQyQG', 'business'),
('admin@example.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LeXt0y4MRUMKv.1yW', 'admin'),
('store3@example.com', '$2y$12$6ZvLk8/.3iJN3j5K2qQTdeO8QSjJ8qQX2VzKj.9dVFYjxB9cQyQG', 'business');

-- Add shops
INSERT INTO `shops` (`owner_id`, `name`, `description`, `address`, `contact_email`, `contact_number`, `img`, `created_at`) VALUES
(2, 'Tech Gadgets', 'The best tech gadgets at affordable prices. We specialize in the latest technology and accessories.', '123 Tech Street, Silicon Valley, CA', 'business@business.com', '123-456-7890', 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/shops/tech_store_kbp5v8.jpg', '2025-03-15 12:00:00'),
(5, 'Fashion Hub', 'Your one-stop shop for trendy fashion. Find the latest styles and accessories for every occasion.', '456 Fashion Avenue, New York, NY', 'store1@example.com', '234-567-8901', 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/shops/fashion_shop_y3bglk.jpg', '2025-03-16 14:30:00'),
(6, 'Home & Garden', 'Everything you need to make your house a home. Quality furniture, decor, and garden supplies.', '789 Home Boulevard, Portland, OR', 'store2@example.com', '345-678-9012', 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/shops/home_garden_shop_f1xlhb.jpg', '2025-03-17 09:45:00'),
(2, 'Bookworm Paradise', 'A haven for book lovers. Browse our extensive collection of fiction, non-fiction, and specialty titles.', '321 Reader Lane, Boston, MA', 'business@business.com', '456-789-0123', 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/shops/book_shop_pztcji.jpg', '2025-03-18 16:15:00');

-- Add products
INSERT INTO `products` (`shop_id`, `name`, `description`, `price`, `stock`, `img`, `created_at`) VALUES
-- Tech Gadgets products (shop_id 1)
(1, 'Wireless Earbuds', 'High-quality wireless earbuds with noise cancellation and long battery life. Perfect for music lovers on the go.', 49.99, 25, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/wireless_earbuds_s6lj2e.jpg', '2025-03-19 10:00:00'),
(1, 'Smart Watch', 'Track your fitness, receive notifications, and more with this feature-packed smart watch. Compatible with iOS and Android.', 129.99, 15, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/smartwatch_zdkdjm.jpg', '2025-03-19 10:30:00'),
(1, 'Portable Charger', '10000mAh portable power bank. Charge your devices on the go with fast charging technology.', 29.99, 40, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/portable_charger_hgcgxj.jpg', '2025-03-19 11:00:00'),
(1, 'Bluetooth Speaker', 'Waterproof bluetooth speaker with 24-hour battery life and crystal clear sound. Perfect for outdoor adventures.', 79.99, 20, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/bluetooth_speaker_k0hjaq.jpg', '2025-03-19 11:30:00'),

-- Fashion Hub products (shop_id 2)
(2, 'Casual T-Shirt', 'Comfortable cotton t-shirt available in various colors. A versatile addition to any wardrobe.', 19.99, 50, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/casual_tshirt_c4ozzr.jpg', '2025-03-20 09:00:00'),
(2, 'Denim Jeans', 'Classic denim jeans with a modern fit. Durable and stylish for everyday wear.', 59.99, 30, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/denim_jeans_hl3nh5.jpg', '2025-03-20 09:30:00'),
(2, 'Leather Wallet', 'Genuine leather wallet with multiple card slots and a coin pocket. Elegant and functional.', 39.99, 25, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/leather_wallet_w8pfpa.jpg', '2025-03-20 10:00:00'),
(2, 'Sunglasses', 'UV-protected sunglasses with a stylish frame. Perfect for sunny days and beach outings.', 24.99, 35, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/sunglasses_vddbhs.jpg', '2025-03-20 10:30:00'),

-- Home & Garden products (shop_id 3)
(3, 'Indoor Plant Set', 'Set of 3 easy-care indoor plants in decorative pots. Perfect for adding greenery to your home or office.', 49.99, 15, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/plant_set_qoytlv.jpg', '2025-03-21 09:00:00'),
(3, 'Throw Pillow Covers', 'Set of 4 decorative throw pillow covers in complementary colors. Made from soft, durable fabric.', 34.99, 20, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/throw_pillows_iohbri.jpg', '2025-03-21 09:30:00'),
(3, 'Table Lamp', 'Modern table lamp with adjustable brightness. Perfect for bedside tables or office desks.', 44.99, 10, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/table_lamp_mywcqf.jpg', '2025-03-21 10:00:00'),
(3, 'Garden Tool Set', 'Complete set of essential garden tools. Includes trowel, pruners, garden fork, and weeder.', 39.99, 25, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/garden_tools_v59zoe.jpg', '2025-03-21 10:30:00'),

-- Bookworm Paradise products (shop_id 4)
(4, 'Fiction Best Sellers Bundle', 'Collection of 5 current fiction best sellers. Perfect for avid readers or as a gift.', 89.99, 10, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/book_bundle_mstgjj.jpg', '2025-03-22 09:00:00'),
(4, 'Hardcover Classics Set', 'Beautiful hardcover editions of 3 literary classics. Includes Pride and Prejudice, Jane Eyre, and Wuthering Heights.', 69.99, 15, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/classics_set_r6v0ph.jpg', '2025-03-22 09:30:00'),
(4, 'Reading Light', 'Clip-on reading light with adjustable brightness levels. Perfect for night-time reading.', 14.99, 30, 'https://res.cloudinary.com/paliyo/image/upload/v1713465628/products/reading_light_qjdxel.jpg', '2025-03-22 10:00:00'),
(4, 'Leather Bookmark Set', 'Set of 5 handcrafted leather bookmarks in various colors. A stylish way to mark your page.', 19.99, 40, 'https://res.cloudinary.com/paliyo/image/upload/v1713465627/products/bookmarks_v4dkf1.jpg', '2025-03-22 10:30:00');

-- Add some orders
INSERT INTO `orders` (`customer_id`, `total_price`, `status`, `created_at`) VALUES
(1, 179.97, 'confirmed', '2025-04-01 14:32:17'),
(3, 159.98, 'confirmed', '2025-04-02 10:45:22'),
(4, 274.95, 'confirmed', '2025-04-03 16:18:43'),
(1, 89.98, 'cancelled', '2025-04-04 09:20:15');

-- Add order items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
-- Order 1 items (customer 1)
(1, 1, 1, 49.99, 49.99),
(1, 3, 1, 29.99, 29.99),
(1, 4, 1, 79.99, 79.99),

-- Order 2 items (customer 3)
(2, 5, 2, 19.99, 39.98),
(2, 8, 1, 24.99, 24.99),
(2, 15, 1, 14.99, 14.99),
(2, 7, 2, 39.99, 79.98),

-- Order 3 items (customer 4)
(3, 2, 1, 129.99, 129.99),
(3, 9, 1, 49.99, 49.99),
(3, 13, 1, 69.99, 69.99),
(3, 11, 1, 44.99, 44.99),

-- Order 4 items (customer 1 - cancelled)
(4, 11, 2, 44.99, 89.98);

-- Update product stock to reflect orders
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 1;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 2;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 3;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 4;
UPDATE `products` SET `stock` = `stock` - 2 WHERE `product_id` = 5;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 7;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 8;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 9;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 11;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 15;
UPDATE `products` SET `stock` = `stock` - 1 WHERE `product_id` = 17;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_shop_fk` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
