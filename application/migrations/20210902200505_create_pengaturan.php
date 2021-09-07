<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Create_pengaturan extends CI_Migration

{

  public function up()

  {

    $this->dbforge->add_field(array(
      'id_pengaturan' => ['type' => 'INT', 'constraint' => 4, 'unsigned' => true, 'auto_increment' => true],
      'batas_maks_booking_kedepan' => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
      'batas_maks_booking_kedepan_per' => ['type' => 'VARCHAR', 'constraint' => 20],
      'batas_maks_pembayaran_booking' => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
      'batas_maks_pembayaran_booking_per' => ['type' => 'VARCHAR', 'constraint' => 20],
      'nominal_dp_booking' => ['type' => 'DOUBLE', 'default' => 0],
      'nominal_dp_booking_per' => ['type' => 'VARCHAR', 'constraint' => 20],
      'toleransi_keterlambatan_datang' => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
      'toleransi_keterlambatan_datang_per' => ['type' => 'VARCHAR', 'constraint' => 20],
      'aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
      'created_at' => ['type' => 'DATETIME'],
      'created_by' => ['type' => 'INT', 'constraint' => 8, 'unsigned' => TRUE],
    ));
    $this->dbforge->add_key('id_pengaturan', TRUE);
    $attributes = array('ENGINE' => 'InnoDB');
    $this->dbforge->create_table('ms_pengaturan', FALSE, $attributes);
  }



  public function down()

  {
    $this->dbforge->drop_table('ms_pengaturan');
  }
}
