-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 03:15 AM
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
-- Database: `quran`
--

-- --------------------------------------------------------

--
-- Table structure for table `iqro`
--

CREATE TABLE `iqro` (
  `id_iqro` int(20) NOT NULL,
  `tanggal` date NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_pegawai` int(20) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `halaman` int(5) NOT NULL,
  `awal_ayat` int(5) NOT NULL,
  `akhir_ayat` int(5) NOT NULL,
  `id_ustad` int(20) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iqro`
--

INSERT INTO `iqro` (`id_iqro`, `tanggal`, `nip`, `nama`, `id_pegawai`, `id_unit`, `halaman`, `awal_ayat`, `akhir_ayat`, `id_ustad`, `catatan`) VALUES
(16, '2024-05-07', '22.11.01.2301', 'Akhmad Nafarin, A.Md', 5, 13, 1, 1, 5, 1, 'baik'),
(17, '2024-05-06', '23.01.01.2343', 'Muhammad Rasyad', 2, 13, 1, 1, 4, 3, 'baik'),
(21, '2024-08-04', '20.20.20.2222', 'Aulia Fitri', 32, 2, 1, 1, 5, 1, 'baik');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(20) NOT NULL,
  `stts_jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `stts_jabatan`) VALUES
(2, 'Pegawai'),
(3, 'Pengawas');

-- --------------------------------------------------------

--
-- Table structure for table `juz`
--

CREATE TABLE `juz` (
  `id_juz` int(20) NOT NULL,
  `juz` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `juz`
--

INSERT INTO `juz` (`id_juz`, `juz`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `email`, `password`) VALUES
(1, 'rsi@gmail.com', 'masuk');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(20) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `id_jabatan` int(20) NOT NULL,
  `jk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nip`, `nama`, `id_unit`, `id_jabatan`, `jk`) VALUES
(1, '23.01.01.2342', 'Fajrianur Ramadani', 33, 2, 'Laki-laki'),
(2, '23.01.01.2343', 'Muhammad Rasyad', 33, 2, 'Laki-laki'),
(4, '21.01.01.1912', 'Muhammad Ridha\'an Hanah', 33, 2, 'Laki-laki'),
(5, '22.11.01.2301', 'Akhmad Nafarin, A.Md', 33, 2, 'Laki-laki'),
(8, '23.06.01.2383', 'Dewi Yulia Adiyati', 33, 2, 'Perempuan'),
(9, '23.07.01.2403', 'Mita Sadiya', 33, 2, 'Perempuan'),
(10, '23.03.01.2355', 'Nadia Sarie', 33, 2, 'Perempuan'),
(11, '22.03.01.2151', 'Syr Nurlyla Yusuf', 33, 2, 'Perempuan'),
(12, '22.02.01.2099', 'Tiara Ayu Julia', 33, 2, 'Perempuan'),
(13, '21.01.01.1916', 'Putri Wapa A.Md. Tem', 33, 2, 'Perempuan'),
(14, '22.01.01.2067', 'Ilham Ramaditya, S.Tr.KL.', 33, 2, 'Laki-laki'),
(15, '22.01.01.2060', 'Nurhana Rohadatunnisa, S.Tr.Kes', 33, 2, 'Perempuan'),
(16, '23.03.01.2361', 'Aiman', 33, 2, 'Laki-laki'),
(17, '21.05.01.1988', 'Irpan Paoji Mubarak', 33, 2, 'Laki-laki'),
(18, '22.07.01.2221', 'Muhammad Ismail Akbar', 33, 2, 'Laki-laki'),
(19, '21.06.01.1989', 'Nor Salim', 33, 2, 'Laki-laki'),
(20, '23.04.01.2372', 'Sayyid M. Al Habsyi', 33, 2, 'Laki-laki'),
(21, '23.09.01.2416', 'Aditya Ashar Gunawan', 33, 2, 'Laki-laki'),
(22, '23.06.01.2386', 'M. Rizkiyan Nor, SE', 32, 2, 'Laki-laki'),
(23, '22.06.01.2165', 'Muhammad Rizky Dharmawan, S.Psi', 32, 2, 'Laki-laki'),
(24, '22.10.01.2300', 'Nadia Fahriana, S.H', 32, 2, 'Perempuan'),
(25, '21.05.01.1987', 'Ira Amelia, SKM', 32, 2, 'Perempuan'),
(26, '21.02.01.1864', 'Masrinah, SE', 32, 2, 'Perempuan'),
(27, '23.09.01.2414', 'Hidayatullah, A.Md.Kep', 32, 2, 'Perempuan'),
(28, '21.01.01.1891', 'Prima Mahartanto, S.Kep. Ns', 32, 2, 'Laki-laki'),
(29, '21.06.01.1996', 'Afifah Nurul Izzati, A.Md. RO', 32, 2, 'Perempuan'),
(32, '23.05.01.2382', 'Eliza Dwiyanti, S.Sos', 6, 3, 'Perempuan'),
(33, '21.01.01.1872', 'Muhammad Alfahmi, S.Pd', 6, 3, 'Laki-laki'),
(34, '24.05.01.2517', 'Akhmad Zul Hamzi Sofyan, LC', 6, 3, 'Laki-laki'),
(35, '24.05.01.2529', 'Nor Hilaliah Sapitri, S.Sos', 6, 3, 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `surah`
--

CREATE TABLE `surah` (
  `id_surah` int(20) NOT NULL,
  `nama_surah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surah`
--

INSERT INTO `surah` (`id_surah`, `nama_surah`) VALUES
(1, 'Al-Fatihah'),
(2, 'Al-Baqarah'),
(3, 'Ali-Imran'),
(4, 'An-Nisa'),
(5, 'Al-Ma\'idah'),
(6, 'Al-An\'am'),
(7, 'Al-A\'raf'),
(8, 'Al-Anfal'),
(9, 'At-Taubah'),
(10, 'Yunus'),
(11, 'Hud'),
(12, 'Yusuf'),
(13, 'Ar-Ra\'d'),
(14, 'Ibrahim'),
(15, 'Al-Hijr'),
(16, 'An-Nahl'),
(17, 'Al-Isra\''),
(18, 'Al-Kahfi'),
(19, 'Maryam'),
(20, 'Taha'),
(21, 'Al-Anbiya\''),
(22, 'Al-Hajj'),
(23, 'Al-Mu\'minun'),
(24, 'An-Nur'),
(25, 'Al-Furqan'),
(26, 'Ash-Shu\'ara\''),
(27, 'An-Naml'),
(28, 'Al-Qasas'),
(29, 'Al-Ankabut'),
(30, 'Ar-Rum'),
(31, 'Luqman'),
(32, 'As-Sajdah'),
(33, 'Al-Ahzab'),
(34, 'Saba\''),
(35, 'Fatir'),
(36, 'Yasin'),
(37, 'As-Saffat'),
(38, 'Sad'),
(39, 'Az-Zumar'),
(40, 'Ghafir (juga dikenal sebagai Al-Mu\'min)'),
(41, 'Fussilat'),
(42, 'Ash-Shura'),
(43, 'Az-Zukhruf'),
(44, 'Ad-Dukhan'),
(45, 'Al-Jathiyah'),
(46, 'Al-Ahqaf'),
(47, 'Muhammad'),
(48, 'Al-Fath'),
(49, 'Al-Hujurat'),
(50, 'Qaf'),
(51, 'Adz-Dzariyat'),
(52, 'At-Tur'),
(53, 'An-Najm'),
(54, 'Al-Qamar'),
(55, 'Ar-Rahman'),
(56, 'Al-Waqi\'ah'),
(57, 'Al-Hadid'),
(58, 'Al-Mujadilah'),
(59, 'Al-Hasyr'),
(60, 'Al-Mumtahanah'),
(61, 'As-Saff'),
(62, 'Al-Jumu\'ah'),
(63, 'Al-Munafiqun'),
(64, 'At-Taghabun'),
(65, 'At-Talaq'),
(66, 'At-Tahrim'),
(67, 'Al-Mulk'),
(68, 'Al-Qalam'),
(69, 'Al-Haqqah'),
(70, 'Al-Ma\'arij'),
(71, 'Nuh'),
(72, 'Al-Jinn'),
(73, 'Al-Muzzammil'),
(74, 'Al-Muddathir'),
(75, 'Al-Qiyamah'),
(76, 'Al-Insan'),
(77, 'Al-Mursalat'),
(78, 'An-Naba\''),
(79, 'An-Nazi\'at'),
(80, 'Abasa'),
(81, 'At-Takwir'),
(82, 'Al-Infitar'),
(83, 'Al-Mutaffifin'),
(84, 'Al-Inshiqaq'),
(85, 'Al-Buruj'),
(86, 'At-Tariq'),
(87, 'Al-A\'la'),
(88, 'Al-Ghashiyah'),
(89, 'Al-Fajr'),
(90, 'Al-Balad'),
(91, 'Ash-Shams'),
(92, 'Al-Lail'),
(93, 'Ad-Duha'),
(94, 'Ash-Sharh (Al-Inshirah)'),
(95, 'At-Tin'),
(96, 'Al-\'Alaq'),
(97, 'Al-Qadr'),
(98, 'Al-Bayyinah'),
(99, 'Az-Zalzalah'),
(100, 'Al-Adiyat'),
(101, 'Al-Qari\'ah'),
(102, 'At-Takathur'),
(103, 'Al-Asr'),
(104, 'Al-Humazah'),
(105, 'Al-Fil'),
(106, 'Quraisy'),
(107, 'Al-Ma\'un'),
(108, 'Al-Kawthar'),
(109, 'Al-Kafirun'),
(110, 'An-Nasr'),
(111, 'Al-Masad'),
(112, 'Al-Ikhlas'),
(113, 'Al-Falaq'),
(114, 'An-Nas');

-- --------------------------------------------------------

--
-- Table structure for table `tahfiz`
--

CREATE TABLE `tahfiz` (
  `id_tahfiz` int(20) NOT NULL,
  `tanggal` date NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_pegawai` int(20) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `id_juz` int(20) NOT NULL,
  `id_surah` int(20) NOT NULL,
  `awal_ayat` int(5) NOT NULL,
  `akhir_ayat` int(5) NOT NULL,
  `id_ustad` int(20) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahfiz`
--

INSERT INTO `tahfiz` (`id_tahfiz`, `tanggal`, `nip`, `nama`, `id_pegawai`, `id_unit`, `id_juz`, `id_surah`, `awal_ayat`, `akhir_ayat`, `id_ustad`, `catatan`) VALUES
(10, '2024-05-06', '23.01.01.2342', 'Fajrianur Ramadani', 1, 13, 1, 1, 1, 7, 1, 'baik'),
(11, '2024-05-06', '23.01.01.2343', 'Muhammad Rasyad', 2, 13, 1, 1, 1, 7, 1, 'baik'),
(12, '2024-05-15', '23.07.01.2403', 'Mita Sadiya', 9, 13, 1, 1, 1, 4, 3, 'Perbaiki Pelafalan'),
(19, '2024-08-14', '23.01.01.2342', 'Fajrianur Ramadani', 1, 33, 1, 2, 1, 8, 1, 'baik'),
(20, '2024-08-14', '20.20.20.2222', 'aaaaaaaaaaaaa', 35, 5, 1, 1, 3, 8, 1, 'buruk');

-- --------------------------------------------------------

--
-- Table structure for table `tahsin`
--

CREATE TABLE `tahsin` (
  `id_tahsin` int(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int(20) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `id_juz` int(20) NOT NULL,
  `id_surah` int(20) NOT NULL,
  `awal_ayat` int(5) NOT NULL,
  `akhir_ayat` int(5) NOT NULL,
  `id_ustad` int(20) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahsin`
--

INSERT INTO `tahsin` (`id_tahsin`, `tanggal`, `id_pegawai`, `nip`, `nama`, `id_unit`, `id_juz`, `id_surah`, `awal_ayat`, `akhir_ayat`, `id_ustad`, `catatan`) VALUES
(16, '2024-05-01', 4, '21.01.01.1912', 'Muhammad Ridha\'an Hanah', 13, 1, 1, 1, 4, 1, 'baik'),
(17, '2024-05-09', 4, '21.01.01.1912', 'Muhammad Ridha\'an Hanah', 13, 1, 1, 5, 7, 1, 'baik'),
(24, '2024-08-04', 32, '20.20.20.2222', 'Aulia Fitri', 2, 1, 1, 1, 7, 1, 'baik sekali'),
(26, '2024-08-14', 1, '23.01.01.2342', 'Fajrianur Ramadani', 33, 1, 1, 1, 3, 1, 'baik');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id_unit` int(20) NOT NULL,
  `nama_unit` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id_unit`, `nama_unit`) VALUES
