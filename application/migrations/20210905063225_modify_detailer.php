<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_detailer extends CI_Migration

{

    public function up()

    {

        $fields = array(
            'id_cabang' => ['type' => 'TINYINT', 'constraint' => 2, 'unsigned' => true],
            'alamat' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true]
        );
        $this->dbforge->add_column('ms_detailer', $fields);
    }



    public function down()

    {
        $this->dbforge->drop_column('ms_detailer', 'id_cabang');
        $this->dbforge->drop_column('ms_detailer', 'alamat');
    }
}
