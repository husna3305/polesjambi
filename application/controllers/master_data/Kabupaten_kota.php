<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kabupaten_kota extends Crm_Controller
{
  var $title  = "Kabupaten/Kota";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('kabupaten_model', 'kab_m');
    $this->load->model('provinsi_model', 'prov_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'kabupaten_kota_index';
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
        'get'   => "kabupaten_id=" . $rs->kabupaten_id
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $sub_array   = array();
      $sub_array[] = $no;
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
      return $this->kab_m->getKabupaten($filter)->num_rows();
    } else {
      return $this->kab_m->getKabupaten($filter)->result();
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'kabupaten_kota_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $post     = $this->input->post();
    $f_prov = ['provinsi_id' => $post['provinsi_id'], 'response_validate' => true];
    $this->prov_m->getProvinsi($f_prov);

    $fp = ['kabupaten_id' => $post['kabupaten_id']];
    $cek_kab = $this->kab_m->getKabupaten($fp)->row();
    if ($cek_kab != null) {
      $response = ['status' => 0, 'pesan' => 'ID Kabupaten :' . $post['kabupaten_id'] . ' sudah ada'];
      send_json($response);
    }

    $insert = [
      'provinsi_id' => $post['provinsi_id'],
      'kabupaten_id' => $post['kabupaten_id'],
      'kabupaten' => $post['kabupaten'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('wilayah_kabupaten', $insert);
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
    $data['file']  = 'kabupaten_kota_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['kabupaten_id']  = $params['kabupaten_id'];
    $row = $this->kab_m->getKabupaten($filter)->row();
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
    $this->load->library('upload');
    $post     = $this->input->post();

    $f_prov = ['provinsi_id' => $post['provinsi_id'], 'response_validate' => true];
    $this->prov_m->getProvinsi($f_prov);

    if ($post['kabupaten_id'] != $post['kabupaten_id_old']) {
      $flt = ['kabupaten_id' => $this->input->post('kabupaten_id')];
      $row = $this->kab_m->getKabupaten($flt)->row();
      if ($row != NULL) {
        $response = ['status' => 0, 'pesan' => 'ID Kabupaten :' . $post['kabupaten_id'] . ' sudah ada'];
        send_json($response);
      }
    }

    $update = [
      'kabupaten'    => $post['kabupaten'],
      'kabupaten_id' => $post['kabupaten_id'],
      'provinsi_id'  => $post['provinsi_id'],
      'aktif'        => isset($_POST['aktif']) ? 1 : 0
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $filter['kabupaten_id'] = $post['kabupaten_id_old'];
    $this->db->update('wilayah_kabupaten', $update, $filter);
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
    $data['file']  = 'kabupaten_kota_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['kabupaten_id']  = $params['kabupaten_id'];
    $row = $this->kab_m->getKabupaten($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }
}
