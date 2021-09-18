<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_booking_services extends CI_Migration

{

    public function up()

    {
        $fields = array(
            'tambahan' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'batal' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        );
        $this->dbforge->add_column('booking_services', $fields);
        $this->dbforge->add_column('booking_detailer', $fields);
    }

    public function down()

    {
        $this->dbforge->drop_column('booking_services', 'tambahan');
        $this->dbforge->drop_column('booking_services', 'batal');
        $this->dbforge->drop_column('booking_detailer', 'tambahan');
        $this->dbforge->drop_column('booking_detailer', 'batal');
    }
}
