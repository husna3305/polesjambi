<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_services extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_services' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'deskripsi' => ['type' => 'TEXT'],
            'estimasi_waktu_jam' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            'estimasi_waktu_menit' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            'estimasi_biaya' => ['type' => 'DOUBLE', 'default' => 0],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_services', TRUE);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_services', FALSE, $attributes);

        $this->dbforge->add_field(array(
            'id_services' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'id_gambar' => ['type' => 'INT', 'constraint' => 2, 'unsigned' => true],
            'utama' => ['type' => 'TINYINT', 'constraint' => 1],
            'gambar_small' => ['type' => 'VARCHAR', 'constraint' => '300', 'null' => true],
            'gambar_big' => ['type' => 'VARCHAR', 'constraint' => '300', 'null' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_services');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_services_gambar', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_services');
        $this->dbforge->drop_table('ms_services_gambar');
    }
}
