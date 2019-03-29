-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2019 at 07:32 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maddox`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `email` varchar(20) NOT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `address` varchar(20) DEFAULT NULL,
  `creditCard` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`email`, `lastName`, `firstName`, `address`, `creditCard`) VALUES
('shopper1@gmail.com', 'Nye', 'Bill', '1234 Science Rd', '1255454345671434'),
('shopper2@gmail.com', 'Bob ', 'Joe', '1441 A Street', '5841948595949444'),
('shopper3@gmail.com', 'French', 'Luke', '1268 rock rd', '4850274817498475'),
('tsmaddox15@gmail.com', 'Maddox', 'Taylor ', '1234 Road rd', '1234123412341234'),
('tsssmaddox15@gmail.c', NULL, NULL, NULL, NULL),
('user1@gmail.com', 'Malott', 'Brad ', '8565 Silver rd', '1048759486481811'),
('user2@gmail.com', 'Hart', 'Kimberly', '1234 Street Rd', '1234123412341234'),
('user3@gmail.com', 'Mosby', 'Ted', '2141 Test rd', '1324134214144444'),
('user5@gmail.com', 'Ketchum', 'Ash', '4231 Pallet Town', '1234123411111111'),
('user7@gmail.com', 'Ross', 'Bob', '4210 Happy ct', '1444244444444444'),
('wsu@wright.edu', 'Maddox', 'Taylor', '4944 ifififif rd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(10) NOT NULL,
  `itemName` varchar(100) DEFAULT NULL,
  `price` decimal(19,2) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemName`, `price`, `category`) VALUES
(1, 'Nestle Purified Water', '3.49', 'beverage'),
(2, 'Meijer Apple Juice', '2.49', 'beverage'),
(3, 'Armour Novara Hard Salami', '9.69', 'deli'),
(4, 'Dietz & Watson Virginia Brand Ham', '8.50', 'deli'),
(5, 'Meijer Milk 2% reduced Fat, Gallon', '1.79', 'd&e'),
(6, 'Doritos Nacho Cheese Party Size', '4.99', 'snack'),
(7, 'Meijer Bread Split Top Wheat', '1.29', 'bakery'),
(8, 'Little Debbie Oatmeal Creme Pies', '1.99', 'snack'),
(9, 'Meijer Corn Whole Kernel Corn ', '0.59', 'can'),
(10, 'Little Debbie Swiss Cake Rolls', '1.99', 'snack'),
(11, 'Sunchips Harvest Cheddar', '3.57', 'snack'),
(12, 'Nabisco Oreo Family Size', '4.09', 'snack'),
(13, 'Nabisco Nutter Butter Cookies', '4.09', 'snack'),
(14, 'Gatorade Frost Glacier Freeze', '6.89', 'beverage'),
(15, 'Meiher Grade A Large Eggs', '0.69', 'd&e'),
(16, 'Kraft Singles American Cheese', '4.69', 'd&e');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderID` int(10) NOT NULL,
  `itemID` int(10) NOT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderID`, `itemID`, `qty`) VALUES
(50, 1, 2),
(50, 2, 2),
(50, 6, 3),
(50, 9, 2),
(50, 14, 2),
(50, 16, 1),
(51, 1, 2),
(51, 6, 2),
(51, 7, 1),
(52, 3, 2),
(52, 10, 5),
(52, 11, 3),
(52, 13, 3),
(52, 14, 3),
(53, 1, 1),
(53, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(10) NOT NULL,
  `email` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT 'o',
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shopper` varchar(20) DEFAULT 'none',
  `orderTotal` decimal(19,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `email`, `status`, `dt`, `shopper`, `orderTotal`) VALUES
(50, 'user7@gmail.com', 'o', '2018-04-16 17:00:12', 'none', '46.58'),
(51, 'shopper1@gmail.com', 'o', '2018-04-16 17:02:28', 'none', '18.25'),
(52, 'tsmaddox15@gmail.com', 'c', '2018-04-16 17:05:54', 'tsmaddox15@gmail.com', '72.98'),
(53, 'wsu@wright.edu', 'o', '2019-03-29 12:32:44', 'none', '13.18');

-- --------------------------------------------------------

--
-- Table structure for table `shoppinglist`
--

CREATE TABLE `shoppinglist` (
  `email` varchar(20) NOT NULL,
  `itemID` int(10) NOT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoppinglist`
--

INSERT INTO `shoppinglist` (`email`, `itemID`, `qty`) VALUES
('tsssmaddox15@gmail.c', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `user_password` varchar(80) NOT NULL,
  `userType` varchar(5) NOT NULL DEFAULT 'c'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `user_password`, `userType`) VALUES
('shopper1@gmail.com', '$2y$10$u6NzOZg2.qeKcUsCCL9oyOd6YohjdMvXmz37vUGgKlHmVxzDAbMTK', 's'),
('shopper2@gmail.com', '$2y$10$kXeNzwpz9sa/xHZYvZfjEOG6UVDFOWsNev6DRyLeAA3HyHYezQDHO', 's'),
('shopper3@gmail.com', '$2y$10$mH3q4zvZZpUOQi.CG01dheC2Un286BdxdWf1Q69x9VirFAp5yw/jW', 's'),
('tsmaddox15@gmail.com', '$2y$10$KnwVLKQqs8vcNyts8ai3OulsrlWPs3N.d2zFI9Yrzr9BPacm4wzei', 'a'),
('tsssmaddox15@gmail.c', '$2y$10$8wZHimvdILI10i06HEPYb.7u/s3wdSrn0TOv7C7mBoFNI8aEd/4SC', 'c'),
('user1@gmail.com', '$2y$10$0GnP72AuKXqa2s1nh5R1SuX4e6y.DuUp9I9FC/E6NnVbmKDG0bW0m', 'c'),
('user2@gmail.com', '$2y$10$b618MnGG/n8hSmRru9qmO.TFU9nFD0Pq2v1.4wKqc4.X9NnGix3dq', 'c'),
('user3@gmail.com', '$2y$10$rdiKRGb8MtGNNG3bJ7yWYOkE62cisl5r.2wfUkI4OGSoug.DvJw3i', 'c'),
('user5@gmail.com', '$2y$10$CWEdg7PY6yVgHV86Ly9.j.KyQRR85PBg4rCDlCHdpBFrlbSfgvZPK', 'c'),
('user7@gmail.com', '$2y$10$iBALxacQv25pL1oOW85dMOg7k/9icl/Ncy.Rie6htCJe3Yvb./ElG', 'c'),
('wsu@wright.edu', '$2y$10$yKD8obiPQBooEGnglFoBYejmJQ1q6rUIsd99zyjbNWzpkBXzfhK8K', 'c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderID`,`itemID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`,`email`,`dt`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD PRIMARY KEY (`email`,`itemID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`username`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`username`);

--
-- Constraints for table `shoppinglist`
--
ALTER TABLE `shoppinglist`
  ADD CONSTRAINT `shoppinglist_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `shoppinglist_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
