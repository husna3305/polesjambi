<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_wilayah extends CI_Migration

{

    public function up()

    {
        $this->db->trans_begin();

        $this->db->query("CREATE TABLE IF NOT EXISTS `wilayah_provinsi` (
            `provinsi_id` varchar(2) NOT NULL,
            `provinsi` varchar(30) NOT NULL,
            `aktif` tinyint(1) NOT NULL,
            PRIMARY KEY (`provinsi_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

        $this->db->query("CREATE TABLE IF NOT EXISTS `wilayah_kabupaten` (
            `kabupaten_id` varchar(4) NOT NULL,
            `provinsi_id` varchar(2) NOT NULL DEFAULT '',
            `kabupaten` varchar(30) NOT NULL,
            `aktif` tinyint(1) NOT NULL,
            PRIMARY KEY (`kabupaten_id`),
            CONSTRAINT FK_provinsi_id FOREIGN KEY (provinsi_id) REFERENCES wilayah_provinsi(provinsi_id)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

        $this->db->query("CREATE TABLE IF NOT EXISTS `wilayah_kecamatan` (
                `kecamatan_id` varchar(7) NOT NULL,
                `kabupaten_id` varchar(4) NOT NULL DEFAULT '',
                `kecamatan` varchar(30) NOT NULL,
                `aktif` tinyint(1) NOT NULL,
                PRIMARY KEY (`kecamatan_id`),
            CONSTRAINT FK_kabupaten_id FOREIGN KEY (kabupaten_id) REFERENCES wilayah_kabupaten(kabupaten_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

        $this->db->query("CREATE TABLE IF NOT EXISTS `wilayah_kelurahan` (
                `kelurahan_id` varchar(10) NOT NULL,
                `kecamatan_id` varchar(7) DEFAULT NULL,
                `kelurahan` varchar(40) DEFAULT NULL,
                `aktif` tinyint(1) NOT NULL,
                PRIMARY KEY (`kelurahan_id`),
            CONSTRAINT FK_kecamatan_id FOREIGN KEY (kecamatan_id) REFERENCES wilayah_kecamatan(kecamatan_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }



    public function down()

    {
        $this->dbforge->drop_table('wilayah_provinsi');
        $this->dbforge->drop_table('wilayah_kabupaten');
        $this->dbforge->drop_table('wilayah_kecamatan');
        $this->dbforge->drop_table('wilayah_kelurahan');
    }
}
