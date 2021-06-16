-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 09, 2021 lúc 02:17 AM
-- Phiên bản máy phục vụ: 10.4.18-MariaDB
-- Phiên bản PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thuenha`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `user_id` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf16_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf16_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`user_id`, `fullname`, `username`, `password`, `mobile`, `email`, `role`) VALUES
('nscgq000yqta5u9zkvxk', 'Nguyễn Ngọc Trinh', 'trinhnn', '6df73cc169278dd6daab5fe7d6cacb1fed537131', '0868894228', 'trinhnn040999@gmail.com', 'Role_Tenant'),
('nvjs6vwgvvomhvnhl8ci', 'Minh Luong', 'lvminh', '6df73cc169278dd6daab5fe7d6cacb1fed537131', '0968401809', 'lvminh97@gmail.com', 'Role_Host');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `time` date NOT NULL,
  `status` varchar(20) COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill_detail`
--

CREATE TABLE `bill_detail` (
  `bill_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `author` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `title` varchar(300) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `content` text CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `room_id` int(11) NOT NULL,
  `approval` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rent`
--

CREATE TABLE `rent` (
  `rent_id` int(11) NOT NULL,
  `user_id` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `room_id` int(11) NOT NULL,
  `begin_time` date NOT NULL,
  `end_time` date NOT NULL,
  `status` varchar(50) COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rent`
--

INSERT INTO `rent` (`rent_id`, `user_id`, `room_id`, `begin_time`, `end_time`, `status`) VALUES
(1, 'nscgq000yqta5u9zkvxk', 9, '0000-00-00', '9999-12-31', 'pending');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `host` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf16_unicode_ci NOT NULL,
  `images` text COLLATE utf16_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `loc_number` varchar(10) COLLATE utf16_unicode_ci NOT NULL,
  `loc_alley` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `loc_street` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `loc_subdistrict` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `loc_district` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `loc_province` varchar(100) COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`room_id`, `host`, `name`, `images`, `price`, `area`, `loc_number`, `loc_alley`, `loc_street`, `loc_subdistrict`, `loc_district`, `loc_province`) VALUES
(9, 'nvjs6vwgvvomhvnhl8ci', 'Phòng 1', 'SRC.jpg;SET_LOGO.jpg', 1100000, 8, '35', '176', 'LTT', 'KM', 'TX', 'HN'),
(10, 'nvjs6vwgvvomhvnhl8ci', 'Phòng 2', '12994418_625092614313110_5041575465738166699_n.jpg', 1500000, 11, '35', '176', 'LTT', 'KM', 'TX', 'HN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `token`
--

CREATE TABLE `token` (
  `user_id` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `token` varchar(30) COLLATE utf16_unicode_ci NOT NULL,
  `valid_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `token`
--

INSERT INTO `token` (`user_id`, `token`, `valid_time`) VALUES
('nscgq000yqta5u9zkvxk', '9vkf4e8c94021njr0kio05pxqk1fs8', '2021-06-15 18:56:05'),
('nscgq000yqta5u9zkvxk', 'kf42q1bxqna1822uxhfli2zjf6i3mw', '2021-06-04 00:21:02'),
('nvjs6vwgvvomhvnhl8ci', '0jjog2zz5s74700yh38z81gqs97e0n', '2021-05-25 01:01:39'),
('nvjs6vwgvvomhvnhl8ci', '13ftgzxpuy1ocgdzspx1xjgbzgpi5c', '2021-05-15 00:54:58'),
('nvjs6vwgvvomhvnhl8ci', 'ry6aysamtrtnihmt2ggpf6s0zlv79h', '2021-06-08 00:43:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transfer`
--

CREATE TABLE `transfer` (
  `transfer_id` int(11) NOT NULL,
  `tenant` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `host_transfer` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `host_receive` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `room_transfer` int(11) NOT NULL,
  `room_receive` int(11) NOT NULL,
  `status` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `feedback` text CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `user_id` (`room_id`);

--
-- Chỉ mục cho bảng `bill_detail`
--
ALTER TABLE `bill_detail`
  ADD PRIMARY KEY (`bill_id`,`title`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `author` (`author`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `user_id` (`user_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `host` (`host`);

--
-- Chỉ mục cho bảng `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`user_id`,`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `tenant` (`tenant`,`host_transfer`,`host_receive`,`room_transfer`,`room_receive`),
  ADD KEY `host_transfer` (`host_transfer`),
  ADD KEY `host_receive` (`host_receive`),
  ADD KEY `room_transfer` (`room_transfer`),
  ADD KEY `room_receive` (`room_receive`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rent`
--
ALTER TABLE `rent`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `transfer`
--
ALTER TABLE `transfer`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Các ràng buộc cho bảng `bill_detail`
--
ALTER TABLE `bill_detail`
  ADD CONSTRAINT `bill_detail_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Các ràng buộc cho bảng `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Các ràng buộc cho bảng `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`host`) REFERENCES `account` (`user_id`);

--
-- Các ràng buộc cho bảng `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`user_id`);

--
-- Các ràng buộc cho bảng `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_ibfk_1` FOREIGN KEY (`tenant`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`host_transfer`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `transfer_ibfk_3` FOREIGN KEY (`host_receive`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `transfer_ibfk_4` FOREIGN KEY (`room_transfer`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `transfer_ibfk_5` FOREIGN KEY (`room_receive`) REFERENCES `room` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
