-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Agu 2021 pada 12.22
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `persidangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_banding`
--

CREATE TABLE `tbl_banding` (
  `id_banding` int(11) NOT NULL,
  `tanggal_banding` date NOT NULL,
  `ket_banding` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_banding`
--

INSERT INTO `tbl_banding` (`id_banding`, `tanggal_banding`, `ket_banding`) VALUES
(1, '2010-05-29', 'Ditolak'),
(2, '2010-05-11', 'Ditolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bukti`
--

CREATE TABLE `tbl_bukti` (
  `id_bukti` int(11) NOT NULL,
  `nama_bukti` varchar(125) NOT NULL,
  `tanggal_penemuan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_bukti`
--

INSERT INTO `tbl_bukti` (`id_bukti`, `nama_bukti`, `tanggal_penemuan`) VALUES
(1, 'Pisau', '2009-01-01'),
(2, 'Sepatu', '2009-01-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hakim`
--

CREATE TABLE `tbl_hakim` (
  `id_hakim` int(11) NOT NULL,
  `nama_hakim` varchar(75) NOT NULL,
  `jabatan_hakim` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_hakim`
--

INSERT INTO `tbl_hakim` (`id_hakim`, `nama_hakim`, `jabatan_hakim`) VALUES
(1, 'Rahmat Sitompul', 'Majelis A'),
(2, 'Ahmad', 'Majelis Hakim'),
(3, 'Andi Ahmad', 'Majelis Hakim'),
(5, 'PURWANTO, S.H., M.Hum.', 'HAKIM TINGGI'),
(11, 'Diablo', 'Hakim');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jaksa`
--

CREATE TABLE `tbl_jaksa` (
  `id_jaksa` int(11) NOT NULL,
  `nama_jaksa` varchar(75) NOT NULL,
  `jabatan_jaksa` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_jaksa`
--

INSERT INTO `tbl_jaksa` (`id_jaksa`, `nama_jaksa`, `jabatan_jaksa`) VALUES
(1, 'Dr. ST. Burhanuddin', 'Jaksa Agung'),
(2, 'Erwin Desman', 'Kepala Kejaksaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kasus`
--

CREATE TABLE `tbl_kasus` (
  `id_kasus` int(11) NOT NULL,
  `id_penggugat` int(11) NOT NULL,
  `id_tergugat` int(11) NOT NULL,
  `id_bukti` int(11) NOT NULL,
  `gugatan` varchar(200) NOT NULL,
  `keterangan` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kasus`
--

INSERT INTO `tbl_kasus` (`id_kasus`, `id_penggugat`, `id_tergugat`, `id_bukti`, `gugatan`, `keterangan`) VALUES
(1, 1, 2, 1, 'Tuduhan Pembunuhan', 'Diterima'),
(2, 2, 1, 2, 'Tuduhan Pencurian', 'Ditolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengacara`
--

CREATE TABLE `tbl_pengacara` (
  `id_pengacara` int(11) NOT NULL,
  `nama_pengacara` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengacara`
--

INSERT INTO `tbl_pengacara` (`id_pengacara`, `nama_pengacara`) VALUES
(1, 'Sultan'),
(2, 'Arifuddin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengadilan`
--

CREATE TABLE `tbl_pengadilan` (
  `id_pengadilan` int(11) NOT NULL,
  `nama_pengadilan` varchar(100) NOT NULL,
  `kota_pengadilan` varchar(45) NOT NULL,
  `alamat_pengadilan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengadilan`
--

INSERT INTO `tbl_pengadilan` (`id_pengadilan`, `nama_pengadilan`, `kota_pengadilan`, `alamat_pengadilan`) VALUES
(1, 'Pengadilan Negeri Jakarta Utara', 'Jakarta', 'Jl. Gajah Mada No. 18'),
(2, 'Pengadilan Tinggi DKI Jakarta', 'Jakarta', 'Jl. Letnan Jendral Suprapto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penggugat`
--

CREATE TABLE `tbl_penggugat` (
  `id_penggugat` int(11) NOT NULL,
  `id_pengacara` int(11) NOT NULL,
  `nama_penggugat` varchar(75) NOT NULL,
  `pekerjaan_penggugat` varchar(75) NOT NULL,
  `umur_penggugat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_penggugat`
--

INSERT INTO `tbl_penggugat` (`id_penggugat`, `id_pengacara`, `nama_penggugat`, `pekerjaan_penggugat`, `umur_penggugat`) VALUES
(1, 1, 'Tristan', 'Penjual Sepatu', 21),
(2, 2, 'Julian', 'Pedagang', 31);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_saksi`
--

CREATE TABLE `tbl_saksi` (
  `id_saksi` int(11) NOT NULL,
  `nama_saksi` varchar(75) NOT NULL,
  `pekerjaan_saksi` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_saksi`
--

INSERT INTO `tbl_saksi` (`id_saksi`, `nama_saksi`, `pekerjaan_saksi`) VALUES
(1, 'Anto', 'Petani'),
(2, 'Diablo', 'Nelayan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sidang`
--

CREATE TABLE `tbl_sidang` (
  `id_sidang` int(11) NOT NULL,
  `id_hakim` int(11) NOT NULL,
  `id_penggugat` int(11) NOT NULL,
  `id_tergugat` int(11) NOT NULL,
  `id_pengadilan` int(11) NOT NULL,
  `id_saksi` int(11) NOT NULL,
  `id_banding` int(11) NOT NULL,
  `id_bukti` int(11) NOT NULL,
  `id_jaksa` int(11) NOT NULL,
  `waktu_sidang` time NOT NULL,
  `ket_sidang` varchar(50) NOT NULL,
  `keputusan_sidang` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_sidang`
--

INSERT INTO `tbl_sidang` (`id_sidang`, `id_hakim`, `id_penggugat`, `id_tergugat`, `id_pengadilan`, `id_saksi`, `id_banding`, `id_bukti`, `id_jaksa`, `waktu_sidang`, `ket_sidang`, `keputusan_sidang`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, '00:20:10', 'Selesai', 'Penjara Atas Tergugat'),
(2, 2, 2, 2, 2, 2, 2, 2, 2, '00:00:20', 'Selesai', 'Penjara Atas Tergugat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_tergugat`
--

CREATE TABLE `tbl_tergugat` (
  `id_tergugat` int(11) NOT NULL,
  `id_pengacara` int(11) NOT NULL,
  `nama_tergugat` varchar(75) NOT NULL,
  `pekerjaan_tergugat` varchar(75) NOT NULL,
  `umur_tergugat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_tergugat`
--

INSERT INTO `tbl_tergugat` (`id_tergugat`, `id_pengacara`, `nama_tergugat`, `pekerjaan_tergugat`, `umur_tergugat`) VALUES
(1, 2, 'Lancellot', 'Camat', 41),
(2, 1, 'King', 'Sopir Angkot', 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `email`, `nama_lengkap`) VALUES
(1, 'user_1', '12345', 'user1@gmail.com', 'Pengguna yang Pertama'),
(2, 'user_2', '54321', 'user_2@yahoo.com', 'User Kedua'),
(4, 'cat', '123456', 'cat@gmail.com', 'Mad Cat');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_banding`
--
ALTER TABLE `tbl_banding`
  ADD PRIMARY KEY (`id_banding`);

--
-- Indeks untuk tabel `tbl_bukti`
--
ALTER TABLE `tbl_bukti`
  ADD PRIMARY KEY (`id_bukti`);

--
-- Indeks untuk tabel `tbl_hakim`
--
ALTER TABLE `tbl_hakim`
  ADD PRIMARY KEY (`id_hakim`);

--
-- Indeks untuk tabel `tbl_jaksa`
--
ALTER TABLE `tbl_jaksa`
  ADD PRIMARY KEY (`id_jaksa`);

--
-- Indeks untuk tabel `tbl_kasus`
--
ALTER TABLE `tbl_kasus`
  ADD PRIMARY KEY (`id_kasus`),
  ADD KEY `id_penggugat` (`id_penggugat`,`id_tergugat`,`id_bukti`),
  ADD KEY `id_tergugat` (`id_tergugat`),
  ADD KEY `id_bukti` (`id_bukti`);

--
-- Indeks untuk tabel `tbl_pengacara`
--
ALTER TABLE `tbl_pengacara`
  ADD PRIMARY KEY (`id_pengacara`);

--
-- Indeks untuk tabel `tbl_pengadilan`
--
ALTER TABLE `tbl_pengadilan`
  ADD PRIMARY KEY (`id_pengadilan`);

--
-- Indeks untuk tabel `tbl_penggugat`
--
ALTER TABLE `tbl_penggugat`
  ADD PRIMARY KEY (`id_penggugat`),
  ADD KEY `id_pengacara` (`id_pengacara`);

--
-- Indeks untuk tabel `tbl_saksi`
--
ALTER TABLE `tbl_saksi`
  ADD PRIMARY KEY (`id_saksi`);

--
-- Indeks untuk tabel `tbl_sidang`
--
ALTER TABLE `tbl_sidang`
  ADD PRIMARY KEY (`id_sidang`),
  ADD KEY `id_hakim` (`id_hakim`,`id_penggugat`,`id_tergugat`,`id_pengadilan`,`id_saksi`,`id_banding`,`id_bukti`,`id_jaksa`),
  ADD KEY `id_jaksa` (`id_jaksa`),
  ADD KEY `id_pengadilan` (`id_pengadilan`),
  ADD KEY `id_penggugat` (`id_penggugat`),
  ADD KEY `id_tergugat` (`id_tergugat`),
  ADD KEY `id_saksi` (`id_saksi`),
  ADD KEY `id_bukti` (`id_bukti`),
  ADD KEY `id_banding` (`id_banding`);

--
-- Indeks untuk tabel `tbl_tergugat`
--
ALTER TABLE `tbl_tergugat`
  ADD PRIMARY KEY (`id_tergugat`),
  ADD KEY `id_pengacara` (`id_pengacara`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_banding`
--
ALTER TABLE `tbl_banding`
  MODIFY `id_banding` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_bukti`
--
ALTER TABLE `tbl_bukti`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_hakim`
--
ALTER TABLE `tbl_hakim`
  MODIFY `id_hakim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_jaksa`
--
ALTER TABLE `tbl_jaksa`
  MODIFY `id_jaksa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_kasus`
--
ALTER TABLE `tbl_kasus`
  MODIFY `id_kasus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengacara`
--
ALTER TABLE `tbl_pengacara`
  MODIFY `id_pengacara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengadilan`
--
ALTER TABLE `tbl_pengadilan`
  MODIFY `id_pengadilan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_penggugat`
--
ALTER TABLE `tbl_penggugat`
  MODIFY `id_penggugat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_saksi`
--
ALTER TABLE `tbl_saksi`
  MODIFY `id_saksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_sidang`
--
ALTER TABLE `tbl_sidang`
  MODIFY `id_sidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_tergugat`
--
ALTER TABLE `tbl_tergugat`
  MODIFY `id_tergugat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_kasus`
--
ALTER TABLE `tbl_kasus`
  ADD CONSTRAINT `tbl_kasus_ibfk_1` FOREIGN KEY (`id_penggugat`) REFERENCES `tbl_penggugat` (`id_penggugat`),
  ADD CONSTRAINT `tbl_kasus_ibfk_2` FOREIGN KEY (`id_tergugat`) REFERENCES `tbl_tergugat` (`id_tergugat`),
  ADD CONSTRAINT `tbl_kasus_ibfk_3` FOREIGN KEY (`id_bukti`) REFERENCES `tbl_bukti` (`id_bukti`);

--
-- Ketidakleluasaan untuk tabel `tbl_penggugat`
--
ALTER TABLE `tbl_penggugat`
  ADD CONSTRAINT `tbl_penggugat_ibfk_1` FOREIGN KEY (`id_pengacara`) REFERENCES `tbl_pengacara` (`id_pengacara`);

--
-- Ketidakleluasaan untuk tabel `tbl_sidang`
--
ALTER TABLE `tbl_sidang`
  ADD CONSTRAINT `tbl_sidang_ibfk_1` FOREIGN KEY (`id_jaksa`) REFERENCES `tbl_jaksa` (`id_jaksa`),
  ADD CONSTRAINT `tbl_sidang_ibfk_2` FOREIGN KEY (`id_hakim`) REFERENCES `tbl_hakim` (`id_hakim`),
  ADD CONSTRAINT `tbl_sidang_ibfk_3` FOREIGN KEY (`id_pengadilan`) REFERENCES `tbl_pengadilan` (`id_pengadilan`),
  ADD CONSTRAINT `tbl_sidang_ibfk_4` FOREIGN KEY (`id_penggugat`) REFERENCES `tbl_penggugat` (`id_penggugat`),
  ADD CONSTRAINT `tbl_sidang_ibfk_5` FOREIGN KEY (`id_tergugat`) REFERENCES `tbl_tergugat` (`id_tergugat`),
  ADD CONSTRAINT `tbl_sidang_ibfk_6` FOREIGN KEY (`id_saksi`) REFERENCES `tbl_saksi` (`id_saksi`),
  ADD CONSTRAINT `tbl_sidang_ibfk_7` FOREIGN KEY (`id_bukti`) REFERENCES `tbl_bukti` (`id_bukti`),
  ADD CONSTRAINT `tbl_sidang_ibfk_8` FOREIGN KEY (`id_banding`) REFERENCES `tbl_banding` (`id_banding`);

--
-- Ketidakleluasaan untuk tabel `tbl_tergugat`
--
ALTER TABLE `tbl_tergugat`
  ADD CONSTRAINT `tbl_tergugat_ibfk_1` FOREIGN KEY (`id_pengacara`) REFERENCES `tbl_pengacara` (`id_pengacara`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
