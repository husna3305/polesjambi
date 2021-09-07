<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: application/json');
class Mobil extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function selectMerkMobil()
  {
    $this->load->model('merk_mobil_model', 'merk');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = ['search' => $search, 'select' => 'dropdown', 'aktif' => 1];
    $response = $this->merk->getMerkMobil($filter)->result();
    send_json($response);
  }

  function selectJenisMobil()
  {
    $this->load->model('jenis_mobil_model', 'jenis');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = [
      'search' => $search,
      'select' => 'dropdown',
      'aktif' => 1
    ];
    $filter['id_merk_mobil'] = empty_to_min($this->input->post('id_merk_mobil'));
    $response = $this->jenis->getJenisMobil($filter)->result();
    send_json($response);
  }
}
