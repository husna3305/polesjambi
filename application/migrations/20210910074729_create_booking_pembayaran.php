<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_booking_pembayaran extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_booking_pembayaran' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'id_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'metode_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama_bank' => ['type' => 'VARCHAR', 'constraint' => 30],
            'jenis_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 20], //DP, Pelunasan
            'waktu_pembayaran' => ['type' => 'DATETIME'],
            'nominal_pembayaran' => ['type' => 'DOUBLE'],
            'bukti_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_booking_pembayaran', true);
        $this->dbforge->add_key('id_booking');
        $this->dbforge->add_key('metode_pembayaran');
        $this->dbforge->add_key('jenis_pembayaran');
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('booking_pembayaran', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('booking_pembayaran');
    }
}
