<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_biaya_tambahan extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_tambahan' => ['type' => 'INT', 'constraint' => 3, 'auto_increment' => true, 'unsigned' => true],
            'deskripsi_tambahan' => ['type' => 'VARCHAR', 'constraint' => 60],
            'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'deleted' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_tambahan', true);
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('ms_biaya_tambahan', FALSE, $attributes);

        $this->dbforge->add_field(array(
            'id_booking_biaya_tambahan' => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true, 'unsigned' => true],
            'id_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_tambahan' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'keterangan_lainnya' => ['type' => 'VARCHAR', 'constraint' => 60],
            'nominal'    => ['type' => 'DOUBLE'],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_booking_biaya_tambahan', true);
        $this->dbforge->add_key('id_booking');
        $this->dbforge->add_key('id_tambahan');
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('booking_biaya_tambahan', FALSE, $attributes);
    }



    public function down()

    {
        $this->dbforge->drop_table('ms_biaya_tambahan');
        $this->dbforge->drop_table('booking_biaya_tambahan');
    }
}
