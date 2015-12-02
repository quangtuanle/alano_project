-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2015 at 02:07 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alano`
--

-- --------------------------------------------------------

--
-- Table structure for table `baiviet`
--

CREATE TABLE IF NOT EXISTS `baiviet` (
  `MaBaiViet` varchar(5) COLLATE utf8_vietnamese_ci NOT NULL,
  `TieuDe` tinytext COLLATE utf8_vietnamese_ci NOT NULL,
  `NoiDung` longtext COLLATE utf8_vietnamese_ci NOT NULL,
  `HinhAnhMinhHoa` text COLLATE utf8_vietnamese_ci,
  `NgayDang` datetime NOT NULL,
  `SoLuotView` int(11) DEFAULT NULL,
  `SoLuotLike` int(11) DEFAULT NULL,
  `SoLuotUnlike` int(11) DEFAULT NULL,
  `SoLuotShare` int(11) DEFAULT NULL,
  `Nhan` text COLLATE utf8_vietnamese_ci NOT NULL,
  `TaiKhoanTacGia` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  PRIMARY KEY (`MaBaiViet`),
  KEY `FK_BaiViet_TaiKhoan` (`TaiKhoanTacGia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ct_theloaibaiviet`
--

CREATE TABLE IF NOT EXISTS `ct_theloaibaiviet` (
  `MaBaiViet` varchar(5) COLLATE utf8_vietnamese_ci NOT NULL,
  `MaTheLoai` varchar(2) COLLATE utf8_vietnamese_ci NOT NULL,
  KEY `FK_CTTLBV_TheLoai` (`MaTheLoai`),
  KEY `FK_CTTLBV_BaiViet` (`MaBaiViet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE IF NOT EXISTS `nhanvien` (
  `TenDN` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `CMND` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `DiaChi` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Loai` int(11) NOT NULL,
  PRIMARY KEY (`TenDN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanhoi`
--

CREATE TABLE IF NOT EXISTS `phanhoi` (
  `MaPhanHoi` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `NoiDungPhanHoi` text COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayPhanHoi` datetime NOT NULL,
  `TaiKhoanPhanHoi` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `BaiVietPhanHoi` varchar(5) COLLATE utf8_vietnamese_ci NOT NULL,
  `SoLike` int(11) DEFAULT NULL,
  `SoUnlike` int(11) DEFAULT NULL,
  PRIMARY KEY (`MaPhanHoi`),
  KEY `FK_PhanHoi_TaiKhoan` (`TaiKhoanPhanHoi`),
  KEY `FK_PhanHoi_BaiViet` (`BaiVietPhanHoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE IF NOT EXISTS `taikhoan` (
  `TenDN` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `MatKhau` varchar(20) COLLATE utf8_vietnamese_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `HoTen` text CHARACTER SET utf8,
  `GioiTinh` text CHARACTER SET utf8,
  `HinhAnhDaiDien` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `MoTaBanThan` text CHARACTER SET utf8,
  PRIMARY KEY (`TenDN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanhvien`
--

CREATE TABLE IF NOT EXISTS `thanhvien` (
  `TenDN` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `Credit` text CHARACTER SET utf8,
  PRIMARY KEY (`TenDN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE IF NOT EXISTS `theloai` (
  `MaTheLoai` varchar(2) COLLATE utf8_vietnamese_ci NOT NULL,
  `TenTheLoai` tinytext COLLATE utf8_vietnamese_ci NOT NULL,
  PRIMARY KEY (`MaTheLoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE IF NOT EXISTS `tintuc` (
  `MaTinTuc` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `TieuDe` text COLLATE utf8_vietnamese_ci NOT NULL,
  `TomTat` text COLLATE utf8_vietnamese_ci NOT NULL,
  `NoiDungChinh` text COLLATE utf8_vietnamese_ci NOT NULL,
  `TacGia` tinytext COLLATE utf8_vietnamese_ci,
  `NgayDang` datetime NOT NULL,
  `DuongLinkGoc` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `TinhTrangLink` varchar(20) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `CacTrangDanNguon` varchar(300) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `SoLuotShare` int(11) DEFAULT NULL,
  `SoLuotComment` int(11) DEFAULT NULL,
  `BaiTuongTu` varchar(1000) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `SoBaiTrung` int(11) DEFAULT NULL,
  PRIMARY KEY (`MaTinTuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `FK_BaiViet_TaiKhoan` FOREIGN KEY (`TaiKhoanTacGia`) REFERENCES `taikhoan` (`TenDN`);

--
-- Constraints for table `ct_theloaibaiviet`
--
ALTER TABLE `ct_theloaibaiviet`
  ADD CONSTRAINT `FK_CTTLBV_BaiViet` FOREIGN KEY (`MaBaiViet`) REFERENCES `baiviet` (`MaBaiViet`),
  ADD CONSTRAINT `FK_CTTLBV_TheLoai` FOREIGN KEY (`MaTheLoai`) REFERENCES `theloai` (`MaTheLoai`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_NHANVIEN_TAIKHOAN` FOREIGN KEY (`TenDN`) REFERENCES `taikhoan` (`TenDN`);

--
-- Constraints for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `FK_PhanHoi_BaiViet` FOREIGN KEY (`BaiVietPhanHoi`) REFERENCES `baiviet` (`MaBaiViet`),
  ADD CONSTRAINT `FK_PhanHoi_TaiKhoan` FOREIGN KEY (`TaiKhoanPhanHoi`) REFERENCES `taikhoan` (`TenDN`);

--
-- Constraints for table `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD CONSTRAINT `FK_THANHVIEN_TAIKHOAN` FOREIGN KEY (`TenDN`) REFERENCES `taikhoan` (`TenDN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
