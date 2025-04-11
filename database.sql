
-- Dumping database structure for web_shop
DROP DATABASE IF EXISTS `web_shop`;
CREATE DATABASE IF NOT EXISTS `web_shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `web_shop`;

-- Dumping structure for table web_shop.cart
DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_shop.cart: ~0 rows (approximately)
INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
	(30, 1, 2, 1);

-- Dumping structure for table web_shop.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_shop.orders: ~7 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `total`, `order_date`) VALUES
	(1, 1, 840.00, '2025-04-11 13:42:57'),
	(2, 1, 350.00, '2025-04-11 13:47:26'),
	(3, 1, 320.00, '2025-04-11 13:49:07'),
	(4, 1, 320.00, '2025-04-11 13:49:12'),
	(5, 8, 640.00, '2025-04-11 15:02:26'),
	(6, 8, 2080.00, '2025-04-11 15:02:47'),
	(7, 8, 1020.00, '2025-04-11 15:25:05');

-- Dumping structure for table web_shop.order_items
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_shop.order_items: ~11 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 1, 1, 450.00),
	(2, 1, 4, 1, 390.00),
	(3, 2, 2, 1, 350.00),
	(4, 3, 3, 1, 320.00),
	(5, 4, 3, 1, 320.00),
	(6, 5, 3, 2, 320.00),
	(7, 6, 3, 4, 320.00),
	(8, 6, 2, 1, 350.00),
	(9, 6, 1, 1, 450.00),
	(10, 7, 2, 2, 350.00),
	(11, 7, 3, 1, 320.00);

-- Dumping structure for table web_shop.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_shop.products: ~6 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `image`) VALUES
	(1, 'ผ้าไหมลายไทย', 'ผ้าไหมแท้จากขอนแก่น ลวดลายโบราณสวยงาม', 450.00, 8, 'istockphoto-2173982134-2048x2048.jpg'),
	(2, 'ผ้าฝ้ายทอมือ', 'ผ้าฝ้ายธรรมชาติ สีสันอ่อนโยน เหมาะทำเสื้อผ้า', 350.00, 16, 'istockphoto-1206937962-2048x2048.jpg'),
	(3, 'ผ้าลินินพรีเมียม', 'ผ้าลินินนำเข้า นุ่ม เบา ระบายอากาศดี', 320.00, 6, 'istockphoto-2173982134-2048x2048.jpg'),
	(4, 'ผ้ายีนส์เนื้อหนา', 'เหมาะสำหรับทำกางเกง หรือกระเป๋าผ้า', 390.00, 7, 'istockphoto-1206937962-2048x2048.jpg'),
	(5, 'ผ้าลูกไม้แฟชั่น', 'ผ้าสำหรับตัดชุดออกงานหรูหรา', 550.00, 5, 'istockphoto-1278802435-612x612.jpg'),
	(6, 'ฟหก', 'ฟหก', 200.00, 5, 'istockphoto-1278802435-612x612.jpg');

-- Dumping structure for table web_shop.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','seller') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_shop.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
	(1, 'aaa', '', '$2y$10$9PLaIEU8W57mtZwJ1e2q5uWGY6zRhnUEJ/QZuwDGl4VcM12J2ZSd2', 'customer'),
	(2, 'customer1', '', '$2y$10$9PLaIEU8W57mtZwJ1e2q5uWGY6zRhnUEJ/QZuwDGl4VcM12J2ZSd2', 'customer'),
	(3, 'customer2', '', '$2y$10$9PLaIEU8W57mtZwJ1e2q5uWGY6zRhnUEJ/QZuwDGl4VcM12J2ZSd2', 'customer'),
	(4, 'seller1', 'test1234@gmail.com', '$2y$10$QnOMmhLngODTLosiA2ybtOJMDhtPBEnfkI6e1Bi/9HHO8m36FYmOS', 'seller'),
	(5, 'seller2', '', '$2y$10$9PLaIEU8W57mtZwJ1e2q5uWGY6zRhnUEJ/QZuwDGl4VcM12J2ZSd2', 'seller'),
	(6, 'aaa2', 'aaa2@gmail.com', '$2y$10$oirgW7QWya9g0YOVi4XvJuJwudM91REotfzpHsqoAzDZJGLNVFRkq', 'customer'),
	(8, 'aaa3', 'aaa3@gmail.com', '$2y$10$.xq1EcIWDZ0g11tTUyNqXex6umD3CYw.F46oiVdEtfL1u1PExDPiq', 'customer');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
