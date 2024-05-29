-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 09:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugas_akhir_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `no_telp` varchar(191) DEFAULT NULL,
  `level` enum('Admin','Staff') NOT NULL,
  `is_ban` tinyint(1) NOT NULL COMMENT '0=not_ban, 1=ban',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`, `no_telp`, `level`, `is_ban`, `created_at`) VALUES
(18, 'rajan', 'rajan@gmail.com', '$2y$10$Y0Q8fGuMfs6iigj2F9Dj7OUaKLUZDN3f9QUuIYBvfviC90i3mQ//C', '081211846570', 'Admin', 0, '2024-05-04'),
(19, 'rajan1', 'rajan1@gmail.com', '$2y$10$x3seyIYd8IJFWrJM.kfvCu23wBb6HhpjZ/9yOCIDTl5B8oG46YI.q', '081318701223', 'Staff', 0, '2024-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=visible, 1=hidden'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`) VALUES
(9, 'Minuman', 'Penyegar', 0),
(10, 'Cemilan', 'Penyegar', 0),
(11, 'Makanan', 'makanan berat\r\n', 0),
(12, 'Elektronik', '', 0),
(13, 'Bumbu Masakan', '', 0),
(14, 'Perawatan', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=visible, 1=hidden',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `payment_mode` varchar(100) NOT NULL COMMENT 'cash, online',
  `money` int(100) NOT NULL,
  `order_placed_by_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `order_date`, `order_status`, `payment_mode`, `money`, `order_placed_by_id`) VALUES
(31, 12, '26486', 'INV-447554', '1260000', '2024-05-10', 'booked', 'Online Payment', 0, 15),
(32, 12, '27536', 'INV-545553', '232700', '2024-05-11', 'booked', 'Cash Payment', 0, 15),
(33, 12, '21041', 'INV-646561', '3960000', '2024-05-11', 'booked', 'Cash Payment', 0, 15),
(34, 12, '42138', 'INV-305744', '257000', '2024-05-11', 'booked', 'Online Payment', 0, 15),
(35, 14, '55790', 'INV-504080', '73000', '2024-05-12', 'booked', 'Online Payment', 0, 15),
(36, 14, '57090', 'INV-230411', '169900', '2024-05-14', 'booked', 'Cash Payment', 0, 15),
(37, 12, '64496', 'INV-237060', '206000', '2024-05-15', 'booked', 'Cash Payment', 0, 15),
(38, 12, '49769', 'INV-323953', '3690000', '2024-05-16', 'booked', 'Cash Payment', 0, 19),
(39, 12, '27904', 'INV-646115', '1654000', '2024-05-17', 'booked', 'Cash Payment', 0, 19),
(40, 12, '65896', 'INV-221439', '454000', '2024-05-18', 'booked', 'Cash Payment', 0, 19),
(41, 12, '52292', 'INV-246681', '10000', '2024-05-18', 'booked', 'Cash Payment', 0, 19),
(42, 12, '46267', 'INV-453540', '12000', '2024-05-19', 'booked', 'Online Payment', 0, 19),
(43, 0, '34499', 'INV-251180', '172500', '2024-05-26', 'booked', 'Cash Payment', 200000, 19),
(63, 0, '83620', 'INV-807517', '90000', '2024-05-26', 'booked', 'Cash Payment', 11111111, 19),
(99, 0, '28479', 'INV-718247', '103500', '2024-05-26', 'booked', 'Cash Payment', 200000, 19);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`, `order_date`) VALUES
(37, 31, 15, '90000', '14', '2024-05-12'),
(38, 32, 22, '4000', '10', '2024-05-12'),
(39, 32, 20, '8000', '3', '2024-05-12'),
(40, 32, 17, '5000', '2', '2024-05-12'),
(41, 32, 23, '5000', '5', '2024-05-12'),
(42, 32, 18, '3000', '6', '2024-05-12'),
(43, 32, 25, '8900', '13', '2024-05-12'),
(44, 33, 15, '90000', '44', '2024-05-12'),
(45, 34, 21, '5000', '1', '2024-05-11'),
(46, 34, 18, '3000', '8', '2024-05-11'),
(47, 34, 16, '12000', '19', '2024-05-11'),
(48, 35, 22, '4000', '16', '2024-05-12'),
(49, 35, 18, '3000', '3', '2024-05-12'),
(50, 36, 19, '12000', '8', '2024-05-14'),
(51, 36, 23, '5000', '1', '2024-05-14'),
(52, 36, 26, '11500', '2', '2024-05-14'),
(53, 36, 18, '3000', '1', '2024-05-14'),
(54, 36, 24, '5000', '2', '2024-05-14'),
(55, 36, 16, '12000', '2', '2024-05-14'),
(56, 36, 25, '8900', '1', '2024-05-14'),
(57, 37, 19, '12000', '6', '2024-05-15'),
(58, 37, 16, '12000', '2', '2024-05-15'),
(59, 37, 18, '3000', '1', '2024-05-15'),
(60, 37, 22, '4000', '1', '2024-05-15'),
(61, 37, 20, '8000', '1', '2024-05-15'),
(62, 37, 15, '90000', '1', '2024-05-15'),
(63, 37, 17, '5000', '1', '2024-05-15'),
(64, 38, 15, '90000', '41', '2024-05-16'),
(65, 39, 33, '300000', '5', '2024-05-17'),
(66, 39, 34, '77000', '2', '2024-05-17'),
(67, 40, 34, '77000', '2', '2024-05-18'),
(68, 40, 33, '300000', '1', '2024-05-18'),
(69, 41, 37, '500', '4', '2024-05-18'),
(70, 41, 35, '2000', '3', '2024-05-18'),
(71, 41, 36, '1000', '2', '2024-05-18'),
(72, 42, 16, '12000', '1', '2024-05-19'),
(73, 43, 24, '5000', '1', '2024-05-26'),
(74, 43, 34, '77000', '1', '2024-05-26'),
(75, 43, 37, '500', '1', '2024-05-26'),
(76, 43, 15, '90000', '1', '2024-05-26'),
(77, 63, 15, '90000', '1', '2024-05-26'),
(78, 87, 16, '12000', '1', '2024-05-26'),
(79, 87, 15, '90000', '1', '2024-05-26'),
(80, 95, 15, '90000', '1', '2024-05-26'),
(81, 95, 16, '12000', '1', '2024-05-26'),
(82, 98, 15, '90000', '1', '2024-05-26'),
(83, 99, 16, '12000', '1', '2024-05-26'),
(84, 99, 15, '90000', '1', '2024-05-26'),
(85, 99, 36, '1000', '1', '2024-05-26'),
(86, 99, 37, '500', '1', '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=visible, 1=hidden',
  `product_code` varchar(50) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `quantity`, `image`, `status`, `product_code`, `created_at`) VALUES
