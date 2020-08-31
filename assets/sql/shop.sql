-- -------------------------------------------------------------
-- TablePlus 2.8.2(256)
--
-- https://tableplus.com/
--
-- Database: shop
-- Generation Time: 2020-08-31 14:18:39.5240
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `t_api_users`;
CREATE TABLE `t_api_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t_cart`;
CREATE TABLE `t_cart` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cart_json` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t_checkout`;
CREATE TABLE `t_checkout` (
  `id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `t_order`;
CREATE TABLE `t_order` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1= Received, 2 = Processing, 3 = Cancelled',
  `date_purchased` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t_order_product`;
CREATE TABLE `t_order_product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t_transaction`;
CREATE TABLE `t_transaction` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_id` int NOT NULL,
  `transaction_token` varchar(100) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `t_api_users` (`id`, `user_name`, `password`, `status`, `created_at`) VALUES ('1', 'app', 'e610783ad69483fac26dce8f6b3afcc1', '1', '2020-08-27 10:27:43');

INSERT INTO `t_cart` (`id`, `cart_id`, `created_at`, `cart_json`) VALUES ('1', 'a4cde56a-2e71-42ab-a458-b52dc81b0fdd', '2020-08-30 15:51:02', '{\"type\": \"shoppingcart\",\"shoppingcartid\": \"a4cde56a-2e71-42ab-a458-b52dc81b0fdd\",\"products\":[{ \"productid\": \"21291d4d-6199-45eb-8549-e941813752f8\",\"title\": \"Product 1\",\"price\": \"10.99\",\"amount\": 1,\"image\": \"https://picsum.photos/200\"},{ \"productid\": \"f05f4a23-10a1-4f39-a959-bfcbfaa613a3\",\"title\": \"Product 2\",\"price\": \"200.99\",\"amount\": 1,\"image\": \"https://picsum.photos/200\"}],\n\"sum\": \"211.98\",\n\"vatPercent\": \"19%\",\n\"vatSum\": \"49,19\",\n\"deliveryCosts\": \"4.99\",\n\"totalSum\": \"266.16\",\n\"currency\": \"EUR\"\n}');

INSERT INTO `t_order` (`id`, `customer_id`, `status`, `date_purchased`) VALUES ('5', '1', '1', '2020-08-31 14:00:02'),
('6', '1', '1', '2020-08-31 14:16:59');

INSERT INTO `t_order_product` (`id`, `order_id`, `customer_id`, `product_id`, `quantity`, `price`) VALUES ('1', '6', '1', '21291d4d-6199-45eb-8549-e941813752f8', '1', '10.99'),
('2', '6', '1', 'f05f4a23-10a1-4f39-a959-bfcbfaa613a3', '1', '200.99');

INSERT INTO `t_transaction` (`id`, `customer_id`, `order_id`, `transaction_token`, `payment_type`, `amount`, `created_at`) VALUES ('5', '1', '5', 'b5671411d2b4617b56847ec3ad2fe535', 'Direct Debit', '266.16', '2020-08-31 14:00:02'),
('6', '1', '6', 'd9251139a928cf65b7b01f7319fd6d91', 'Direct Debit', '266.16', '2020-08-31 14:16:59');




/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;