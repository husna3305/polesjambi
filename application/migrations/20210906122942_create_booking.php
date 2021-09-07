<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_booking extends CI_Migration

{

    public function up()

    {

        $this->dbforge->add_field(array(
            'id_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'no_polisi' => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 50],
            'no_wa' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_merk_mobil' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'id_jenis_mobil' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true,],
            'tanggal_booking' => ['type' => 'DATE'],
            'jam_booking' => ['type' => 'TIME'],
            'alamat' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'provinsi_id' => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true],
            'kabupaten_id' => ['type' => 'VARCHAR', 'constraint' => 4, 'null' => true],
            'kecamatan_id' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'kelurahan_id' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'batas_waktu_pembayaran_dp' => ['type' => 'DATETIME'],
            'total_dp' => ['type' => 'DOUBLE'],
            'nominal_unik' => ['type' => 'DOUBLE'],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_booking', TRUE);
        $this->dbforge->add_key('id_merk_mobil');
        $this->dbforge->add_key('id_jenis_mobil');
        $this->dbforge->add_key('provinsi_id');
        $this->dbforge->add_key('kabupaten_id');
        $this->dbforge->add_key('kecamatan_id');
        $this->dbforge->add_key('kelurahan_id');
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('booking', FALSE, $attributes);

        $this->dbforge->add_field(array(
            'id_booking_services' => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true, 'unsigned' => true],
            'id_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_services' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'biaya' => ['type' => 'VARCHAR', 'constraint' => 20],
            'waktu_menit' => ['type' => 'INT', 'constraint' => 10],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
            'start_at' => ['type' => 'DATETIME'],
            'end_at' => ['type' => 'DATETIME'],
        ));
        $this->dbforge->add_key('id_booking_services', true);
        $this->dbforge->add_key('id_booking');
        $this->dbforge->add_key('id_services');
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('booking_services', FALSE, $attributes);

        $this->dbforge->add_field(array(
            'id_booking_detailer' => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true, 'unsigned' => true],
            'id_booking' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_services' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'id_detailer' => ['type' => 'INT', 'constraint' => 4, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME'],
            'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => true],
        ));
        $this->dbforge->add_key('id_booking_detailer', true);
        $this->dbforge->add_key('id_booking');
        $this->dbforge->add_key('id_services');
        $this->dbforge->add_key('id_detailer');
        $this->dbforge->add_key('created_by');
        $this->dbforge->add_key('updated_by');
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table('booking_detailer', FALSE, $attributes);
    }



    public function down()
    {
        $this->dbforge->drop_table('booking');
        $this->dbforge->drop_table('booking_services');
        $this->dbforge->drop_table('booking_detailer');
    }
}
