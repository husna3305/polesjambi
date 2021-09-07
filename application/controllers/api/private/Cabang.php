<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: application/json');
class Cabang extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function selectCabang()
  {
    $this->load->model('cabang_model', 'cab');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = ['search' => $search, 'select' => 'dropdown', 'aktif' => 1];
    $response = $this->cab->getCabang($filter)->result();
    send_json($response);
  }
}
