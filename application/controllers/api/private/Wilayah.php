<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: application/json');
class Wilayah extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function selectProvinsi()
  {
    $this->load->model('provinsi_model', 'prov');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = ['search' => $search, 'select' => 'dropdown', 'aktif' => 1];
    $response = $this->prov->getProvinsi($filter)->result();
    send_json($response);
  }

  function selectKabupaten()
  {
    $this->load->model('kabupaten_model', 'kab');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = [
      'search' => $search,
      'select' => 'dropdown',
      'aktif' => 1
    ];
    if ($this->input->post('provinsi_id') != NULL) {
      $filter['provinsi_id'] = $this->input->post('provinsi_id');
    }
    $response = $this->kab->getKabupaten($filter)->result();
    send_json($response);
  }
  function selectKecamatan()
  {
    $this->load->model('kecamatan_model', 'kec');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = [
      'search' => $search,
      'select' => 'dropdown',
      'aktif' => 1
    ];
    if ($this->input->post('kabupaten_id') != NULL or $this->input->post('kabupaten_id') != '') {
      $filter['kabupaten_id'] = $this->input->post('kabupaten_id');
    }
    $response = $this->kec->getKecamatan($filter)->result();
    send_json($response);
  }
  function selectKelurahan()
  {
    $this->load->model('kelurahan_model', 'kel');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = [
      'search' => $search,
      'select' => 'dropdown',
      'aktif' => 1
    ];
    if ($this->input->post('kecamatan_id') != NULL or $this->input->post('kecamatan_id') != '') {
      $filter['kecamatan_id'] = $this->input->post('kecamatan_id');
    }
    $response = $this->kel->getKelurahan($filter)->result();
    send_json($response);
  }
}
