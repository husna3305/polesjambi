<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_jenis_mobil extends CI_Migration

{

    public function up()

    {
        $this->dbforge->add_field(array(
            'id_jenis_mobil' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'id_merk_mobil' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'jenis_mobil' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_jenis_mobil', TRUE);
        $this->dbforge->add_key('id_merk_mobil');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_jenis_mobil', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_jenis_mobil');
    }
}
