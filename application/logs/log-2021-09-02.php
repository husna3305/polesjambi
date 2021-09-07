<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-02 10:11:07 --> Query error: Table 'ms_jenis_mobil' already exists - Invalid query: CREATE TABLE `ms_jenis_mobil` (
	`id_jenis_mobil` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_merk_mobil` INT(3) UNSIGNED NOT NULL,
	`jenis_mobil` VARCHAR(50) NOT NULL,
	`aktif` TINYINT(1) NOT NULL DEFAULT 1,
	`created_at` DATETIME NOT NULL,
	`created_by` INT(8) UNSIGNED NOT NULL,
	`updated_at` DATETIME NULL,
	`updated_by` INT(8) UNSIGNED NULL,
	CONSTRAINT `pk_ms_jenis_mobil` PRIMARY KEY(`id_jenis_mobil`),
	KEY `id_merk_mobil` (`id_merk_mobil`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci
ERROR - 2021-09-02 10:19:20 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Jenis_mobil.php 30
ERROR - 2021-09-02 10:19:26 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Jenis_mobil.php 30
ERROR - 2021-09-02 10:20:25 --> Severity: Error --> Call to undefined method Jenis_mobil_model::getMerkMobil() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Jenis_mobil.php 132
ERROR - 2021-09-02 10:23:31 --> Severity: Error --> Call to undefined method Jenis_mobil_model::getMerkMobil() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Jenis_mobil.php 148
ERROR - 2021-09-02 10:32:03 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Jenis_mobil.php 154
ERROR - 2021-09-02 10:53:28 --> Severity: Notice --> Undefined property: stdClass::$gambar C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Merk_mobil.php 37
ERROR - 2021-09-02 10:53:28 --> Severity: Notice --> Undefined property: stdClass::$gambar C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Merk_mobil.php 37
ERROR - 2021-09-02 10:53:28 --> Severity: Notice --> Undefined property: stdClass::$gambar C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Merk_mobil.php 37
ERROR - 2021-09-02 10:53:28 --> Severity: Notice --> Undefined property: stdClass::$gambar C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Merk_mobil.php 37
ERROR - 2021-09-02 10:53:28 --> Severity: Notice --> Undefined property: stdClass::$gambar C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Merk_mobil.php 37
ERROR - 2021-09-02 10:55:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'CASE WHEN IFNULL(mu.logo_small,'')='' THEN 'assets/images/logo-icon.png' ELSE mu' at line 2 - Invalid query: SELECT *
    CASE WHEN IFNULL(mu.logo_small,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_small END logo_small,
    CASE WHEN IFNULL(mu.logo_big,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_big END logo_big,
    
    FROM ms_merk_mobil AS mu
    WHERE 1=1
    
    LIMIT 0, 10
    
ERROR - 2021-09-02 10:56:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM ms_merk_mobil AS mu
    WHERE 1=1
    
    LIMIT 0, 10' at line 5 - Invalid query: SELECT *,
    CASE WHEN IFNULL(mu.logo_small,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_small END logo_small,
    CASE WHEN IFNULL(mu.logo_big,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_big END logo_big,
    
    FROM ms_merk_mobil AS mu
    WHERE 1=1
    
    LIMIT 0, 10
    
ERROR - 2021-09-02 12:55:55 --> 404 Page Not Found: Assets/plugins
ERROR - 2021-09-02 12:59:09 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 94
ERROR - 2021-09-02 12:59:09 --> Query error: Column 'merk_mobil' cannot be null - Invalid query: INSERT INTO `ms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 12:59:09', '1')
ERROR - 2021-09-02 13:05:19 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 94
ERROR - 2021-09-02 13:05:19 --> Query error: Column 'merk_mobil' cannot be null - Invalid query: INSERT INTO `ms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 13:05:19', '1')
ERROR - 2021-09-02 13:05:47 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 94
ERROR - 2021-09-02 13:05:47 --> Query error: Column 'merk_mobil' cannot be null - Invalid query: INSERT INTO `ms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 13:05:47', '1')
ERROR - 2021-09-02 13:12:21 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 94
ERROR - 2021-09-02 13:12:22 --> Query error: Column 'merk_mobil' cannot be null - Invalid query: INSERT INTO `ms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 13:12:22', '1')
ERROR - 2021-09-02 15:23:55 --> 404 Page Not Found: Assets/plugins
ERROR - 2021-09-02 15:23:56 --> 404 Page Not Found: Assets/plugins
ERROR - 2021-09-02 15:24:34 --> 404 Page Not Found: Assets/plugins
ERROR - 2021-09-02 16:31:53 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 94
ERROR - 2021-09-02 16:31:53 --> Query error: Column 'merk_mobil' cannot be null - Invalid query: INSERT INTO `ms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 16:31:53', '1')
ERROR - 2021-09-02 17:06:45 --> Query error: Unknown column 'id_servis' in 'field list' - Invalid query: INSERT INTO `ms_services` (`id_servis`, `judul`, `deskripsi`, `estimasi_biaya`, `estimasi_waktu_jam`, `estimasi_waktu_menit`, `aktif`, `created_at`, `created_by`) VALUES ('1', 'e', '<p>22</p>', '33', '23', '12', 1, '2021-09-02 17:06:45', '1')
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$gambar_small C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 38
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$judul C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 41
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$updated_at C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 42
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$estimasi_biaya C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 48
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$estimasi_waktu_jam C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 49
ERROR - 2021-09-02 17:09:55 --> Severity: Notice --> Undefined property: stdClass::$estimasi_waktu_menit C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 49
ERROR - 2021-09-02 17:13:27 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 29
ERROR - 2021-09-02 17:17:08 --> Severity: Error --> Call to undefined function mata_uang_rp() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 48
ERROR - 2021-09-02 17:17:47 --> Severity: Error --> Call to undefined function mata_uang_rp() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Services.php 48
ERROR - 2021-09-02 17:18:08 --> Severity: Warning --> number_format() expects parameter 2 to be long, string given C:\xampp2h\htdocs\polesjambi\application\helpers\my_helper.php 629
ERROR - 2021-09-02 17:18:35 --> Severity: Warning --> Wrong parameter count for number_format() C:\xampp2h\htdocs\polesjambi\application\helpers\my_helper.php 629
ERROR - 2021-09-02 17:20:45 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\services\services_form.php 146
ERROR - 2021-09-02 17:30:27 --> Query error: Unknown column 'response_validate' in 'where clause' - Invalid query: UPDATE `ms_services` SET `judul` = 'Pembersihan Kaca', `deskripsi` = '<p>Pembersihan Kaca</p>', `estimasi_biaya` = '12000', `estimasi_waktu_jam` = '23', `estimasi_waktu_menit` = '12', `aktif` = 1, `updated_at` = '2021-09-02 17:30:27', `updated_by` = '1'
WHERE `id_services` = '1'
AND `response_validate` = 1
ERROR - 2021-09-02 18:40:27 --> Severity: Notice --> Undefined index: id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Detailer.php 135
ERROR - 2021-09-02 18:46:45 --> Severity: Notice --> Undefined index: id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Detailer.php 198
ERROR - 2021-09-02 18:57:04 --> 404 Page Not Found: Assets/images
ERROR - 2021-09-02 18:57:23 --> 404 Page Not Found: Assets/images
ERROR - 2021-09-02 18:57:23 --> 404 Page Not Found: Assets/images
ERROR - 2021-09-02 20:20:15 --> Query error: Table 'db_polesjambi.tr_pengaturan' doesn't exist - Invalid query: SELECT * FROM tr_pengaturan WHERE aktif=1
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 63
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 64
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 80
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 81
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 97
ERROR - 2021-09-02 20:20:34 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 98
ERROR - 2021-09-02 20:21:18 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 146
ERROR - 2021-09-02 20:23:16 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 146
ERROR - 2021-09-02 20:23:46 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\pengaturan\pengaturan_form.php 146
ERROR - 2021-09-02 20:24:41 --> Severity: Notice --> Undefined index: batas_maks_booking_kedepan_per C:\xampp2h\htdocs\polesjambi\application\controllers\Pengaturan.php 30
ERROR - 2021-09-02 20:24:41 --> Severity: Notice --> Undefined index: batas_maks_pembayaran_booking_per C:\xampp2h\htdocs\polesjambi\application\controllers\Pengaturan.php 32
ERROR - 2021-09-02 20:24:41 --> Severity: Notice --> Undefined index: nominal_dp_booking_per C:\xampp2h\htdocs\polesjambi\application\controllers\Pengaturan.php 34
ERROR - 2021-09-02 20:24:41 --> Severity: Notice --> Undefined index: toleransi_keterlambatan_datang_per C:\xampp2h\htdocs\polesjambi\application\controllers\Pengaturan.php 36
ERROR - 2021-09-02 20:24:41 --> Query error: Column 'batas_maks_booking_kedepan_per' cannot be null - Invalid query: INSERT INTO `ms_pengaturan` (`batas_maks_booking_kedepan`, `batas_maks_booking_kedepan_per`, `batas_maks_pembayaran_booking`, `batas_maks_pembayaran_booking_per`, `nominal_dp_booking`, `nominal_dp_booking_per`, `toleransi_keterlambatan_datang`, `toleransi_keterlambatan_datang_per`, `aktif`, `created_at`, `created_by`) VALUES ('30', NULL, '5', NULL, '20', NULL, '30', NULL, 1, '2021-09-02 20:24:41', '1')
ERROR - 2021-09-02 20:26:05 --> Severity: Notice --> Undefined index: batas_maks_booking_kedepan_per C:\xampp2h\htdocs\polesjambi\application\controllers\Pengaturan.php 30
ERROR - 2021-09-02 20:26:05 --> Query error: Column 'batas_maks_booking_kedepan_per' cannot be null - Invalid query: INSERT INTO `ms_pengaturan` (`batas_maks_booking_kedepan`, `batas_maks_booking_kedepan_per`, `batas_maks_pembayaran_booking`, `batas_maks_pembayaran_booking_per`, `nominal_dp_booking`, `nominal_dp_booking_per`, `toleransi_keterlambatan_datang`, `toleransi_keterlambatan_datang_per`, `aktif`, `created_at`, `created_by`) VALUES ('days', NULL, '5', 'hours', '20', 'persen', '30', 'minutes', 1, '2021-09-02 20:26:05', '1')
ERROR - 2021-09-02 20:52:05 --> Query error: Table 'ms_detailer' already exists - Invalid query: CREATE TABLE `ms_detailer` (
	`id_generated` VARCHAR(5) NOT NULL,
	`tgl_libur` DATE NOT NULL,
	`keterangan_libur` VARCHAR(100) NULL,
	`created_at` DATETIME NOT NULL,
	`created_by` INT(8) UNSIGNED NOT NULL,
	`updated_at` DATETIME NULL,
	`updated_by` INT(8) UNSIGNED NULL,
	CONSTRAINT `pk_ms_detailer` PRIMARY KEY(`tgl_libur`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci
ERROR - 2021-09-02 21:01:22 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 92
ERROR - 2021-09-02 21:01:22 --> Query error: Table 'db_polesjambi.wms_merk_mobil' doesn't exist - Invalid query: INSERT INTO `wms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 1, '2021-09-02 21:01:22', '1')
ERROR - 2021-09-02 21:06:53 --> Severity: Notice --> Undefined index: merk_mobil C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 92
ERROR - 2021-09-02 21:06:53 --> Query error: Table 'db_polesjambi.wms_merk_mobil' doesn't exist - Invalid query: INSERT INTO `wms_merk_mobil` (`merk_mobil`, `aktif`, `created_at`, `created_by`) VALUES (NULL, 0, '2021-09-02 21:06:53', '1')
ERROR - 2021-09-02 21:29:34 --> Severity: Error --> Call to undefined method Merk_mobil_model::getHariLibur() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 71
ERROR - 2021-09-02 21:29:51 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 29
ERROR - 2021-09-02 21:29:51 --> Severity: Notice --> Undefined property: stdClass::$aktif C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 32
ERROR - 2021-09-02 21:29:51 --> Severity: Notice --> Undefined property: stdClass::$tgl_mullai C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 38
ERROR - 2021-09-02 21:30:06 --> Severity: Notice --> Undefined property: stdClass::$aktif C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 32
ERROR - 2021-09-02 21:30:06 --> Severity: Notice --> Undefined property: stdClass::$tgl_mullai C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 38
ERROR - 2021-09-02 21:30:19 --> Severity: Notice --> Undefined property: stdClass::$tgl_mullai C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 34
ERROR - 2021-09-02 23:34:02 --> Severity: Notice --> Undefined property: stdClass::$tgl_mullai C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 34
ERROR - 2021-09-02 23:36:16 --> Severity: Notice --> Undefined index: id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 120
ERROR - 2021-09-02 23:36:16 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 117
ERROR - 2021-09-02 23:37:05 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 117
ERROR - 2021-09-02 23:38:17 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 117
ERROR - 2021-09-02 23:38:52 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 117
ERROR - 2021-09-02 23:39:02 --> Severity: Notice --> Undefined property: stdClass::$id_merk_mobil C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 117
