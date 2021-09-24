<?php

use GO\Scheduler;

class Auto_updated_status extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $ket = "Scheduler";
    $val = $this->_cek_expired_pelunasan_dp();
    $ket .= ", $val Exp. Pelunasan DP";
    $val = $this->_set_kedatangan();
    $ket .= ", $val Set Kedatangan";
    $val = $this->_set_tidak_datang();
    $ket .= ", $val Set Tidak Datang";
    $this->db->insert('cron_scheduler', ['from' => $ket]);
  }
  public function _cek_expired_pelunasan_dp()
  {
    //Cek Expired Pelunasan DP
    $this->db->query("UPDATE booking SET status='expired_pelunasan_dp' WHERE batas_waktu_pembayaran_dp<=NOW() AND status='menunggu_pembayaran'");
    return $this->db->affected_rows();
  }

  public function _set_kedatangan()
  {
    //Cek dan Set Menunggu Kedatangan
    $this->db->query("UPDATE booking SET status='menunggu_kedatangan' WHERE tanggal_booking=DATE(NOW()) AND status='dp_lunas'");
    return $this->db->affected_rows();
  }

  public function _set_tidak_datang()
  {
    //Cek dan Set Tidak Datang
    $this->db->query("UPDATE booking SET status='tidak_datang' WHERE tanggal_booking<DATE(NOW()) AND status='menunggu_kedatangan'");
    return $this->db->affected_rows();
  }

  public function scheduler()
  {
    $scheduler = new Scheduler();
    $scheduler->call(function () {
      $cron_scheduler = ['created_at' => waktu(), 'from' => 'schedulerLeadsTransactionTable'];
      $this->db->insert('cron_scheduler', $cron_scheduler);
    })->everyMinute(5);

    $scheduler->run();
  }
}
