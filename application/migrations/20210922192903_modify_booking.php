<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_booking extends CI_Migration

{

    public function up()

    {
        $fields = array(
            'no_polisi_no_space' => ['type' => 'VARCHAR', 'constraint' => 20]
        );
        $this->dbforge->add_column('booking', $fields);
    }



    public function down()

    {
        $this->dbforge->drop_column('booking', 'no_polisi_no_space');
    }
}
