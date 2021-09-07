<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_cabang extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_cabang' => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true, 'auto_increment' => true],
            'nama_cabang' => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi_cabang' => ['type' => 'TEXT', 'null' => true],
            'no_hp_cabang' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'no_telp_cabang' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'kepala_cabang' => ['type' => 'VARCHAR', 'constraint' => 50],
            'alamat' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'provinsi_id' => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true],
            'kabupaten_id' => ['type' => 'VARCHAR', 'constraint' => 4, 'null' => true],
            'kecamatan_id' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'kelurahan_id' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_cabang', TRUE);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_cabang', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_cabang');
    }
}
