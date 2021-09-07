<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-03 11:01:13 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 C:\xampp2h\htdocs\polesjambi\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2021-09-03 11:01:13 --> Unable to connect to the database
ERROR - 2021-09-03 11:01:13 --> Severity: Error --> Class 'CI_Controller' not found C:\xampp2h\htdocs\polesjambi\system\core\CodeIgniter.php 345
ERROR - 2021-09-03 11:51:49 --> 404 Page Not Found: master_data/Hari_libur/getListForCalendar
ERROR - 2021-09-03 11:51:55 --> 404 Page Not Found: master_data/Hari_libur/getListForCalendar
ERROR - 2021-09-03 12:15:58 --> Query error: Duplicate entry '2021-09-03' for key 'PRIMARY' - Invalid query: INSERT INTO `ms_hari_libur` (`created_at`, `created_by`, `id_generated`, `keterangan_libur`, `tgl_libur`) VALUES ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-03'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-04'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-05'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-06'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-07'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-08'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-09'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-10'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-11'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-12'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-13'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-14'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-15'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-16'), ('2021-09-03 12:15:58','1','ULxOC','has','2021-09-17')
ERROR - 2021-09-03 14:32:33 --> Severity: Notice --> Undefined variable: row C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 120
ERROR - 2021-09-03 14:32:33 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 120
ERROR - 2021-09-03 14:35:01 --> Severity: Notice --> Undefined variable: row C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 120
ERROR - 2021-09-03 14:35:01 --> Severity: Notice --> Trying to get property of non-object C:\xampp2h\htdocs\polesjambi\application\views\master_data\hari_libur\hari_libur_form.php 120
ERROR - 2021-09-03 15:29:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 93
ERROR - 2021-09-03 15:29:16 --> Severity: Notice --> Undefined variable: inserts C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Hari_libur.php 106
ERROR - 2021-09-03 17:58:12 --> Query error: Key column 'id' doesn't exist in table - Invalid query: CREATE TABLE IF NOT EXISTS `wilayah_provinsi` (
            `provinsi_id` varchar(2) NOT NULL,
            `provinsi` varchar(30) NOT NULL,
            `aktif` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ERROR - 2021-09-03 18:01:43 --> Query error: Can't create table `db_polesjambi`.`wilayah_kecamatan` (errno: 150 "Foreign key constraint is incorrectly formed") - Invalid query: CREATE TABLE IF NOT EXISTS `wilayah_kecamatan` (
                `kecamatan_id` varchar(7) NOT NULL,
                `kabupaten_id` varchar(4) NOT NULL DEFAULT '',
                `kecamatan` varchar(30) NOT NULL,
                `aktif` tinyint(1) NOT NULL,
                PRIMARY KEY (`kecamatan_id`),
            CONSTRAINT FK_kabupaten_id FOREIGN KEY (kabupaten_id) REFERENCES wilayah_provinsi(kabupaten_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ERROR - 2021-09-03 18:03:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '`aktif` tinyint(1) NOT NULL,
                PRIMARY KEY (`kelurahan_id`)
    ' at line 6 - Invalid query: CREATE TABLE IF NOT EXISTS `wilayah_kelurahan` (
                `kelurahan_id` varchar(10) NOT NULL,
                `kecamatan_id` varchar(7) DEFAULT NULL,
                `kelurahan` varchar(40) DEFAULT NULL,
            CONSTRAINT FK_kecamatan_id FOREIGN KEY (kecamatan_id) REFERENCES wilayah_kecamatan(kecamatan_id)
                `aktif` tinyint(1) NOT NULL,
                PRIMARY KEY (`kelurahan_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ERROR - 2021-09-03 18:04:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'PRIMARY KEY (`kelurahan_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=la' at line 7 - Invalid query: CREATE TABLE IF NOT EXISTS `wilayah_kelurahan` (
                `kelurahan_id` varchar(10) NOT NULL,
                `kecamatan_id` varchar(7) DEFAULT NULL,
                `kelurahan` varchar(40) DEFAULT NULL,
                `aktif` tinyint(1) NOT NULL,
            CONSTRAINT FK_kecamatan_id FOREIGN KEY (kecamatan_id) REFERENCES wilayah_kecamatan(kecamatan_id)
                PRIMARY KEY (`kelurahan_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ERROR - 2021-09-03 18:45:49 --> Severity: Error --> Call to undefined method Merk_mobil_model::getProvinsi() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 69
ERROR - 2021-09-03 18:45:56 --> Severity: Error --> Call to undefined method Merk_mobil_model::getProvinsi() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 69
ERROR - 2021-09-03 18:46:12 --> Query error: Table 'db_polesjambi.ms_provinsi' doesn't exist - Invalid query: SELECT *
    FROM ms_provinsi AS mu
    WHERE 1=1
    
    LIMIT 0, 10
    
ERROR - 2021-09-03 18:49:29 --> Severity: Notice --> Undefined index: id_provinsi C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 86
ERROR - 2021-09-03 18:49:29 --> Severity: Notice --> Undefined index: provinsi C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 94
ERROR - 2021-09-03 18:49:51 --> Severity: Notice --> Undefined index: provinsi C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 94
ERROR - 2021-09-03 18:50:33 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Provinsi.php 29
ERROR - 2021-09-03 18:56:25 --> Query error: Duplicate entry '15' for key 'PRIMARY' - Invalid query: INSERT INTO `wilayah_provinsi` (`provinsi_id`, `provinsi`, `aktif`) VALUES ('153', 'f', 1)
ERROR - 2021-09-03 19:03:42 --> Query error: Unknown column 'mu.provinsi' in 'where clause' - Invalid query: SELECT *
    FROM wilayah_kabupaten AS mu
    JOIN wilayah_provinsi prov ON prov.provinsi_id=mu.provinsi_id
    WHERE 1=1 AND (mu.provinsi_id LIKE '%d%'
                           OR mu.provinsi LIKE '%d%'
                           OR mu.kabupaten LIKE '%d%'
                           OR mu.kabupaten_id LIKE '%d%'
                      )
          
          
    
    LIMIT 0, 10
    
ERROR - 2021-09-03 19:03:44 --> Query error: Unknown column 'mu.provinsi' in 'where clause' - Invalid query: SELECT *
    FROM wilayah_kabupaten AS mu
    JOIN wilayah_provinsi prov ON prov.provinsi_id=mu.provinsi_id
    WHERE 1=1 AND (mu.provinsi_id LIKE '%de%'
                           OR mu.provinsi LIKE '%de%'
                           OR mu.kabupaten LIKE '%de%'
                           OR mu.kabupaten_id LIKE '%de%'
                      )
          
          
    
    LIMIT 0, 10
    
ERROR - 2021-09-03 19:13:20 --> Severity: Error --> Call to undefined method stdClass::row() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kabupaten_kota.php 87
ERROR - 2021-09-03 19:15:00 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kabupaten_kota.php 30
ERROR - 2021-09-03 19:22:29 --> Query error: Table 'db_polesjambi.wailayah_kabupaten' doesn't exist - Invalid query: UPDATE `wailayah_kabupaten` SET `kabupaten` = 'fefwevf', `kabupaten_id` = '1112', `provinsi_id` = '15', `aktif` = 1
WHERE `kabupaten_id` = '123'
ERROR - 2021-09-03 19:44:52 --> Severity: Notice --> Undefined index: id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kecamatan.php 130
ERROR - 2021-09-03 19:44:52 --> Severity: Error --> Call to undefined method Kecamatan_model::getMerkMobil() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kecamatan.php 131
ERROR - 2021-09-03 19:59:10 --> Query error: Unknown column 'mu.kabupaten_id' in 'on clause' - Invalid query: SELECT *
    FROM wilayah_kelurahan AS mu
    JOIN wilayah_kecamatan kec ON kec.kecamatan_id=mu.kecamatan_id
    JOIN wilayah_kabupaten kab ON kab.kabupaten_id=mu.kabupaten_id
    JOIN wilayah_provinsi prov ON prov.provinsi_id=kab.provinsi_id
    WHERE 1=1 AND mu.kelurahan_id='3333333333'
    
    
    
ERROR - 2021-09-03 19:59:58 --> Severity: Notice --> Undefined index: kalurahan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 102
ERROR - 2021-09-03 19:59:58 --> Query error: Unknown column 'kalurahan_id' in 'field list' - Invalid query: INSERT INTO `wilayah_kelurahan` (`kelurahan`, `kalurahan_id`, `kecamatan_id`, `aktif`) VALUES ('few', NULL, '2233333', 1)
ERROR - 2021-09-03 20:00:34 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 30
ERROR - 2021-09-03 20:00:34 --> Severity: Notice --> Undefined property: stdClass::$kabupaten_kota C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 41
ERROR - 2021-09-03 20:00:56 --> Severity: Notice --> Undefined property: stdClass::$kabupaten_kota C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 41
ERROR - 2021-09-03 20:04:57 --> Severity: Notice --> Undefined index: id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 131
ERROR - 2021-09-03 20:09:54 --> Severity: Notice --> Undefined index: kecamatan C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 146
ERROR - 2021-09-03 20:09:54 --> Severity: Notice --> Undefined index: kelurahan_id_old C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 149
ERROR - 2021-09-03 20:10:26 --> Severity: Notice --> Undefined index: kelurahan_id_old C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 149
ERROR - 2021-09-03 20:11:08 --> Severity: Notice --> Undefined index: kelurahan_id_old C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Kelurahan.php 149
ERROR - 2021-09-03 22:34:59 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 C:\xampp2h\htdocs\polesjambi\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2021-09-03 22:34:59 --> Unable to connect to the database
ERROR - 2021-09-03 22:34:59 --> Severity: Error --> Class 'CI_Controller' not found C:\xampp2h\htdocs\polesjambi\system\core\CodeIgniter.php 345
ERROR - 2021-09-03 22:35:10 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 C:\xampp2h\htdocs\polesjambi\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2021-09-03 22:35:10 --> Unable to connect to the database
ERROR - 2021-09-03 22:35:10 --> Severity: Error --> Class 'CI_Controller' not found C:\xampp2h\htdocs\polesjambi\system\core\CodeIgniter.php 345
ERROR - 2021-09-03 23:41:50 --> Severity: Error --> Call to undefined function user() C:\xampp2h\htdocs\polesjambi\application\controllers\api\private\Theme.php 14
ERROR - 2021-09-03 23:42:16 --> Severity: Error --> Call to undefined function user() C:\xampp2h\htdocs\polesjambi\application\controllers\api\private\Theme.php 15
ERROR - 2021-09-03 23:48:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'sSELECT * FROm setting_theme_customizer WHERE id_user=1' at line 1 - Invalid query: sSELECT * FROm setting_theme_customizer WHERE id_user=1
ERROR - 2021-09-03 23:49:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'sSELECT * FROm setting_theme_customizer WHERE id_user=1' at line 1 - Invalid query: sSELECT * FROm setting_theme_customizer WHERE id_user=1
