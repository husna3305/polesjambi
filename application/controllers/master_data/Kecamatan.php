<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kecamatan extends Crm_Controller
{
  var $title  = "Kecamatan";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('kecamatan_model', 'kec_m');
    $this->load->model('kabupaten_model', 'kab_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'kecamatan_index';
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
        'get'   => "kecamatan_id=" . $rs->kecamatan_id
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $sub_array   = array();
      $sub_array[] = $no;
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
      return $this->kec_m->getKecamatan($filter)->num_rows();
      return 1;
    } else {
      return $this->kec_m->getKecamatan($filter)->result();
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'kecamatan_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $post     = $this->input->post();

    $f_kab = ['kabupaten_id' => $post['kabupaten_id'], 'response_validate' => true];
    $this->kab_m->getKabupaten($f_kab);

    $fp = ['kecamatan_id' => $post['kecamatan_id']];
    $cek = $this->kec_m->getKecamatan($fp)->row();
    if ($cek != null) {
      $response = ['status' => 0, 'pesan' => 'ID Kecamatan : ' . $post['kecamatan_id'] . ' sudah ada'];
      send_json($response);
    }

    $insert = [
      'kecamatan'    => $post['kecamatan'],
      'kecamatan_id' => $post['kecamatan_id'],
      'kabupaten_id' => $post['kabupaten_id'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('wilayah_kecamatan', $insert);
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
    $data['file']  = 'kecamatan_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['kecamatan_id']  = $params['kecamatan_id'];
    $row = $this->kec_m->getKecamatan($filter)->row();
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
    $post     = $this->input->post();

    $fkab = ['kabupaten_id' => $post['kabupaten_id'], 'response_validate' => true];
    $this->kab_m->getKabupaten($fkab);

    if ($post['kecamatan_id'] != $post['kecamatan_id_old']) {
      $flt = ['kecamatan_id' => $this->input->post('kecamatan_id')];
      $row = $this->kec_m->getKecamatan($flt)->row();
      if ($row != NULL) {
        $response = ['status' => 0, 'pesan' => 'ID Kabupaten :' . $post['kecamatan_id'] . ' sudah ada'];
        send_json($response);
      }
    }

    $update = [
      'kecamatan'    => $post['kecamatan'],
      'kecamatan_id' => $post['kecamatan_id'],
      'kabupaten_id' => $post['kabupaten_id'],
      'aktif'        => isset($_POST['aktif']) ? 1 : 0
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $filter['kecamatan_id'] = $post['kecamatan_id_old'];
    $this->db->update('wilayah_kecamatan', $update, $filter);
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
    $data['file']  = 'kecamatan_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['kecamatan_id']  = $params['kecamatan_id'];
    $row = $this->kec_m->getKecamatan($filter)->row();
    $row = $this->kec_m->getKecamatan($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }
}
