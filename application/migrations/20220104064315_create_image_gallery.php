<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_image_gallery extends CI_Migration

{

    public function up()

    {

        $field = array(
            'id' => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true, 'unsigned' => true],
            'path_img_small' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path_img_big' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', true);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_image_gallery', FALSE, $attributes);

        $field = array(
            'id' => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true, 'unsigned' => true],
            'id_img' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'for_pages' => ['type' => 'VARCHAR', 'constraint' => 30],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', true);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_image_gallery_for', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_image_gallery');
        $this->dbforge->drop_table('ms_image_gallery_for');
    }

}