(15, 11, 'Ayam Goreng', '', 90000, 396, 'assets/uploads/products/1714639339.jpg', 0, 'A0001', '2024-05-02'),
(16, 10, 'Chitato', 'cikiiiiii', 12000, 950, 'assets/uploads/products/1714886922.jpeg', 0, 'A0002', '2024-05-05'),
(17, 9, 'Coca - Cola', 'Penyegar', 5000, 50, 'assets/uploads/products/1715233769.png', 0, 'A0003', '2024-05-09'),
(18, 10, 'Sukro', 'Kacang Enak', 3000, 4, 'assets/uploads/products/1715233859.png', 0, 'A0004', '2024-05-09'),
(19, 10, 'Cheetos', 'Kripik Panggang', 12000, 16, 'assets/uploads/products/1715233946.png', 0, 'A0005', '2024-05-09'),
(20, 10, 'Sosis sonice', 'Sosis gede', 8000, 53, 'assets/uploads/products/1715234042.png', 0, 'A0006', '2024-05-09'),
(21, 9, 'Sprite', 'Penyegar', 5000, 0, 'assets/uploads/products/1715234539.png', 0, 'A0007', '2024-05-09'),
(22, 9, 'Milku Coklat', 'Penyegar', 4000, 0, 'assets/uploads/products/1715234634.png', 0, 'A0008', '2024-05-09'),
(23, 9, 'Le Minerale', 'Ada manis-manisnya', 5000, 0, 'assets/uploads/products/1715234771.png', 0, 'A0009', '2024-05-09'),
(24, 9, 'Fanta', 'Fantaa bosku', 5000, 0, 'assets/uploads/products/1715236479.png', 0, 'A0010', '2024-05-09'),
(25, 10, 'Boncabe', 'pedas', 8900, 36, 'assets/uploads/products/1715236549.png', 0, 'A0011', '2024-05-09'),
(26, 10, 'Piattos', 'Enak', 11500, 18, 'assets/uploads/products/1715236638.png', 0, 'A0012', '2024-05-09'),
(27, 0, 'Tic Tac', 'Snack Bulat', 1000, 100, 'assets/uploads/products/1715705298.jpg', 0, '8888166991484', '2024-05-13'),
(31, 10, 'Saltcheese', 'Wafer Keju', 10000, 1000, 'assets/uploads/products/1715927054.webp', 0, '8888166321106', '2024-05-17'),
(32, 13, 'Me Leuris', 'Bumbu Mcrini', 18999, 59, 'assets/uploads/products/1715928293.png', 0, '8997024460687', '2024-05-17'),
(33, 12, 'TWS Soundcore R50i', 'Earphone Bluetooth', 300000, 94, 'assets/uploads/products/1715944462.webp', 0, '194644125691', '2024-05-17'),
(34, 14, 'Kahf | True Brotherhood', 'Parfume Premium', 77000, 95, 'assets/uploads/products/1715962396.jpg', 0, '8993137710459', '2024-05-17'),
(35, 10, 'Beng Beng', 'Snack Coklat Dengan Wafer', 2000, 97, 'assets/uploads/products/1716031203.jpeg', 0, '8996001354124', '2024-05-18'),
(36, 10, 'Tricks Kimchi', 'Kentang Panggang', 1000, 97, 'assets/uploads/products/1716031297.webp', 0, '8994391136177', '2024-05-18'),
(37, 10, 'Kacang Atom Garuda', 'Kacang Panggang', 500, 94, 'assets/uploads/products/1716031379.jpg', 0, '8992775214008', '2024-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
