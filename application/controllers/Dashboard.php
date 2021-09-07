<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends Crm_Controller
{
  var $title  = "Dashboard";
  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    // $this->load->model('leads_model', 'ld_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'admin';
    $this->template_portal($data);
  }
}
