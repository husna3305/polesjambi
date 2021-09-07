<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_merk_mobil extends CI_Migration

{

    public function up()

    {

        $fields = array(
            'logo_big' => array('type' => 'VARCHAR', 'constraint' => '300', 'null' => true),
            'logo_small' => array('type' => 'VARCHAR', 'constraint' => '300', 'null' => true)
        );
        $this->dbforge->add_column('ms_merk_mobil', $fields);
    }



    public function down()

    {
        $this->dbforge->drop_column('ms_merk_mobil', 'logo_big');
        $this->dbforge->drop_column('ms_merk_mobil', 'logo_small');
    }
}
