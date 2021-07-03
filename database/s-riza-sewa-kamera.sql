-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Jul 2021 pada 12.10
-- Versi server: 5.7.24
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s-riza-sewa-kamera`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category_items`
--

CREATE TABLE `category_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `category_items`
--

INSERT INTO `category_items` (`id`, `category_name`) VALUES
(1, 'Kamera'),
(2, 'Aksesoris'),
(3, 'Lainya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cust_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `cust_name`, `cust_address`, `cust_phone`) VALUES
(1, 2, 'Budi Nuryanto', 'Kudus', '081234567789'),
(2, 3, 'Ahmad Zainudin', 'Kudus', '081234567789'),
(3, 3, 'Maman Sulaiman', 'Kudus', '081234567789'),
(4, 7, 'Yani Ahmadi', 'Pati', '086554434567'),
(5, 9, 'Yani Ahmadi', 'Pati', '086554434567'),
(6, 10, 'Amriza', 'Kudus', '085714566765');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_stock` int(11) NOT NULL,
  `item_price` int(11) NOT NULL,
  `item_img` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `category_id`, `item_name`, `item_stock`, `item_price`, `item_img`) VALUES
(1, 1, 'Canon 60D', 4, 120000, 'ITEMS_1624422329.jpg'),
(2, 1, 'Nikon D3100', 2, 100000, 'ITEMS_1622036498.jpg'),
(3, 1, 'Sony A6000', 3, 100000, 'ITEMS_1622036572.jpg'),
(4, 1, 'Lumix DMC LX-100', 2, 150000, 'ITEMS_1624422855.jpg'),
(5, 2, 'Tas Kamera', 3, 30000, 'ITEMS_1624422899.jpg'),
(6, 2, 'Tripod Velbon Ultrek UT-53D', 2, 15000, 'ITEMS_1624422932.jpg'),
(7, 2, 'Tripod MeFoto Roadtrip Air', 3, 13500, 'ITEMS_1624422963.jpg'),
(8, 2, 'Flash Yongnuo YN-660', 4, 17000, 'ITEMS_1624423005.jpg'),
(9, 1, 'Canon EOS M10', 1, 120000, 'ITEMS_1624423179.jpg'),
(10, 1, 'Nikon Z50', 1, 120000, 'ITEMS_1624423231.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2021_05_05_042740_create_customers_table', 1),
(9, '2021_05_05_053154_create_category_items_table', 1),
(10, '2021_05_05_053251_create_items_table', 1),
(11, '2021_05_05_053303_create_rents_table', 1),
(12, '2021_05_05_053317_create_rent_details_table', 1),
(13, '2021_05_22_030158_add_items_img_to_items_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rents`
--

CREATE TABLE `rents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_datetime` datetime NOT NULL,
  `payment_datetime` datetime DEFAULT NULL,
  `rent_datetime_start` datetime NOT NULL,
  `rent_datetime_end` datetime NOT NULL,
  `return_datetime` datetime DEFAULT NULL,
  `payment_status` enum('Belum Dibayar','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rents`
--

INSERT INTO `rents` (`id`, `cust_id`, `invoice_number`, `book_datetime`, `payment_datetime`, `rent_datetime_start`, `rent_datetime_end`, `return_datetime`, `payment_status`, `payment_file`) VALUES
(16, 1, '#RCM-20210701221315', '2021-07-01 22:13:15', '2021-07-02 23:19:14', '2021-07-02 00:00:00', '2021-07-05 00:00:00', '2021-07-03 17:33:25', 'Lunas', 'PAYMENTS_1625242754.jpg'),
(17, 1, '#RCM-20210702164821', '2021-07-02 16:48:21', '2021-07-03 16:50:52', '2021-07-02 16:46:33', '2021-07-03 16:46:33', '2021-07-03 17:59:17', 'Lunas', 'PAYMENTS_1625305851.jpg'),
(18, 1, '#RCM-20210703122405', '2021-07-03 12:24:05', '2021-07-03 16:49:33', '2021-07-07 00:00:00', '2021-07-10 00:00:00', NULL, 'Lunas', 'PAYMENTS_1625305773.jpg'),
(19, 1, '#RCM-20210703122840', '2021-07-03 12:28:40', NULL, '2021-07-11 00:00:00', '2021-07-15 00:00:00', NULL, 'Belum Dibayar', NULL),
(20, 2, '#RCM-20210703181659', '2021-07-03 18:16:59', '2021-07-03 18:17:37', '2021-07-05 00:00:00', '2021-07-07 00:00:00', NULL, 'Belum Dibayar', 'PAYMENTS_1625311057.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rent_details`
--

CREATE TABLE `rent_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rent_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_qty` int(11) NOT NULL,
  `rent_item_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rent_details`
--

INSERT INTO `rent_details` (`id`, `rent_id`, `item_id`, `item_qty`, `rent_item_price`) VALUES
(13, 16, 1, 3, 260000),
(14, 16, 3, 1, 100000),
(15, 16, 5, 1, 30000),
(16, 17, 2, 1, 100000),
(17, 17, 8, 1, 17000),
(18, 18, 10, 1, 120000),
(19, 18, 1, 1, 120000),
(20, 18, 5, 1, 30000),
(21, 18, 8, 1, 17000),
(22, 19, 4, 1, 600000),
(23, 19, 5, 2, 240000),
(24, 19, 6, 2, 120000),
(25, 19, 9, 1, 480000),
(26, 19, 8, 2, 136000),
(27, 20, 10, 1, 240000),
(28, 20, 8, 1, 34000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `roles`) VALUES
(1, 'admin', '$2y$10$ijezbD2ipJCigxM70Pum6uROcf8MB46MXiNyL9kgGxIqt26eCCEkG', 'admin'),
(2, 'budi', '$2y$10$ixJTuaSfxB1IKaCH7oYn7.rFRSZ4uQzsFGgnDe.5.nSmrbH.UWEGG', 'user'),
(3, 'ahmad', '$2y$10$QT5G4PAqz3gT/TZmMOzs7usURX6n3WgVYVRYfF.h9lbPzepz5Dt0q', 'user'),
(4, 'mamad', '$2y$10$4uRPZjx40y5vxlCaoccLIezxoMo/q/uPf6IbVIQXqYpZ7G1vTFoI2', 'user'),
(7, 'yani', '$2y$10$MvBm3VcUY50ZhyUZ9ZsrGedKbxUoSmTQ8P9HR6s1W/Ixj/XVccWXm', 'user'),
(9, 'yanis', '$2y$10$y.dNDwCM5xogmOkvYgbB/.OTR9qNMwoyUayF1fC8SJyRW5bpiaDOe', 'user'),
(10, 'amriza', '$2y$10$aCHfUgngWf9awaS8yW7K2ewB.ck6hAh0wh9K3VMmU4ISdAcnQ63Ha', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category_items`
--
ALTER TABLE `category_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rents_invoice_number_unique` (`invoice_number`),
  ADD KEY `rents_cust_id_foreign` (`cust_id`);

--
-- Indeks untuk tabel `rent_details`
--
ALTER TABLE `rent_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rent_details_rent_id_foreign` (`rent_id`),
  ADD KEY `rent_details_item_id_foreign` (`item_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category_items`
--
ALTER TABLE `category_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `rents`
--
ALTER TABLE `rents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `rent_details`
--
ALTER TABLE `rent_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_items` (`id`);

--
-- Ketidakleluasaan untuk tabel `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `rents_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`id`);

--
-- Ketidakleluasaan untuk tabel `rent_details`
--
ALTER TABLE `rent_details`
  ADD CONSTRAINT `rent_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `rent_details_rent_id_foreign` FOREIGN KEY (`rent_id`) REFERENCES `rents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
