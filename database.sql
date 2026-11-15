-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2026 at 12:58 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sidang_yudisium`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_berita_acara`
--

CREATE TABLE `tbl_berita_acara` (
  `id` int NOT NULL,
  `nama_mahasiswa_enc` text NOT NULL,
  `nim_enc` text NOT NULL,
  `prodi_enc` text NOT NULL,
  `ketua_penguji_enc` text NOT NULL,
  `catatan_revisi_enc` longtext NOT NULL,
  `keputusan_sidang_enc` text NOT NULL,
  `encrypted_aes_key` text NOT NULL,
  `iv` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_berita_acara`
--

INSERT INTO `tbl_berita_acara` (`id`, `nama_mahasiswa_enc`, `nim_enc`, `prodi_enc`, `ketua_penguji_enc`, `catatan_revisi_enc`, `keputusan_sidang_enc`, `encrypted_aes_key`, `iv`, `created_at`) VALUES
(2, 'KkFXM+Y+s7dG63NmMvquLQ==', 'Oje0YwHem/WUcxf/H13qUQ==', 'yaRk9uC4/GIct7369ONnqJkFMpBP8zT7AtLTiG3naYY=', 'RZ+tHCLj7bBb4FdPvpy27dBOPATg9ZPm6hmW8OA8TLs=', 'Hwg/A4P4s/V5l9v3VJPyp2B/chzsb1iX1+/a6uxnHsj8MeiJKad8S0fjSQUK9X5BUJ1WKSKkB8j8Q5frNt6d8RiLLqeq2G5wum+ybKrqEkfep7Ck/R2yjCAljwXuY0mEAkvu/mfxUgYE9E899AMgyW/qahEefNQ/l1JkE4r0vkTvwgxm/D9UkTw9T9ccpm1IbyfnFOcUL0GmimjROGFjxtr6/i4qbCptbuPT1e2pY9WKtBi7mL2XfwBLUpnUAIh2DN13EHo27PrN53eaNbW6WS56UW4JI2DefmlAOqmDMJyGEO77rAYFoVBGBq9leBqvRqxItBJVF5vdAOrrs0Fkb7l2Li3H2RweoQxJ7/yLHR/nQHnw4+PIhigGuD7QhuqqyrjJDUrbWOY7qgXGDiGjCugYtnFQCkzhUSDY2ducx3AMDCnV00z6ueo3ErxLKJCt', 'on3VDoW5e912+MSIqFro1rmtCzDsEUOZc4UYO4yGWXA=', 'jBfFC9Giiav8DlJUUxtPXPySASPzOfK5I2xKySRl2TojewdcPmm7Obiiz8E8QXRaIWiRpWJFFpB8k1qbX6kFReOH8NZ9NvzozKtNdgn/K419j5dUdUSRcMzRf+A1cnOapnOBsdFBc+xzvksrQHdr8dVu68h+0PI+m7atQ1t6mkmLGcvrAPtOo523te3Dux7a+3DhHAmpE0RdxLm1O1oirFBvuOxSpH9tsqO8jFvIKRUYjcCXGsbYy28qUexss+cOkBJDKuCe21ujr54vUN7zir9zxXIUDnjYS7A5z3umwSgiRGGybce3tbBnlJbxTZNYmixJarSmmhjfEhGE4wD0sg==', 'pegiw31fU9EFPgq+qSx/cg==', '2026-11-15 12:51:17'),
(3, 'v6wrcckGBFFQX4/nlYBf8w==', 'MB3QxZy4DtoMS/XUMqPneg==', 'jAm9RRTLIrRqrNtB45LUpZgpxS2ZXYZJu9KDL+Br3vg=', '3JFEDirs6PrDTIngSmPRfWNZW5ui/59qVbWEq5U40Lg=', 'v1GDkVsj8PYkzMW36e00XIIDeX2DvMfxcjqEbX7srTAmHgWEe+kByu7h1RWFim8OOiAqn4wo+Gp5DDG5+XUCXYe8080K9rdaevskKnibh/GZjPz6r5Yw1a1BBOTBVu+5R94SCzqfhS5qaAjLHEYSFwbUZgmYlL7IOfVSrvNym5JQjDdFXwowM8ghrdVh17PJE26ht8mYHbGc2oAKcimRCDmGH7Cx7quXHKNuwo00BP0xJIN3yvXJzuInWysLdbfSaSUL5IDU1olOL7HvbL9LdjXt/BRnLX/Rfzlhubq+hmHdzTxRKhV+DEYcvTHqJU58DItYn4z/DzM+s3880ZP90TFiG7sayCWCfb1+nb1+Xhs8aWx1Po+7/qGHGNbVDdj5j3pWU0GHeGu1h7KvGnmOz0+BtZ+8tUl3Ge3kwIzYvuA=', '8k8kTcZjiXyCUDxRvmFoyi5t7RJPLNwBK9V8eO/0/+w=', 'g3T49N0Ussnmv7QJchJyQlVaxDfTp0rf0Jv4u+h2TonWChmqXJOb9aUAOCB3tQwBRc2t1x6/ZttxyweoY9mw9ZlGm/fF4qN8mbECPm+fWm0a50ocDdUrdvWdNmtWPzOUjUpFu64rR1AUwE2B/O3pbi6dUjD9NeiA2Aw1KS2K2pNmM88fUPWOEMYDlZCVebAP+/3k4Qvc4ca4xqxVHJtZFVcxDLLTmRXgId0MyXQbwTx64ozYBKD94gYILWmY4nBQz1BU1SveTN4CTtMyVuNaZhQofiknQ26qpP32H+nnGmYsmCUtz17ZO64FjRYhvnnpKchE2+OBOZCq543ZaTXAsw==', 'dTUXYCI9646xuDrrh3+XaQ==', '2026-11-15 12:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jadwal_sidang`
--

CREATE TABLE `tbl_jadwal_sidang` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(30) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `judul_skripsi` text NOT NULL,
  `ruangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_jadwal_sidang`
--

INSERT INTO `tbl_jadwal_sidang` (`id`, `tanggal`, `waktu`, `nama_mahasiswa`, `judul_skripsi`, `ruangan`) VALUES
(1, '2026-11-18', '09:00 - 10:30 WIB', 'Ahmad Fauzi (2230511001)', 'Implementasi Algoritma A* untuk Optimasi Rute Distribusi Logistik', 'Ruang Sidang 1 - Gedung B'),
(2, '2026-11-18', '10:45 - 12:15 WIB', 'Siti Rahmawati (2230511014)', 'Sistem Deteksi Penyakit Daun Padi Berbasis Convolutional Neural Network', 'Ruang Sidang 2 - Gedung B'),
(3, '2026-11-19', '13:00 - 14:30 WIB', 'Rizky Pratama (2230511029)', 'Keamanan Pertukaran Dokumen Akademik Menggunakan Hybrid Cryptography', 'Ruang Sidang 1 - Gedung B');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kalender_akademik`
--

CREATE TABLE `tbl_kalender_akademik` (
  `id` int NOT NULL,
  `periode_tanggal` varchar(60) NOT NULL,
  `kegiatan` varchar(150) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_kalender_akademik`
--

INSERT INTO `tbl_kalender_akademik` (`id`, `periode_tanggal`, `kegiatan`, `status`) VALUES
(1, '01 - 10 November 2026', 'Pendaftaran Sidang Skripsi Gelombang II', 'Selesai'),
(2, '16 - 25 November 2026', 'Pelaksanaan Sidang Skripsi Terbuka & Tertutup', 'Berlangsung'),
(3, '26 - 30 November 2026', 'Batas Akhir Pengumpulan Revisi Berita Acara Sidang', 'Akan Datang'),
(4, '05 Desember 2026', 'Rapat Yudisium Fakultas & Pengumuman Kelulusan Resmi', 'Akan Datang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_syarat_yudisium`
--

CREATE TABLE `tbl_syarat_yudisium` (
  `id` int NOT NULL,
  `judul_syarat` varchar(150) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_syarat_yudisium`
--

INSERT INTO `tbl_syarat_yudisium` (`id`, `judul_syarat`, `keterangan`) VALUES
(1, 'Lembar Pengesahan Skripsi', 'Telah ditandatangani oleh Dosen Pembimbing, Tim Penguji, dan Ketua Program Studi.'),
(2, 'Bukti Bebas Revisi & Plagiasi', 'Melampirkan lembar berita acara bebas revisi dan hasil cek Turnitin maksimal 20%.'),
(3, 'Bebas Pustaka & Administrasi Keuangan', 'Surat keterangan bebas pinjaman perpustakaan dan pelunasan seluruh administrasi UKT.'),
(4, 'Sertifikat Kompetensi & Publikasi', 'Melampirkan sertifikat pendamping ijazah (SKPI) dan bukti submit/publish jurnal ilmiah.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_berita_acara`
--
ALTER TABLE `tbl_berita_acara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jadwal_sidang`
--
ALTER TABLE `tbl_jadwal_sidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kalender_akademik`
--
ALTER TABLE `tbl_kalender_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_syarat_yudisium`
--
ALTER TABLE `tbl_syarat_yudisium`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_berita_acara`
--
ALTER TABLE `tbl_berita_acara`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_jadwal_sidang`
--
ALTER TABLE `tbl_jadwal_sidang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_kalender_akademik`
--
ALTER TABLE `tbl_kalender_akademik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_syarat_yudisium`
--
ALTER TABLE `tbl_syarat_yudisium`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
