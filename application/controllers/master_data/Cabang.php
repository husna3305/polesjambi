<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cabang extends Crm_Controller
{
  var $title  = "Cabang";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('provinsi_model', 'prov_m');
    $this->load->model('kabupaten_model', 'kab_m');
    $this->load->model('kecamatan_model', 'kec_m');
    $this->load->model('kelurahan_model', 'kel_m');
    $this->load->model('cabang_model', 'cab_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'cabang_index';
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
        'get'   => "id_cabang=" . $rs->id_cabang
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $sub_array   = array();
      $sub_array[] = $no;
      $sub_array[] = $rs->nama_cabang;
      $sub_array[] = $rs->kepala_cabang;
      $sub_array[] = $rs->no_telp_cabang;
      $sub_array[] = $rs->no_hp_cabang;
      $sub_array[] = $rs->kelurahan;
      $sub_array[] = $rs->kecamatan;
      $sub_array[] = $rs->kabupaten;
      $sub_array[] = $rs->provinsi;
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
      'deleted' => false
    ];
    if ($recordsFiltered == true) {
      return $this->cab_m->getCabang($filter)->num_rows();
      return 1;
    } else {
      return $this->cab_m->getCabang($filter)->result();
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'cabang_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $post = $this->input->post();

    $f_wil = ['provinsi_id' => $this->input->post('provinsi_id'), 'response_validate' => true];
    $this->prov_m->getProvinsi($f_wil);
    $f_wil = ['kabupaten_id' => $this->input->post('kabupaten_id'), 'response_validate' => true];
    $this->kab_m->getKabupaten($f_wil);
    $f_wil = ['kecamatan_id' => $this->input->post('kecamatan_id'), 'response_validate' => true];
    $this->kec_m->getKecamatan($f_wil);
    $f_wil = ['kelurahan_id' => $this->input->post('kelurahan_id'), 'response_validate' => true];
    $this->kel_m->getKelurahan($f_wil);

    $insert = [
      'nama_cabang'      => $post['nama_cabang'],
      'deskripsi_cabang' => $post['deskripsi_cabang'],
      'no_hp_cabang'     => $post['no_hp_cabang'],
      'no_telp_cabang'   => $post['no_telp_cabang'],
      'kepala_cabang'    => $post['kepala_cabang'],
      'alamat'           => $post['alamat'],
      'provinsi_id'      => $this->input->post('provinsi_id'),
      'kabupaten_id'     => $this->input->post('kabupaten_id'),
      'kecamatan_id'     => $this->input->post('kecamatan_id'),
      'kelurahan_id'     => $this->input->post('kelurahan_id'),
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_cabang', $insert);
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
    $data['file']  = 'cabang_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_cabang']  = $params['id_cabang'];
    $row = $this->cab_m->getCabang($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  public function saveEdit()
  {
    $user = user();
    $post = $this->input->post();

    $f_wil = ['provinsi_id' => $this->input->post('provinsi_id'), 'response_validate' => true];
    $this->prov_m->getProvinsi($f_wil);
    $f_wil = ['kabupaten_id' => $this->input->post('kabupaten_id'), 'response_validate' => true];
    $this->kab_m->getKabupaten($f_wil);
    $f_wil = ['kecamatan_id' => $this->input->post('kecamatan_id'), 'response_validate' => true];
    $this->kec_m->getKecamatan($f_wil);
    $f_wil = ['kelurahan_id' => $this->input->post('kelurahan_id'), 'response_validate' => true];
    $this->kel_m->getKelurahan($f_wil);

    $f_cab = ['id_cabang' => $this->input->post('id_cabang'), 'response_validate' => true];
    $this->cab_m->getCabang($f_cab);

    $update = [
      'nama_cabang'      => $post['nama_cabang'],
      'deskripsi_cabang' => $post['deskripsi_cabang'],
      'no_hp_cabang'     => $post['no_hp_cabang'],
      'no_telp_cabang'   => $post['no_telp_cabang'],
      'kepala_cabang'    => $post['kepala_cabang'],
      'alamat'           => $post['alamat'],
      'provinsi_id'      => $this->input->post('provinsi_id'),
      'kabupaten_id'     => $this->input->post('kabupaten_id'),
      'kecamatan_id'     => $this->input->post('kecamatan_id'),
      'kelurahan_id'     => $this->input->post('kelurahan_id'),
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'updated_at' => waktu(),
      'updated_by' => $user->id_user,
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $filter['id_cabang'] = $post['id_cabang'];
    $this->db->update('ms_cabang', $update, $filter);
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
    $data['file']  = 'cabang_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_cabang']  = $params['id_cabang'];
    $row = $this->cab_m->getCabang($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }
}
