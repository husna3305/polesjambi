<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_detailer extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_detailer' => ['type' => 'INT', 'constraint' => 4, 'unsigned' => true, 'auto_increment' => true],
            'nama_detailer' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'gambar_small' => ['type' => 'VARCHAR', 'constraint' => '250', 'null' => true],
            'gambar_big' => ['type' => 'VARCHAR', 'constraint' => '250', 'null' => true],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_detailer', TRUE);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_detailer', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_detailer');
    }
}
