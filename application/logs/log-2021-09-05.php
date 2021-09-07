<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-05 05:55:20 --> Severity: Notice --> Undefined property: stdClass::$id_cabang C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 32
ERROR - 2021-09-05 05:55:20 --> Severity: Notice --> Undefined property: stdClass::$id_cabang C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 32
ERROR - 2021-09-05 05:55:20 --> Severity: Notice --> Undefined property: stdClass::$id_cabang C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 32
ERROR - 2021-09-05 05:56:30 --> Severity: Compile Error --> Cannot redeclare class Kelurahan_model C:\xampp2h\htdocs\polesjambi\application\models\Cabang_model.php 100
ERROR - 2021-09-05 05:58:32 --> Query error: Not unique table/alias: 'kec' - Invalid query: SELECT *
    FROM ms_cabang AS cab
    LEFT JOIN wilayah_kelurahan kec ON kel.kelurahan_id=cab.kelurahan_id
    LEFT JOIN wilayah_kecamatan kec ON kec.kecamatan_id=cab.kecamatan_id
    LEFT JOIN wilayah_kabupaten kab ON kab.kabupaten_id=cab.kabupaten_id
    LEFT JOIN wilayah_provinsi prov ON prov.provinsi_id=cab.provinsi_id
    WHERE 1=1
    
    LIMIT 0, 10
    
ERROR - 2021-09-05 05:58:41 --> Query error: Not unique table/alias: 'kec' - Invalid query: SELECT *
    FROM ms_cabang AS cab
    LEFT JOIN wilayah_kelurahan kec ON kel.kelurahan_id=cab.kelurahan_id
    LEFT JOIN wilayah_kecamatan kec ON kec.kecamatan_id=cab.kecamatan_id
    LEFT JOIN wilayah_kabupaten kab ON kab.kabupaten_id=cab.kabupaten_id
    LEFT JOIN wilayah_provinsi prov ON prov.provinsi_id=cab.provinsi_id
    WHERE 1=1
    
    LIMIT 0, 10
    
ERROR - 2021-09-05 06:11:21 --> Severity: Error --> Call to undefined method Kabupaten_model::getProvinsi() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 97
ERROR - 2021-09-05 06:11:47 --> Severity: Notice --> Undefined index: kelurahan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 102
ERROR - 2021-09-05 06:11:47 --> Severity: Notice --> Undefined index: kelurahan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 113
ERROR - 2021-09-05 06:12:37 --> Severity: Error --> Call to undefined method Kecamatan_model::getKelurahan() C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 103
ERROR - 2021-09-05 06:12:50 --> Severity: Notice --> Undefined index: kelurahan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 114
ERROR - 2021-09-05 06:15:39 --> Severity: Notice --> Undefined index: cabang_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 146
ERROR - 2021-09-05 06:17:28 --> Severity: Notice --> Undefined index: kecamatan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 161
ERROR - 2021-09-05 06:17:28 --> Severity: Notice --> Undefined index: kelurahan C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 174
ERROR - 2021-09-05 06:17:28 --> Severity: Notice --> Undefined index: kecamatan_id C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 176
ERROR - 2021-09-05 06:20:16 --> Severity: Notice --> Undefined index: id_cabang C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Cabang.php 192
ERROR - 2021-09-05 06:32:15 --> 404 Page Not Found: cli/Migration/modify_detailer
ERROR - 2021-09-05 06:32:22 --> 404 Page Not Found: cli/Migration/generated
ERROR - 2021-09-05 06:43:43 --> 404 Page Not Found: api/private/Cabang/selectCabang
ERROR - 2021-09-05 06:47:23 --> Severity: Notice --> Undefined property: Detailer::$cab_m C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Detailer.php 99
ERROR - 2021-09-05 06:47:23 --> Severity: Error --> Call to a member function getCabang() on null C:\xampp2h\htdocs\polesjambi\application\controllers\master_data\Detailer.php 99
ERROR - 2021-09-05 06:49:47 --> Query error: Unknown column 'mu.detailer' in 'where clause' - Invalid query: SELECT mu.*,
    CASE WHEN IFNULL(mu.gambar_small,'')='' THEN 'assets/images/avatars/avatar.png' ELSE mu.gambar_small END gambar_small,
    CASE WHEN IFNULL(mu.gambar_big,'')='' THEN 'assets/images/avatars/avatar.png' ELSE mu.gambar_big END gambar_big,cab.nama_cabang
    
    FROM ms_detailer AS mu
    JOIN ms_cabang cab ON cab.id_cabang=mu.id_cabang
    WHERE 1=1 AND (mu.id_detailer LIKE '%c%'
                           OR mu.detailer LIKE '%c%'
                           OR mu.no_hp LIKE '%c%'
                           OR mu.alamat LIKE '%c%'
                           OR cab.nama_cabang LIKE '%c%'
                      )
          
          
    
    LIMIT 0, 10
    
