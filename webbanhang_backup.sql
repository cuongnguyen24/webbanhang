-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: myproject_db
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anhsanpham`
--

DROP TABLE IF EXISTS `anhsanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anhsanpham` (
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `duongDanAnh` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `maAnh` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`maAnh`),
  KEY `maSanPham` (`maSanPham`),
  KEY `maSanPham_2` (`maSanPham`),
  KEY `maAlbum` (`maSanPham`),
  CONSTRAINT `anhsanpham_ibfk_1` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anhsanpham`
--

LOCK TABLES `anhsanpham` WRITE;
/*!40000 ALTER TABLE `anhsanpham` DISABLE KEYS */;
INSERT INTO `anhsanpham` VALUES ('MSP2','uploads/1720282999.webp',64),('MSP2','uploads/17202829991720282999.webp',65),('MSP2','uploads/1720283000.webp',66),('MSP2','uploads/17202830001720283000.webp',67),('MSP3','uploads/1720283033.webp',68),('MSP3','uploads/17202830331720283033.webp',69),('MSP3','uploads/17202830331720283033.webp',70),('MSP3','uploads/17202830331720283033.webp',71),('MSP5','uploads/1720283148.webp',74),('MSP6','uploads/1720283184.webp',75),('MSP6','uploads/17202831841720283184.webp',76),('MSP6','uploads/17202831841720283184.webp',77),('MSP6','uploads/17202831841720283184.webp',78),('MSP7','uploads/1720283218.webp',79),('MSP7','uploads/17202832181720283218.webp',80),('MSP7','uploads/17202832181720283218.webp',81),('MSP7','uploads/17202832181720283218.webp',82),('MSP8','uploads/1720283265.webp',83),('MSP8','uploads/17202832651720283265.webp',84),('MSP8','uploads/17202832651720283265.webp',85),('MSP8','uploads/17202832651720283265.webp',86),('MSP9','uploads/1720283296.webp',87),('MSP9','uploads/17202832961720283296.webp',88),('MSP9','uploads/17202832961720283296.webp',89),('MSP9','uploads/17202832961720283296.webp',90),('MSP11','uploads/1720283387.webp',92),('MSP12','uploads/1720283438.webp',93),('MSP12','uploads/17202834381720283438.webp',94),('MSP12','uploads/17202834381720283438.webp',95),('MSP12','uploads/17202834381720283438.webp',96),('MSP16','uploads/1720283773.webp',100),('MSP17','uploads/1720283800.webp',101),('MSP18','uploads/1720283824.webp',102),('MSP19','uploads/1720283848.webp',103),('MSP20','uploads/1720283873.webp',104),('MSP21','uploads/1720283905.webp',105),('MSP22','uploads/1720283935.webp',106),('MSP23','uploads/1720283966.webp',107),('MSP24','uploads/1720284019.webp',108),('MSP25','uploads/1720284040.jpg',109),('MSP26','uploads/1720284059.webp',110),('MSP27','uploads/1720284094.jpg',111),('MSP28','uploads/1720284125.webp',112),('MSP29','uploads/1720284144.webp',113),('MSP30','uploads/1720284192.webp',114),('MSP31','uploads/1720284217.webp',115),('MSP33','uploads/1720284266.webp',117),('MSP34','uploads/1720284290.webp',118),('MSP35','uploads/1720284322.webp',119),('MSP14','uploads/01720507165.webp',120),('MSP15','uploads/01720507178.webp',121),('MSP32','uploads/01720528462.jpg',122),('MSP36','uploads/1720528599.jpg',123),('MSP37','uploads/1720546225.webp',124),('MSP38','uploads/1720547884.webp',125),('MSP39','uploads/1720547915.webp',126),('MSP4','uploads/01720572117.webp',127),('MSP10','uploads/01720572139.webp',128),('MSP13','uploads/01720572200.webp',129),('MSP1','uploads/01720572283.webp',130),('MSP1','uploads/11720572283.webp',131),('MSP1','uploads/21720572283.webp',132),('MSP1','uploads/31720572283.webp',133);
/*!40000 ALTER TABLE `anhsanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietdonhang` (
  `maDonHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maSize` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuong` int NOT NULL,
  `donGia` int NOT NULL,
  `thanhTien` int NOT NULL,
  KEY `maDonHang` (`maDonHang`,`maSanPham`),
  KEY `maSanPham` (`maSanPham`),
  CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`),
  CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`maDonHang`) REFERENCES `donhang` (`maDonHang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietdonhang`
--

LOCK TABLES `chitietdonhang` WRITE;
/*!40000 ALTER TABLE `chitietdonhang` DISABLE KEYS */;
INSERT INTO `chitietdonhang` VALUES ('DH1','MSP14','XL',1,230000,230000),('DH1','MSP27','XL',1,185000,185000),('DH1','MSP27','L',2,185000,370000),('DH2','MSP15','XL',1,185000,185000),('DH3','MSP13','L',1,230000,230000),('DH4','MSP14','L',1,230000,230000),('DH5','MSP15','L',1,185000,185000),('DH6','MSP25','L',1,195000,195000),('DH7','MSP14','XL',1,230000,230000),('DH8','MSP14','M',1,230000,230000),('DH9','MSP19','L',1,205000,205000),('DH10','MSP25','L',1,195000,195000),('DH11','MSP14','XL',1,230000,230000),('DH12','MSP25','M',1,195000,195000),('DH13','MSP24','L',7,195000,1365000),('DH14','MSP14','L',5,230000,1150000),('DH15','MSP15','XL',5,185000,925000),('DH16','MSP14','L',5,230000,1150000),('DH17','MSP14','L',4,230000,920000),('DH18','MSP15','M',4,185000,740000),('DH19','MSP26','L',5,195000,975000),('DH20','MSP14','L',1,230000,230000),('DH1','MSP26','M',2,195000,390000);
/*!40000 ALTER TABLE `chitietdonhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danhmuc` (
  `maDanhMuc` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenDanhMuc` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `danhMucCha` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `viTri` int NOT NULL,
  PRIMARY KEY (`maDanhMuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `danhmuc`
--

LOCK TABLES `danhmuc` WRITE;
/*!40000 ALTER TABLE `danhmuc` DISABLE KEYS */;
INSERT INTO `danhmuc` VALUES ('MDM1','THỜI TRANG SƠ SINH','/webbanhang/collections/thoi-trang-so-sinh/','-1',1),('MDM10','Set phụ kiện','/webbanhang/collections/set-phu-kien/','MDM7',1),('MDM11','Mũ','/webbanhang/collections/mu/','MDM7',2),('MDM12','THỜI TRANG CHO BÉ 2-6Y','/webbanhang/collections/thoi-trang-cho-be-2-6y/','-1',2),('MDM3','Sơ sinh 0-3 tháng','/webbanhang/collections/so-sinh-0-3-thang/','MDM1',1),('MDM4','Bộ liền','/webbanhang/collections/bo-lien/','MDM3',1),('MDM5','Bộ dài tay','/webbanhang/collections/bo-dai-tay/','MDM3',1),('MDM6','Bé 3-24 tháng','/webbanhang/collections/be-3-24-thang/','MDM1',2),('MDM7','Phụ kiện','/webbanhang/collections/phu-kien/','MDM1',3),('MDM8','Áo khoác','/webbanhang/collections/ao-khoac/','MDM6',1),('MDM9','Bộ liền 2','/webbanhang/collections/bo-lien-2/','MDM6',1);
/*!40000 ALTER TABLE `danhmuc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diachi`
--

DROP TABLE IF EXISTS `diachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diachi` (
  `maDiaChi` int NOT NULL AUTO_INCREMENT,
  `maKhachHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenDiaChi` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `tinhTrang` int NOT NULL,
  PRIMARY KEY (`maDiaChi`),
  KEY `maKhachHang` (`maKhachHang`),
  CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`maKhachHang`) REFERENCES `khachhang` (`maKhachHang`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diachi`
--

LOCK TABLES `diachi` WRITE;
/*!40000 ALTER TABLE `diachi` DISABLE KEYS */;
INSERT INTO `diachi` VALUES (1,'kh01','Quỳnh Đôi, Quỳnh Lưu, Nghệ An 37 ',0),(8,'kh01','Thôn 2,Quỳnh Đôi, Quỳnh Lưu',0),(10,'kh01','Thôn 1, Quỳnh Đôi, Quỳnh Lưu, Nghệ An',1),(13,'kh03','Thôn 2,Quỳnh Đôi, Quỳnh Lưu, Nghệ An',0),(14,'kh03','Ngõ 31 Kim Liên, Lương Định Của,Đống Đa, Hà Nội',1),(24,'kh02','Thôn 1, Quỳnh Đôi, Quỳnh Lưu, Nghệ An',1),(25,'kh01','Ngõ 31, C3 Khu tập thể Kim Liên, Đống Đa, Hà Nội',0),(27,'kh08','Khu tập thể C3 Kim Liên, Lương Định Của, Đống Đa, Hà Nội',1),(29,'kh09','Thôn 1, Quỳnh Đôi, Quỳnh Lưu, Nghệ An, VietNam',0),(30,'kh09','Thôn 2,Quỳnh Đôi, Quỳnh Lưu',1),(33,'kh10','tổ 10 khu 2',1);
/*!40000 ALTER TABLE `diachi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donhang` (
  `maDonHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maKhachHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ngayLapDon` date NOT NULL,
  `diaChiKhachHang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tongGiaTri` int NOT NULL,
  `tinhTrang` int NOT NULL,
  `phuongThucThanhToan` int NOT NULL,
  `tinhTrangThanhToan` int NOT NULL,
  PRIMARY KEY (`maDonHang`),
  KEY `maKhachHang` (`maKhachHang`),
  CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`maKhachHang`) REFERENCES `khachhang` (`maKhachHang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donhang`
--

LOCK TABLES `donhang` WRITE;
/*!40000 ALTER TABLE `donhang` DISABLE KEYS */;
INSERT INTO `donhang` VALUES ('DH1','kh10','2024-07-10','tổ 10 khu 2',745050,4,1,2),('DH10','kh10','2024-07-10','tổ 10 khu 2',15000,1,1,2),('DH11','kh10','2024-07-10','tổ 10 khu 2',15000,1,1,2),('DH12','kh10','2024-07-10','tổ 10 khu 2',210000,1,1,2),('DH13','kh10','2024-07-10','tổ 10 khu 2',1380000,1,1,2),('DH14','kh10','2024-07-10','tổ 10 khu 2',15000,1,1,2),('DH15','kh10','2024-07-10','tổ 10 khu 2',940000,1,1,2),('DH16','kh10','2024-07-10','tổ 10 khu 2',1084500,1,1,2),('DH17','kh10','2024-07-10','tổ 10 khu 2',935000,1,1,2),('DH18','kh10','2024-07-10','tổ 10 khu 2',740000,1,1,2),('DH19','kh10','2024-07-10','tổ 10 khu 2',780000,1,1,2),('DH2','kh10','2024-07-10','tổ 10 khu 2',745050,1,1,2),('DH20','kh01','2024-07-10','Thôn 1, Quỳnh Đôi, Quỳnh Lưu, Nghệ An',230000,1,1,2),('DH3','kh10','2024-07-10','tổ 10 khu 2',745050,1,1,2),('DH4','kh10','2024-07-10','tổ 10 khu 2',230000,1,1,2),('DH5','kh10','2024-07-10','tổ 10 khu 2',15000,1,1,2),('DH6','kh10','2024-07-10','tổ 10 khu 2',196350,1,1,2),('DH7','kh10','2024-07-10','tổ 10 khu 2',196350,1,1,2),('DH8','kh10','2024-07-10','tổ 10 khu 2',196350,1,1,2),('DH9','kh10','2024-07-10','tổ 10 khu 2',196350,1,1,2);
/*!40000 ALTER TABLE `donhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giohang`
--

DROP TABLE IF EXISTS `giohang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giohang` (
  `maKhachHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuong` int NOT NULL,
  `maSize` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  KEY `maKhachHang` (`maKhachHang`),
  KEY `maSanPham` (`maSanPham`),
  CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`maKhachHang`) REFERENCES `khachhang` (`maKhachHang`),
  CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giohang`
--

LOCK TABLES `giohang` WRITE;
/*!40000 ALTER TABLE `giohang` DISABLE KEYS */;
/*!40000 ALTER TABLE `giohang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khachhang` (
  `maKhachHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maTaiKhoan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hoTen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ngaySinh` date DEFAULT NULL,
  `maDiaChi` int DEFAULT NULL,
  `gioiTinh` int DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soDienThoai` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`maKhachHang`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `soDienThoai` (`soDienThoai`),
  KEY `maTaiKhoan` (`maTaiKhoan`),
  KEY `maDiaChi` (`maDiaChi`),
  CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`maTaiKhoan`) REFERENCES `taikhoan` (`maTaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khachhang`
--

LOCK TABLES `khachhang` WRITE;
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
INSERT INTO `khachhang` VALUES ('kh01','tk02','Nguyễn Bá Quốc Cường','2004-07-24',1,1,'daodinhbinh612004@gmail.com','0382951529',NULL),('kh02','tk03','Nguyen Bá Cường','2024-06-25',NULL,0,'cuongddd@gmail.com','0979953867',NULL),('kh03','tk04','Nguyễn Bá Nè Ha','1970-01-01',NULL,1,'thuyho@gmai.com','0382951523',NULL),('kh08','tk10','Cường Nguyễn Bá Quốc','2004-07-24',NULL,1,'clashofclans.aetrangxa@gmail.com','0979953811',NULL),('kh09','tk11','Nguyễn Bá Phú Ne',NULL,NULL,NULL,'thuyh1o@gmail.com','0979953892',NULL),('kh10','tk12','Dao Dinh Binh',NULL,NULL,NULL,'clonecuoi123@gmail.com','0379396103',NULL);
/*!40000 ALTER TABLE `khachhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khuyenmai`
--

DROP TABLE IF EXISTS `khuyenmai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khuyenmai` (
  `maKhuyenMai` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenKhuyenMai` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phanTram` int NOT NULL,
  `ngayKhuyenMai` date NOT NULL,
  `ngayHetHan` date NOT NULL,
  `trangThai` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maKhuyenMai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khuyenmai`
--

LOCK TABLES `khuyenmai` WRITE;
/*!40000 ALTER TABLE `khuyenmai` DISABLE KEYS */;
INSERT INTO `khuyenmai` VALUES ('NOUS10','Khuyễn mãi mùa thi 3',10,'2024-01-01','2025-01-01','1'),('NOUS2','Khuyễn mãi mùa thi 2',2,'2024-01-01','2025-01-01','1'),('NOUS20','Khuyễn mãi mùa thi 1',20,'2024-01-01','2025-01-01','1'),('NOUS7','Khuyễn mãi mùa thi 4',7,'2024-01-01','2029-01-01','1');
/*!40000 ALTER TABLE `khuyenmai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khuyenmaidonhang`
--

DROP TABLE IF EXISTS `khuyenmaidonhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khuyenmaidonhang` (
  `maDonHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maKhuyenMai` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  KEY `maDonHang` (`maDonHang`,`maKhuyenMai`),
  KEY `maKhuyenMai` (`maKhuyenMai`),
  CONSTRAINT `khuyenmaidonhang_ibfk_1` FOREIGN KEY (`maDonHang`) REFERENCES `donhang` (`maDonHang`),
  CONSTRAINT `khuyenmaidonhang_ibfk_2` FOREIGN KEY (`maKhuyenMai`) REFERENCES `khuyenmai` (`maKhuyenMai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khuyenmaidonhang`
--

LOCK TABLES `khuyenmaidonhang` WRITE;
/*!40000 ALTER TABLE `khuyenmaidonhang` DISABLE KEYS */;
INSERT INTO `khuyenmaidonhang` VALUES ('DH1','NOUS7'),('DH13','NOUS7'),('DH16','NOUS7'),('DH19','NOUS20'),('DH2','NOUS7'),('DH3','NOUS7'),('DH6','NOUS7'),('DH7','NOUS7'),('DH8','NOUS7'),('DH9','NOUS7');
/*!40000 ALTER TABLE `khuyenmaidonhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhacungcap`
--

DROP TABLE IF EXISTS `nhacungcap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nhacungcap` (
  `maNhaCungCap` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenNhaCungCap` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `diaChi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soDienThoai` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`maNhaCungCap`),
  KEY `tenNhaCungCap` (`tenNhaCungCap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhacungcap`
--

LOCK TABLES `nhacungcap` WRITE;
/*!40000 ALTER TABLE `nhacungcap` DISABLE KEYS */;
INSERT INTO `nhacungcap` VALUES ('MNCC1','Công ty may dệt Bắc Ninh','Bắc Ninh','ngheanvip@gmail.com','0382951529'),('MNCC2','Công ty may dệt Nam Định','Nam Định','daodinhbinh612004@gmail.com','0379396103');
/*!40000 ALTER TABLE `nhacungcap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nhanvien` (
  `maNhanVien` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maTaiKhoan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hoTen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gioiTinh` int DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soDienThoai` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`maNhanVien`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `soDienThoai` (`soDienThoai`),
  KEY `maTaiKhoan` (`maTaiKhoan`),
  CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`maTaiKhoan`) REFERENCES `taikhoan` (`maTaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhanvien`
--

LOCK TABLES `nhanvien` WRITE;
/*!40000 ALTER TABLE `nhanvien` DISABLE KEYS */;
INSERT INTO `nhanvien` VALUES ('nv01','tk06','Nguyễn Bá Quốc','1970-01-01','Đống Đa, Hà Nội',1,'cuongngba7@gmail.com','0382951529',NULL);
/*!40000 ALTER TABLE `nhanvien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phanquyen`
--

DROP TABLE IF EXISTS `phanquyen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phanquyen` (
  `maPhanQuyen` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `tenPhanQuyen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maPhanQuyen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phanquyen`
--

LOCK TABLES `phanquyen` WRITE;
/*!40000 ALTER TABLE `phanquyen` DISABLE KEYS */;
INSERT INTO `phanquyen` VALUES ('1','admin'),('2','staff'),('3','customer');
/*!40000 ALTER TABLE `phanquyen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quanly`
--

DROP TABLE IF EXISTS `quanly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quanly` (
  `maQuanLy` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maTaiKhoan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hoTen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gioiTinh` int DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soDienThoai` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maQuanLy`),
  UNIQUE KEY `soDienThoai` (`soDienThoai`),
  UNIQUE KEY `email` (`email`),
  KEY `maTaiKhoan` (`maTaiKhoan`),
  CONSTRAINT `quanly_ibfk_1` FOREIGN KEY (`maTaiKhoan`) REFERENCES `taikhoan` (`maTaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quanly`
--

LOCK TABLES `quanly` WRITE;
/*!40000 ALTER TABLE `quanly` DISABLE KEYS */;
INSERT INTO `quanly` VALUES ('ql01','tk01','Nguyễn Bá Quốc Cường','2024-06-11','Quỳnh Lưu, Nghệ An',1,'cuong@gmail.com','0382951529','');
/*!40000 ALTER TABLE `quanly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sanpham` (
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenSanPham` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `maNhaCungCap` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maDanhMuc` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maQuanLy` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `giaBan` int NOT NULL,
  `moTaSanPham` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `chitietsp` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `duongDanAnhChung` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maSanPham`),
  KEY `maQuanLy` (`maQuanLy`),
  KEY `maNhaCungCap` (`maNhaCungCap`),
  KEY `maDanhMuc` (`maDanhMuc`),
  CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maQuanLy`) REFERENCES `quanly` (`maQuanLy`),
  CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`maNhaCungCap`) REFERENCES `nhacungcap` (`maNhaCungCap`),
  CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`maDanhMuc`) REFERENCES `danhmuc` (`maDanhMuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanpham`
--

LOCK TABLES `sanpham` WRITE;
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
INSERT INTO `sanpham` VALUES ('MSP1','Áo gile cài thẳng chần bông xanh lam','MNCC1','MDM8','ql01',175000,'','/webbanhang/products/ao-gile-cai-thang-chan-bong-xanh-lam/','uploads/01720572283.webp'),('MSP10','Áo khoác chần bông màu vàng','MNCC1','MDM8','ql01',225000,'','/webbanhang/products/ao-khoac-chan-bong-mau-vang/','uploads/01720572139.webp'),('MSP11','Áo khoác chần bông màu xanh lam','MNCC1','MDM8','ql01',215000,'','/webbanhang/products/ao-khoac-chan-bong-mau-xanh-lam/','uploads/1720283387.webp '),('MSP12','Set áo jacket quần cộc chần bông violet kẻ trắng','MNCC1','MDM8','ql01',285000,'','/webbanhang/products/set-ao-jacket-quan-coc-chan-bong-violet-ke-trang/','uploads/1720283438.webp '),('MSP13','Bộ liền cộc kẻ vàng phối trắng ','MNCC1','MDM4','ql01',230000,'','/webbanhang/products/bo-lien-coc-ke-vang-phoi-trang-/','uploads/01720572200.webp'),('MSP14','Bộ liền cộc màu trắng họa tiết quả lê','MNCC1','MDM4','ql01',230000,'','/webbanhang/products/bo-lien-coc-mau-trang-hoa-tiet-qua-le/','uploads/01720507165.webp'),('MSP15','Bộ liền cộc màu trắng phối xanh lá','MNCC1','MDM4','ql01',185000,'','/webbanhang/products/bo-lien-coc-mau-trang-phoi-xanh-la/','uploads/1720283752.webp '),('MSP16','Bộ liền cộc màu xanh da trời','MNCC1','MDM4','ql01',185000,'','/webbanhang/products/bo-lien-coc-mau-xanh-da-troi/','uploads/1720283773.webp '),('MSP17','Bộ liền dài màu be đính yếm tam giác','MNCC1','MDM4','ql01',225000,'','/webbanhang/products/bo-lien-dai-mau-be-dinh-yem-tam-giac/','uploads/1720283800.webp '),('MSP18','Bộ liền dài màu be phối trắng in hình con mèo','MNCC1','MDM4','ql01',225000,'','/webbanhang/products/bo-lien-dai-mau-be-phoi-trang-in-hinh-con-meo/','uploads/1720283824.webp '),('MSP19','Bộ liền dài màu hồng chấm bi','MNCC1','MDM4','ql01',205000,'','/webbanhang/products/bo-lien-dai-mau-hong-cham-bi/','uploads/1720283848.webp '),('MSP2','Áo gile cài thẳng chần bông xanh nhạt','MNCC1','MDM8','ql01',175000,'','/webbanhang/products/ao-gile-cai-thang-chan-bong-xanh-nhat/','uploads/1720283000.webp '),('MSP20','Bộ liền dài màu vàng phối cổ trắng','MNCC1','MDM4','ql01',215000,'','/webbanhang/products/bo-lien-dai-mau-vang-phoi-co-trang/','uploads/1720283873.webp '),('MSP21','Bộ liền dài màu xanh chấm bi in họa tiết vịt','MNCC1','MDM4','ql01',200000,'','/webbanhang/products/bo-lien-dai-mau-xanh-cham-bi-in-hoa-tiet-vit/','uploads/1720283905.webp '),('MSP22','Bộ liền dài tay mix yếm in họa tiết','MNCC1','MDM4','ql01',245000,'','/webbanhang/products/bo-lien-dai-tay-mix-yem-in-hoa-tiet/','uploads/1720283935.webp '),('MSP23','Bộ romper cộc tay trắng phối hồng in cà rốt','MNCC1','MDM4','ql01',185000,'','/webbanhang/products/bo-romper-coc-tay-trang-phoi-hong-in-ca-rot/','uploads/1720283966.webp '),('MSP24','Bộ cài lệch màu be in họa tiết','MNCC1','MDM5','ql01',195000,'','/webbanhang/products/bo-cai-lech-mau-be-in-hoa-tiet/','uploads/1720284019.webp '),('MSP25','Bộ cài lệch trắng phối hồng in họa tiết','MNCC1','MDM5','ql01',195000,'','/webbanhang/products/bo-cai-lech-trang-phoi-hong-in-hoa-tiet/','uploads/1720284040.jpg '),('MSP26','Bộ cài thẳng dài áo trắng họa tiết gấu xanh','MNCC1','MDM5','ql01',195000,'','/webbanhang/products/bo-cai-thang-dai-ao-trang-hoa-tiet-gau-xanh/','uploads/1720284059.webp '),('MSP27','Bộ cài thẳng dài màu xanh in gấu','MNCC1','MDM5','ql01',185000,'','/webbanhang/products/bo-cai-thang-dai-mau-xanh-in-gau/','uploads/1720284094.jpg '),('MSP28','Bộ cài thẳng dài trắng phối xanh in hình con cua','MNCC1','MDM5','ql01',185000,'','/webbanhang/products/bo-cai-thang-dai-trang-phoi-xanh-in-hinh-con-cua/','uploads/1720284125.webp '),('MSP29','Bộ CTD Petit kẻ xanh in họa tiết cún woof ở túi','MNCC1','MDM5','ql01',185000,'','/webbanhang/products/bo-ctd-petit-ke-xanh-in-hoa-tiet-cun-woof-o-tui/','uploads/1720284144.webp '),('MSP3','Áo gile chần bông đỏ mận họa tiết','MNCC1','MDM8','ql01',175000,'','/webbanhang/products/ao-gile-chan-bong-do-man-hoa-tiet/','uploads/1720283033.webp '),('MSP30','Bộ dài cài lệch màu xanh phối trắng in hình con voi','MNCC1','MDM5','ql01',185000,'','/webbanhang/products/bo-dai-cai-lech-mau-xanh-phoi-trang-in-hinh-con-voi/','uploads/1720284192.webp '),('MSP31','Bộ dài cài thẳng màu trắng ngà','MNCC1','MDM5','ql01',210000,'','/webbanhang/products/bo-dai-cai-thang-mau-trang-nga/','uploads/1720284217.webp '),('MSP32','Bộ dài cài thẳng màu xanh nhạt hình in trang trí','MNCC1','MDM5','ql01',215000,'','/webbanhang/products/bo-dai-cai-thang-mau-xanh-nhat-hinh-in-trang-tri/','uploads/01720528462.jpg'),('MSP33','Bộ dài tay màu trắng phối tím','MNCC1','MDM5','ql01',215000,'','/webbanhang/products/bo-dai-tay-mau-trang-phoi-tim/','uploads/1720284266.webp '),('MSP34','Bộ dài tay mix mũ màu trắng phồi quần hồng','MNCC1','MDM5','ql01',235000,'','/webbanhang/products/bo-dai-tay-mix-mu-mau-trang-phoi-quan-hong/','uploads/1720284290.webp '),('MSP35','Bộ dài tay yukata màu trắng phối xanh','MNCC1','MDM5','ql01',215000,'','/webbanhang/products/bo-dai-tay-yukata-mau-trang-phoi-xanh/','uploads/1720284322.webp '),('MSP36','12','MNCC1','MDM4','ql01',2000,'','/webbanhang/products/12/','uploads/1720528599.jpg '),('MSP37','áo 22','MNCC1','MDM4','ql01',123,'','/webbanhang/products/ao-22/','uploads/1720546225.webp '),('MSP38','quần kaki','MNCC1','MDM11','ql01',2000,'','/webbanhang/products/quan-kaki/','uploads/1720547884.webp '),('MSP39','quần kaki','MNCC1','MDM11','ql01',215000,'','/webbanhang/products/quan-kaki/','uploads/1720547915.webp '),('MSP4','Áo gile hồng thêu chân chó','MNCC1','MDM8','ql01',175000,'','/webbanhang/products/ao-gile-hong-theu-chan-cho/','uploads/01720572117.webp'),('MSP5','Áo gile xanh thêu chân chó','MNCC1','MDM8','ql01',175000,'','/webbanhang/products/ao-gile-xanh-theu-chan-cho/','uploads/1720283148.webp '),('MSP6','Áo khoác bé gái màu hồng','MNCC1','MDM8','ql01',215000,'','/webbanhang/products/ao-khoac-be-gai-mau-hong/','uploads/1720283184.webp '),('MSP7','Áo khoác bomber màu ghi in họa tiết','MNCC1','MDM8','ql01',215000,'','/webbanhang/products/ao-khoac-bomber-mau-ghi-in-hoa-tiet/','uploads/1720283218.webp '),('MSP8','Áo khoác cardigan kẻ tím hình thêu trang trí','MNCC1','MDM8','ql01',225000,'','/webbanhang/products/ao-khoac-cardigan-ke-tim-hinh-theu-trang-tri/','uploads/1720283265.webp '),('MSP9','Áo khoác cardigan kẻ xanh thêu trang trí','MNCC1','MDM8','ql01',225000,'','/webbanhang/products/ao-khoac-cardigan-ke-xanh-theu-trang-tri/','uploads/1720283296.webp ');
/*!40000 ALTER TABLE `sanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sanphamyeuthich`
--

DROP TABLE IF EXISTS `sanphamyeuthich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sanphamyeuthich` (
  `maSanPhamYeuThich` int NOT NULL AUTO_INCREMENT,
  `maKhachHang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maSanPhamYeuThich`),
  KEY `maKhachHang` (`maKhachHang`),
  KEY `maSanPham` (`maSanPham`),
  CONSTRAINT `sanphamyeuthich_ibfk_1` FOREIGN KEY (`maKhachHang`) REFERENCES `khachhang` (`maKhachHang`),
  CONSTRAINT `sanphamyeuthich_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sanphamyeuthich`
--

LOCK TABLES `sanphamyeuthich` WRITE;
/*!40000 ALTER TABLE `sanphamyeuthich` DISABLE KEYS */;
INSERT INTO `sanphamyeuthich` VALUES (21,'kh01','MSP13'),(22,'kh01','MSP14'),(23,'kh01','MSP1'),(24,'kh10','MSP14');
/*!40000 ALTER TABLE `sanphamyeuthich` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `size` (
  `maSize` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenSize` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maSize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size`
--

LOCK TABLES `size` WRITE;
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` VALUES ('L','L'),('M','M'),('S','S'),('XL','XL');
/*!40000 ALTER TABLE `size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizesanpham`
--

DROP TABLE IF EXISTS `sizesanpham`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sizesanpham` (
  `maSanPham` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maSize` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuong` int NOT NULL,
  KEY `maSanPham` (`maSanPham`,`maSize`),
  KEY `maSize` (`maSize`),
  CONSTRAINT `sizesanpham_ibfk_1` FOREIGN KEY (`maSanPham`) REFERENCES `sanpham` (`maSanPham`),
  CONSTRAINT `sizesanpham_ibfk_2` FOREIGN KEY (`maSize`) REFERENCES `size` (`maSize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizesanpham`
--

LOCK TABLES `sizesanpham` WRITE;
/*!40000 ALTER TABLE `sizesanpham` DISABLE KEYS */;
INSERT INTO `sizesanpham` VALUES ('MSP1','L',1000),('MSP1','M',999),('MSP1','S',999),('MSP1','XL',1000),('MSP2','L',1000),('MSP2','M',1000),('MSP2','S',999),('MSP2','XL',1000),('MSP3','L',1000),('MSP3','M',1000),('MSP3','S',1000),('MSP3','XL',1000),('MSP4','L',1000),('MSP4','M',1000),('MSP4','S',1000),('MSP4','XL',1000),('MSP5','L',1000),('MSP5','M',1000),('MSP5','S',1000),('MSP5','XL',1000),('MSP6','L',1000),('MSP6','M',1000),('MSP6','S',1000),('MSP6','XL',1000),('MSP7','L',1000),('MSP7','M',1000),('MSP7','S',1000),('MSP7','XL',1000),('MSP8','L',1000),('MSP8','M',1000),('MSP8','S',1000),('MSP8','XL',1000),('MSP9','L',1000),('MSP9','M',1000),('MSP9','S',1000),('MSP9','XL',1000),('MSP10','L',996),('MSP10','M',1000),('MSP10','S',1000),('MSP10','XL',1000),('MSP11','L',999),('MSP11','M',1000),('MSP11','S',1000),('MSP11','XL',999),('MSP12','L',1000),('MSP12','M',1000),('MSP12','S',1000),('MSP12','XL',999),('MSP13','L',958),('MSP13','M',992),('MSP13','S',988),('MSP13','XL',999),('MSP14','L',995),('MSP14','M',995),('MSP14','S',1000),('MSP14','XL',999),('MSP15','L',1000),('MSP15','M',1000),('MSP15','S',1000),('MSP15','XL',1000),('MSP16','L',1000),('MSP16','M',1000),('MSP16','S',1000),('MSP16','XL',1000),('MSP17','L',1000),('MSP17','M',1000),('MSP17','S',1000),('MSP17','XL',1000),('MSP18','L',1000),('MSP18','M',1000),('MSP18','S',1000),('MSP18','XL',1000),('MSP19','L',1000),('MSP19','M',1000),('MSP19','S',1000),('MSP19','XL',1000),('MSP20','L',1000),('MSP20','M',1000),('MSP20','S',1000),('MSP20','XL',1000),('MSP21','L',1000),('MSP21','M',1000),('MSP21','S',1000),('MSP21','XL',1000),('MSP22','L',1000),('MSP22','M',1000),('MSP22','S',1000),('MSP22','XL',1000),('MSP23','L',1000),('MSP23','M',999),('MSP23','S',1000),('MSP23','XL',1000),('MSP24','L',1000),('MSP24','M',1000),('MSP24','S',1000),('MSP24','XL',1000),('MSP25','L',1000),('MSP25','M',1000),('MSP25','S',1000),('MSP25','XL',1000),('MSP26','L',1000),('MSP26','M',1000),('MSP26','S',1000),('MSP26','XL',999),('MSP27','L',998),('MSP27','M',1000),('MSP27','S',1000),('MSP27','XL',999),('MSP28','L',1000),('MSP28','M',1000),('MSP28','S',1000),('MSP28','XL',1000),('MSP29','L',1000),('MSP29','M',1000),('MSP29','S',1000),('MSP29','XL',1000),('MSP30','L',1000),('MSP30','M',1000),('MSP30','S',1000),('MSP30','XL',1000),('MSP31','L',1000),('MSP31','M',1000),('MSP31','S',1000),('MSP31','XL',1000),('MSP32','L',1000),('MSP32','M',1000),('MSP32','S',1000),('MSP32','XL',1000),('MSP33','L',1000),('MSP33','M',1000),('MSP33','S',1000),('MSP33','XL',1000),('MSP34','L',1000),('MSP34','M',1000),('MSP34','S',1000),('MSP34','XL',1000),('MSP35','L',1000),('MSP35','M',1000),('MSP35','S',1000),('MSP35','XL',1000),('MSP36','L',0),('MSP36','M',0),('MSP36','S',0),('MSP36','XL',0),('MSP37','L',0),('MSP37','M',0),('MSP37','S',0),('MSP37','XL',1),('MSP38','L',1),('MSP38','M',0),('MSP38','S',0),('MSP38','XL',0),('MSP39','L',1),('MSP39','M',0),('MSP39','S',0),('MSP39','XL',0);
/*!40000 ALTER TABLE `sizesanpham` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taikhoan` (
  `maTaiKhoan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tenTaiKhoan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `matKhau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `maPhanQuyen` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maTaiKhoan`),
  KEY `tenTaiKhoan` (`matKhau`),
  KEY `maPhanQuyen` (`maPhanQuyen`),
  CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`maPhanQuyen`) REFERENCES `phanquyen` (`maPhanQuyen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
INSERT INTO `taikhoan` VALUES ('tk01','admin','12ssss21','1'),('tk02','quoccuong','12ssss21','3'),('tk03','hhome','12ssss21','3'),('tk04','hhhomew','12ssss21','3'),('tk05','nhungtran','12ssss21','3'),('tk06','staffcuong','12ssss21','2'),('tk07','tuantrinh','12ssss21','3'),('tk08','tuantrinhna','12ssss21','3'),('tk09','hothithuy','12ssss21','3'),('tk10','cochaha','12ssss21','3'),('tk11','nguyenphu21','12ssss21','3'),('tk12','monsdz12','123456','3');
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-22 20:16:17
