-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2024 at 04:22 PM
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
-- Database: `css_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '1= admin, 2= staff',
  `ticket_id` int(30) NOT NULL,
  `solution` text NOT NULL,
  `time_finished` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `user_type`, `ticket_id`, `solution`, `time_finished`) VALUES
(1, 1, 1, 1, '&lt;p&gt;Sample Comment only&lt;/p&gt; ', '2020-11-09 07:52:16'),
(3, 2, 3, 1, '&lt;p&gt;Sample&amp;nbsp;&lt;/p&gt;', '2020-11-09 08:36:56'),
(6, 13, 3, 5, '<p>don</p>', '2024-06-05 09:15:57'),
(7, 13, 3, 4, '<p>p</p>', '2024-06-05 10:38:39'),
(8, 13, 3, 7, '<p>jw</p>', '2024-06-05 11:54:57'),
(9, 13, 3, 7, '<p>kfgv</p>', '2024-06-05 14:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `middlename`, `contact`, `address`, `email`, `password`, `date_created`) VALUES
(5, 'farrel', 'lazuardi', 'shidqi', '08577658', 'bekasi', 'farrel@gmail.com', '4297f44b13955235245b2497399d7a93', '2024-05-30 00:29:37'),
(7, 'danish', 'k', 'z', '08490452', 'pwk', 'danish@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-06-04 01:21:04'),
(8, '', '', '', '', '', '', '', '2024-06-05 01:54:43'),
(9, 'aslam', 'm', 's', '', '', 'aslam', '202cb962ac59075b964b07152d234b70', '2024-06-05 01:55:03'),
(10, 'rey', 'w', 't', '0932487', 'kjawhofe', 'rey@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-06-05 18:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `table_id` int(11) DEFAULT NULL,
  `role` enum('Customer Service','Manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `department_id`, `firstname`, `lastname`, `middlename`, `contact`, `address`, `email`, `password`, `date_created`, `table_id`, `role`) VALUES
(9, 0, 'diw', 'andhika', 'a', '0812345', 'Mars', 'diwa@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', '2024-06-02 08:06:37', 6, 'Customer Service'),
(10, 0, 'aisyah', 'fatah', 'faradilah', '0123456', 'jaksel', 'aisyah@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-06-02 08:08:32', 0, 'Manager'),
(11, 0, 'abdul', 'f', 'r', '735632451', 'pwk', 'abdul@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', '2024-06-04 01:21:32', 6, 'Customer Service'),
(12, 0, 'aslam', 'm', 's', '1923471', 'pwk', 'aslam@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-06-04 01:30:27', 0, 'Manager'),
(13, 0, 'encore', 'y', 's', '01928412', 'wuwa', 'encore@gmail.com', '202cb962ac59075b964b07152d234b70', '2024-06-05 13:34:19', 5, 'Customer Service');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(30) NOT NULL,
  `code` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=empty,1=filled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `code`, `status`) VALUES
(4, '1A', 1),
(5, '1B', 0),
(6, '1C', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(30) NOT NULL,
  `subject` text NOT NULL,
  `problem` text NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=Pending,1=on process,2= Closed',
  `department_id` int(30) NOT NULL,
  `customer_id` int(30) NOT NULL,
  `staff_id` int(30) NOT NULL,
  `admin_id` int(30) NOT NULL,
  `time_begin` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `subject`, `problem`, `status`, `department_id`, `customer_id`, `staff_id`, `admin_id`, `time_begin`) VALUES
(3, 'id', '<p>asdfw</p>', 2, 4, 7, 0, 0, '2024-05-29 17:47:38'),
(4, 'sdae', '<p>SASd</p>', 2, 0, 7, 0, 0, '2024-06-05 05:11:24'),
(5, 'fasew', '<p>awefdaw</p>', 0, 0, 5, 0, 0, '2024-06-05 06:11:57'),
(7, 'ak mw crt', '<p>awokokaw</p>', 1, 0, 10, 0, 0, '2024-06-05 11:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `role` tinyint(1) NOT NULL COMMENT '1 = Admin,2=Pemimpin,3=Operator',
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `role`, `username`, `password`, `date_created`) VALUES
(1, 'Administrator', '', '', 1, 'admin', '0192023a7bbd73250516f069df18b500', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
