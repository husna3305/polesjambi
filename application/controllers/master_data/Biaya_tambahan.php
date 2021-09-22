<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Biaya_tambahan extends Crm_Controller
{
  var $title  = "Jenis Mobil";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('biaya_tambahan_model', 'biaya_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'biaya_tambahan_index';
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
        'get'   => "id = " . $rs->id_tambahan
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }
      $links = link_on_data_details($params, $user->id_group);
      if ($rs->id_tambahan == 999) {
        $links = '';
      }
      $sub_array   = array();
      $sub_array[] = $no;
      $sub_array[] = $rs->deskripsi_tambahan;
      $sub_array[] = $aktif;
      $sub_array[] = $links;
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
      return $this->biaya_m->getBiayaTambahan($filter)->num_rows();
      return 1;
    } else {
      return $this->biaya_m->getBiayaTambahan($filter)->result();
      // $sample[] = ['id' => 1, 'merk_mobil' => 'Toyota', 'jenis_mobil' => 'Avanza', 'aktif' => 1];
      // $sample = json_decode(json_encode($sample), FALSE);
      // return $sample;
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'biaya_tambahan_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $id_tambahan = $this->biaya_m->getID();
    $insert = [
      'id_tambahan'        => $id_tambahan,
      'deskripsi_tambahan' => $this->input->post('deskripsi_tambahan'),
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_biaya_tambahan', $insert);
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
    $data['file']  = 'biaya_tambahan_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_tambahan']  = $params['id'];
    if ($params['id'] == 999) {
      redirect(get_slug());
    }
    $row = $this->biaya_m->getBiayaTambahan($filter)->row();
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
    $post     = $this->input->post();
    $id_tambahan = $this->input->post('id_tambahan');

    $filter = ['id_tambahan' => $id_tambahan, 'response_validate' => true];
    $this->biaya_m->getBiayaTambahan($filter);

    $update = [
      'deskripsi_tambahan' => $this->input->post('deskripsi_tambahan'),
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'updated_at' => waktu(),
      'updated_by' => $user->id_user,
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $filter = ['id_tambahan' => $id_tambahan];
    $this->db->update('ms_biaya_tambahan', $update, $filter);
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

  public function delete()
  {
    $params = get_params($this->input->get(), true);
    $filter['id_tambahan']  = $params['id'];
    $row = $this->biaya_m->getBiayaTambahan($filter)->row();
    if ($row != NULL) {
      $this->db->trans_begin();
      $upd = ['aktif' => 0, 'deleted' => 1];
      $this->db->update('ms_biaya_tambahan', $upd, $filter);
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
