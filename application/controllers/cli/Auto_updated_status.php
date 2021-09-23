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
    $this->_cek_expired_pelunasan_dp();
    $this->_set_kedatangan();
    $this->_set_tidak_datang();
  }
  public function _cek_expired_pelunasan_dp()
  {
    //Cek Expired Pelunasan DP
    $this->db->query("UPDATE booking SET status='expired_pelunasan_dp' WHERE batas_waktu_pembayaran_dp<=NOW() AND status='menunggu_pembayaran'");
  }

  public function _set_kedatangan()
  {
    //Cek dan Set Menunggu Kedatangan
    $this->db->query("UPDATE booking SET status='menunggu_kedatangan' WHERE tanggal_booking=DATE(NOW()) AND status='dp_lunas'");
  }

  public function _set_tidak_datang()
  {
    //Cek dan Set Tidak Datang
    $this->db->query("UPDATE booking SET status='tidak_datang' WHERE tanggal_booking<DATE(NOW()) AND status='menunggu_kedatangan'");
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
