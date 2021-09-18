<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Migration_Modify_booking extends CI_Migration

{

    public function up()

    {
        $this->db->query("ALTER TABLE booking_services ADD UNIQUE( id_booking, id_services)");
        $this->db->query("ALTER TABLE booking_detailer ADD UNIQUE( id_booking, id_services,id_detailer)");
    }



    public function down()

    {
        $this->db->query("ALTER TABLE booking_services DROP INDEX id_booking_2");
        $this->db->query("ALTER TABLE booking_detailer DROP INDEX id_booking_2");
    }
}
