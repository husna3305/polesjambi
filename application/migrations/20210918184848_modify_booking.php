<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_booking extends CI_Migration

{

    public function up()

    {

        $fields = array(
            'selesai_at' => ['type' => 'DATETIME', 'null' => true],
            'selesai_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        );
        $this->dbforge->add_column('booking', $fields);
    }



    public function down()

    {
        $this->dbforge->drop_column('booking', 'selesai_at');
        $this->dbforge->drop_column('booking', 'selesai_by');
    }
}
