<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_hari_libur_selalu extends CI_Migration

{

    public function up()

    {

        $field = array(
            'id' => ['type' => 'INT', 'constraint' => 3, 'auto_increment' => true, 'unsigned' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        );
        foreach (list_hari() as $key => $val) {
            $k = str_replace("'", '', $key);
            $field[$k] = ['type' => 'TINYINT', 'constraint' => 1];
        }

        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', true);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_hari_libur_selalu', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_hari_libur_selalu');
    }
}
