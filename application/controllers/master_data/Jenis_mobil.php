<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Jenis_mobil extends Crm_Controller
{
  var $title  = "Jenis Mobil";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('jenis_mobil_model', 'jns_m');
    $this->load->model('merk_mobil_model', 'merk_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'jenis_mobil_index';
    $this->template_portal($data);
  }

  public function fetchData()
  {
    $fetch_data = $this->_makeQuery();
    $user = user();
    $data = array();
    $no = $this->input->post('start') + 1;
    foreach ($fetch_data as $rs) {
      $params      = [
        'get'   => "id = " . $rs->id_jenis_mobil
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $sub_array   = array();
      $sub_array[] = $no;
      $sub_array[] = $rs->jenis_mobil;
      $sub_array[] = $rs->merk_mobil;
      $sub_array[] = $aktif;
      $sub_array[] = link_on_data_details($params, $user->id_group);
      $data[]      = $sub_array;
      $no++;
    }
    $output = array(
      "draw"            => intval($_POST["draw"]),
      "recordsFiltered" => $this->_makeQuery(true),
      "data"            => $data
    );
    echo json_encode($output);
  }

  function _makeQuery($recordsFiltered = false)
  {
    $start  = $this->input->post('start');
    $length = $this->input->post('length');
    $limit  = "LIMIT $start, $length";
    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST['order'] : '',
      'search' => $this->input->post('search')['value'],
      'order_column' => 'view',
      'deleted' => 0
    ];
    if ($recordsFiltered == true) {
      return $this->jns_m->getJenisMobil($filter)->num_rows();
      return 1;
    } else {
      return $this->jns_m->getJenisMobil($filter)->result();
      // $sample[] = ['id' => 1, 'merk_mobil' => 'Toyota', 'jenis_mobil' => 'Avanza', 'aktif' => 1];
      // $sample = json_decode(json_encode($sample), FALSE);
      // return $sample;
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'jenis_mobil_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $this->load->library('upload');
    $post     = $this->input->post();

    $f_merk = ['id_merk_mobil' => $post['id_merk_mobil']];
    $cek_merk = $this->merk_m->getMerkMobil($f_merk)->row();
    if ($cek_merk == null) {
      $response = ['status' => 0, 'pesan' => 'ID Merk Mobil : ' . $post['id_merk_mobil'] . ' tidak ditemukan'];
      send_json($response);
    }
    $insert = [
      'id_merk_mobil' => $post['id_merk_mobil'],
      'jenis_mobil' => $post['jenis_mobil'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_jenis_mobil', $insert);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug())
      ];
      $this->session->set_flashdata(msg_sukses_simpan());
    }
    send_json($response);
  }

  public function edit()
  {
    $data['title'] = 'Edit ' . $this->title;
    $data['file']  = 'jenis_mobil_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_jenis_mobil']  = $params['id'];
    $row = $this->jns_m->getJenisMobil($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      // send_json($data);
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  public function saveEdit()
  {
    $user = user();
    $this->load->library('upload');
    $post     = $this->input->post();

    $filter = ['id_jenis_mobil' => $this->input->post('id_jenis_mobil'), 'response_validate' => true];
    $this->jns_m->getJenisMobil($filter);

    $filter = ['id_merk_mobil' => $this->input->post('id_merk_mobil')];
    $this->merk_m->getMerkMobil($filter)->row();
    $update = [
      'id_merk_mobil' => $post['id_merk_mobil'],
      'jenis_mobil' => $post['jenis_mobil'],
      'aktif'        => isset($_POST['aktif']) ? 1 : 0,
      'updated_at'   => waktu(),
      'updated_by'   => $user->id_user,
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $filter = ['id_jenis_mobil' => $post['id_jenis_mobil']];
    $this->db->update('ms_jenis_mobil', $update, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug())
      ];
      $this->session->set_flashdata(msg_sukses_update());
    }
    send_json($response);
  }

  public function detail()
  {
    $data['title'] = 'Detail ' . $this->title;
    $data['file']  = 'jenis_mobil_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_jenis_mobil']  = $params['id'];
    $row = $this->jns_m->getJenisMobil($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  public function delete()
  {
    $params = get_params($this->input->get(), true);
    $filter['id_jenis_mobil']  = $params['id'];
    $row = $this->jns_m->getJenisMobil($filter)->row();
    if ($row != NULL) {
      $this->db->trans_begin();
      $upd = ['aktif' => 0, 'deleted' => 1];
      $this->db->update('ms_jenis_mobil', $upd, $filter);
      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $this->session->set_flashdata(msg_error('Telah terjadi kesalahan !'));
        $status = 0;
      } else {
        $this->db->trans_commit();
        $this->session->set_flashdata(msg_sukses_hapus());
        $status = 1;
      }
      $response = [
        'status' => $status,
        'url'    => site_url(get_slug())
      ];
      $this->session->set_flashdata(msg_sukses_hapus());
      send_json($response);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }
}
