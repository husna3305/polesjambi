<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_testimoni extends CI_Migration

{

    public function up()

    {

        $field = array(
            'id' => ['type' => 'INT', 'constraint' => 5, 'auto_increment' => true, 'unsigned' => true],
            'path_img_small' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path_img_big' => ['type' => 'VARCHAR', 'constraint' => 255],
            'teks_testimoni' => ['type' => 'TINYTEXT'],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 60],
            'pekerjaan' => ['type' => 'VARCHAR', 'constraint' => 60],
            'deleted' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 0],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', true);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_testimoni', FALSE, $attributes);

    }



    public function down()

    {

        $this->dbforge->drop_table('ms_testimoni');
        

    }

}