(2, 'Adn'),
(5, 'Baitunissa'),
(6, 'Dakwah'),
(12, 'Darussalam'),
(13, 'Dialisis'),
(14, 'Farmasi'),
(15, 'Firdaus'),
(16, 'Gizi'),
(17, 'IBS'),
(18, 'ICU'),
(19, 'IGD'),
(20, 'Instalasi Medical Chack Up'),
(21, 'IPSRS'),
(22, 'IT'),
(23, 'Kemitraan & PKRS'),
(24, 'Keuangan & Akuntansi'),
(25, 'Laboratorium'),
(26, 'Ma\'wa'),
(27, 'Manajemen'),
(28, 'Naim'),
(29, 'Pendaftaran & Rekam Medis'),
(30, 'Radiologi'),
(31, 'Rawat Jalan'),
(32, 'SDI & Administrasi'),
(33, 'Umum');

-- --------------------------------------------------------

--
-- Table structure for table `ustad`
--

CREATE TABLE `ustad` (
  `id_ustad` int(20) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_ustad` varchar(50) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `id_unit` int(20) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `id_jabatan` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ustad`
--

INSERT INTO `ustad` (`id_ustad`, `tanggal`, `nama_ustad`, `nip`, `id_unit`, `jk`, `id_jabatan`) VALUES
(1, '2024-03-05', 'Ramlan', '43.23.12.4555', 6, 'Laki-laki', 2),
(3, '2024-05-08', 'Andi', '21.01.03.2902', 6, 'Laki-laki', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iqro`
--
ALTER TABLE `iqro`
  ADD PRIMARY KEY (`id_iqro`),
  ADD KEY `id_pegawai` (`id_pegawai`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_ustad` (`id_ustad`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `juz`
--
ALTER TABLE `juz`
  ADD PRIMARY KEY (`id_juz`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `surah`
--
ALTER TABLE `surah`
  ADD PRIMARY KEY (`id_surah`);

--
-- Indexes for table `tahfiz`
--
ALTER TABLE `tahfiz`
  ADD PRIMARY KEY (`id_tahfiz`),
  ADD KEY `id_ustad` (`id_ustad`),
  ADD KEY `id_surah` (`id_surah`),
  ADD KEY `id_juz` (`id_juz`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `tahsin`
--
ALTER TABLE `tahsin`
  ADD PRIMARY KEY (`id_tahsin`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_juz` (`id_juz`),
  ADD KEY `id_surah` (`id_surah`),
  ADD KEY `id_ustad` (`id_ustad`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `ustad`
--
ALTER TABLE `ustad`
  ADD PRIMARY KEY (`id_ustad`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `iqro`
--
ALTER TABLE `iqro`
  MODIFY `id_iqro` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `juz`
--
ALTER TABLE `juz`
  MODIFY `id_juz` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `surah`
--
ALTER TABLE `surah`
  MODIFY `id_surah` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `tahfiz`
--
ALTER TABLE `tahfiz`
  MODIFY `id_tahfiz` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tahsin`
--
ALTER TABLE `tahsin`
  MODIFY `id_tahsin` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id_unit` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ustad`
--
ALTER TABLE `ustad`
  MODIFY `id_ustad` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iqro`
--
ALTER TABLE `iqro`
  ADD CONSTRAINT `iqro_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iqro_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iqro_ibfk_3` FOREIGN KEY (`id_ustad`) REFERENCES `ustad` (`id_ustad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tahfiz`
--
ALTER TABLE `tahfiz`
  ADD CONSTRAINT `tahfiz_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfiz_ibfk_2` FOREIGN KEY (`id_juz`) REFERENCES `juz` (`id_juz`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfiz_ibfk_3` FOREIGN KEY (`id_surah`) REFERENCES `surah` (`id_surah`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfiz_ibfk_4` FOREIGN KEY (`id_ustad`) REFERENCES `ustad` (`id_ustad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfiz_ibfk_5` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tahsin`
--
ALTER TABLE `tahsin`
  ADD CONSTRAINT `tahsin_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahsin_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahsin_ibfk_3` FOREIGN KEY (`id_ustad`) REFERENCES `ustad` (`id_ustad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahsin_ibfk_4` FOREIGN KEY (`id_surah`) REFERENCES `surah` (`id_surah`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahsin_ibfk_5` FOREIGN KEY (`id_juz`) REFERENCES `juz` (`id_juz`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ustad`
--
ALTER TABLE `ustad`
  ADD CONSTRAINT `ustad_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ustad_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
