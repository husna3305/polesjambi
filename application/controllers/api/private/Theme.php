<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: application/json');
class Theme extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('my');
    $this->load->helper('authit');
  }

  function setTheme()
  {
    $id_user = user()->id_user;
    $field = $this->input->post('field');
    $cek = $this->db->query("SELECT id_user FROm setting_theme_customizer WHERE id_user=$id_user")->row();
    if ($cek == null) {
      $insert = [
        'id_user'     => $id_user,
        $this->input->post('field') => $this->input->post('theme'),
        'created_at'  => waktu(),
        'created_by'  => $id_user,
      ];
      $this->db->insert('setting_theme_customizer', $insert);
    } else {
      $upd = [
        $this->input->post('field') => $this->input->post('theme'),
        'updated_at'  => waktu(),
        'updated_by'  => $id_user,
      ];
      if ($field == 'theme_style') {
        $upd['header_colors'] = '';
        $upd['sidebar_background'] = '';
      }
      $cond = ['id_user' => $id_user];
      $this->db->update('setting_theme_customizer', $upd, $cond);
    }
    send_json(['status' => 1]);
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
    if ($this->input->post('kecamatan_id') != NULL or $this->input->post('kecamatan_id') != '') {
      $filter['kecamatan_id'] = $this->input->post('kecamatan_id');
    }
    $response = $this->kec->getKecamatan($filter)->result();
    send_json($response);
  }
  function selectKelurahan()
  {
    $this->load->model('kelurahan_model', 'ms');
    $search = null;
    if (isset($_POST['searchTerm'])) {
      $search = $_POST['searchTerm'];
    }
    $filter = [
      'search' => $search,
      'select' => 'dropdown',
      'aktif' => 1
    ];
    if ($this->input->post('id_kecamatan') != NULL or $this->input->post('id_kecamatan') != '') {
      $filter['id_kecamatan'] = $this->input->post('id_kecamatan');
    }
    $response = $this->ms->getKelurahan($filter)->result();
    send_json($response);
  }
}
