-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 08:29 AM
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
(19, 'rajan1', 'rajan1@gmail.com', '$2y$10$x3seyIYd8IJFWrJM.kfvCu23wBb6HhpjZ/9yOCIDTl5B8oG46YI.q', '081318701223', 'Staff', 0, '2024-05-15'),
(20, 'Owner', 'owner@gmail.com', '$2y$10$h4D4dQvReXANaolX91.wF.LHPJDEyVqwEauW6cI3EJikbX0Xx/BJG', '081238920192', 'Admin', 0, '2024-06-04'),
(21, 'Staff', 'staff@gmail.com', '$2y$10$HYXw18jJ.MHv17MNHmMaO.81lqEMCjZZISCXfXCXQ74DqjSGcXUo6', '081829382913', 'Admin', 0, '2024-06-04');

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
(206, 0, '65690', 'INV-283352', '96000', '2024-05-30', 'Dipesan', 'Uang Tunai', 100000, 19),
(207, 0, '93764', 'INV-160871', '12000', '2024-05-30', 'Dipesan', 'Bayar Online', 20000, 19),
(208, 0, '98139', 'INV-839093', '90000', '2024-05-31', 'Dipesan', 'Bayar Online', 100000, 19),
(210, 0, '95870', 'INV-743887', '30000', '2024-06-04', 'Dipesan', 'Uang Tunai', 50000, 18);

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
(119, 201, 39, '4000', '12', '2024-05-31'),
(121, 201, 18, '3000', '1', '2024-05-30'),
(122, 201, 36, '1000', '12', '2024-05-30'),
(130, 209, 18, '3000', '1', '2024-05-31'),
(131, 209, 20, '8000', '1', '2024-05-31'),
(132, 209, 37, '500', '1', '2024-05-31'),
(133, 209, 39, '4000', '1', '2024-05-31'),
(135, 210, 19, '12000', '2', '2024-06-04'),
(136, 210, 36, '1000', '1', '2024-06-04'),
(137, 210, 24, '5000', '1', '2024-06-04');

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
  `image` varchar(255) DEFAULT 'assets/uploads/products/default.jpg',
  `status` tinyint(4) NOT NULL COMMENT '0=visible, 1=hidden',
  `product_code` varchar(50) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `quantity`, `image`, `status`, `product_code`, `created_at`) VALUES
(16, 10, 'Chitato', 'cikiiiiii', 12000, 758, 'assets/uploads/products/1714886922.jpeg', 0, 'A0002', '2024-05-05'),
(18, 10, 'Sukro', 'Kacang Enak', 3000, 7, 'assets/uploads/products/1715233859.png', 0, '8995077604515', '2024-05-09'),
(19, 10, 'Cheetos', 'Kripik Panggang', 12000, 98, 'assets/uploads/products/1715233946.png', 0, 'A0005', '2024-05-09'),
(20, 10, 'Sosis sonice', 'Sosis gede', 8000, 51, 'assets/uploads/products/1715234042.png', 0, 'A0006', '2024-05-09'),
(21, 9, 'Sprite', 'Penyegar', 5000, 0, 'assets/uploads/products/1715234539.png', 0, 'A0007', '2024-05-09'),
(22, 9, 'Milku Coklat', 'Penyegar', 4000, 9, 'assets/uploads/products/1715234634.png', 0, '8998866202725', '2024-05-09'),
(23, 9, 'Le Minerale', 'Ada manis-manisnya', 5000, 10, 'assets/uploads/products/1715234771.png', 0, 'A0009', '2024-05-09'),
(24, 9, 'Fanta', 'Fantaa bosku', 5000, 21, 'assets/uploads/products/1715236479.png', 0, 'A0010', '2024-05-09'),
(25, 10, 'Boncabe', 'pedas', 8900, 36, 'assets/uploads/products/1715236549.png', 0, 'A0011', '2024-05-09'),
(26, 10, 'Piattos', 'Enak', 11500, 18, 'assets/uploads/products/1715236638.png', 0, 'A0012', '2024-05-09'),
(27, 0, 'Tic Tac Jumbo', 'Snack Bulat', 5000, 100, 'assets/uploads/products/1715705298.jpg', 0, '8888166991484', '2024-05-13'),
(31, 10, 'Saltcheese', 'Wafer Keju', 10000, 1000, 'assets/uploads/products/1715927054.webp', 0, '8888166321106', '2024-05-17'),
(32, 13, 'Me Leuris', 'Bumbu Mcrini', 18999, 59, 'assets/uploads/products/1715928293.png', 0, '8997024460687', '2024-05-17'),
(33, 12, 'TWS Soundcore R50i', 'Earphone Bluetooth', 300000, 93, 'assets/uploads/products/1715944462.webp', 0, '194644125691', '2024-05-17'),
(34, 14, 'Kahf | True Brotherhood', 'Parfume Premium', 77000, 94, 'assets/uploads/products/default.jpg', 0, '8993137710459', '2024-05-17'),
(35, 10, 'Beng Beng', 'Snack Coklat Dengan Wafer', 2000, 94, 'assets/uploads/products/1716031203.jpeg', 0, '8996001354124', '2024-05-18'),
(36, 10, 'Tricks Kimchi', 'Kentang Panggang', 1000, 82, 'assets/uploads/products/1716031297.webp', 0, '8994391136177', '2024-05-18'),
(37, 10, 'Kacang Atom Garuda', 'Kacang Panggang', 500, 93, 'assets/uploads/products/1716031379.jpg', 0, '8992775214008', '2024-05-18'),
(39, 10, 'Buku', 'a', 4000, 7, 'assets/uploads/products/1716871234.webp', 0, '8991389230237', '2024-05-28'),
(50, 11, 'asd', 'adw', 12, 12, 'assets/uploads/products/default.jpg', 0, 'awd', '2024-06-07');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
