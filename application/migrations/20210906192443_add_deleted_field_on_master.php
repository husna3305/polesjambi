<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Add_deleted_field_on_master extends CI_Migration

{

    public function up()

    {
        $fields = array(
            'deleted' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'default' => 0]
        );
        $this->dbforge->add_column('ms_merk_mobil', $fields);
        $this->dbforge->add_column('ms_services', $fields);
        $this->dbforge->add_column('ms_users', $fields);
        $this->dbforge->add_column('ms_cabang', $fields);
        $this->dbforge->add_column('ms_detailer', $fields);
        $this->dbforge->add_column('ms_hari_libur', $fields);
        $this->dbforge->add_column('ms_jenis_mobil', $fields);
        $this->dbforge->add_column('wilayah_kabupaten', $fields);
        $this->dbforge->add_column('wilayah_kecamatan', $fields);
        $this->dbforge->add_column('wilayah_kelurahan', $fields);
        $this->dbforge->add_column('wilayah_provinsi', $fields);
    }


    public function down()

    {
        $this->dbforge->drop_column('ms_merk_mobil', 'deleted');
        $this->dbforge->drop_column('ms_services', 'deleted');
        $this->dbforge->drop_column('ms_users', 'deleted');
        $this->dbforge->drop_column('ms_cabang', 'deleted');
        $this->dbforge->drop_column('ms_detailer', 'deleted');
        $this->dbforge->drop_column('ms_hari_libur', 'deleted');
        $this->dbforge->drop_column('ms_jenis_mobil', 'deleted');
        $this->dbforge->drop_column('wilayah_kabupaten', 'deleted');
        $this->dbforge->drop_column('wilayah_kecamatan', 'deleted');
        $this->dbforge->drop_column('wilayah_kelurahan', 'deleted');
        $this->dbforge->drop_column('wilayah_provinsi', 'deleted');
    }
}
