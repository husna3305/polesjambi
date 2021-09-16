<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_services extends CI_Migration

{

    public function up()

    {

        $fields = array(
            'kategori' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        );
        $this->dbforge->add_column('ms_services', $fields);
    }



    public function down()

    {
        $this->dbforge->drop_column('ms_services', 'kategori');
    }
}
