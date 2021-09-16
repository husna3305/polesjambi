<?php

use GO\Scheduler;

class Auto_updated_status extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    //Cek Status Sudah Lu
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
