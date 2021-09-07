<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_hari_libur extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_generated' => ['type' => 'VARCHAR', 'constraint' => '5'],
            'tgl_libur' => ['type' => 'DATE'],
            'keterangan_libur' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('tgl_libur', TRUE);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_hari_libur', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_hari_libur');
    }
}
