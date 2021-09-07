<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Detailer extends Crm_Controller
{
  var $title  = "Detailer";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('detailer_model', 'mbl_m');
    $this->load->model('cabang_model', 'cab_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'detailer_index';
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
        'get'   => "id_detailer=" . $rs->id_detailer
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $html = '<div class="d-flex align-items-center">
      <div class="">
        <img src="' . base_url($rs->gambar_small) . '" class="rounded-circle" width="46" height="46" alt="">
      </div>
      <div class="ms-2">
        <h6 class="mb-1 font-14">' . $rs->nama_detailer . '</h6>
        <p class="mb-0 font-13 text-secondary" style="font-style:italic"> Last Updated :' . $rs->updated_at . '</p>
      </div>
    </div>';
      $sub_array   = array();
      $sub_array[] = $html;
      $sub_array[] = $rs->no_hp;
      $sub_array[] = $rs->alamat;
      $sub_array[] = $rs->nama_cabang;
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
      return $this->mbl_m->getDetailer($filter)->num_rows();
      return 1;
    } else {
      return $this->mbl_m->getDetailer($filter)->result();
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'detailer_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $this->load->library('upload');
    $post     = $this->input->post();
    $id = $this->dm->getLastIdIncrement('ms_detailer');

    $f_cab = ['id_cabang' => $this->input->post('id_cabang'), 'response_validate' => true];
    $this->cab_m->getCabang($f_cab);

    $gambar = $this->_upload_gambar($id);

    $insert = [
      'id_detailer'   => $id,
      'nama_detailer' => $post['nama_detailer'],
      'no_hp'         => $post['no_hp'],
      'id_cabang'     => $post['id_cabang'],
      'alamat'        => $post['alamat'],
      'aktif'         => isset($_POST['aktif']) ? 1 : 0,
      'gambar_big'    => $gambar == true ? $gambar['gambar_big'] : null,
      'gambar_small'  => $gambar == true ? $gambar['gambar_small'] : null,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    $tes = ['insert' => $insert];

    $this->db->trans_begin();
    $this->db->insert('ms_detailer', $insert);
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
    $data['file']  = 'detailer_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_detailer']  = $params['id_detailer'];
    $row = $this->mbl_m->getDetailer($filter)->row();
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
    $id_detailer = $this->input->post('id_detailer');
    $filter = ['id_detailer' => $id_detailer];
    $row = $this->mbl_m->getDetailer($filter)->row();
    if ($row == NULL) {
      $result = [
        'status' => 0,
        'pesan' => 'Data tidak ditemukan'
      ];
      send_json($result);
    }
    $gambar = $this->_upload_gambar($id_detailer);

    $update = [
      'id_detailer'   => $id_detailer,
      'nama_detailer' => $post['nama_detailer'],
      'no_hp'         => $post['no_hp'],
      'id_cabang'     => $post['id_cabang'],
      'alamat'        => $post['alamat'],
      'aktif'         => isset($_POST['aktif']) ? 1 : 0,
      'gambar_big'    => $gambar == true ? $gambar['gambar_big'] : null,
      'gambar_small'  => $gambar == true ? $gambar['gambar_small'] : null,
      'updated_at' => waktu(),
      'updated_by' => $user->id_user,
    ];

    $tes = ['update' => $update];

    $this->db->trans_begin();
    $this->db->update('ms_detailer', $update, $filter);
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
    $data['file']  = 'detailer_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_detailer']  = $params['id_detailer'];
    $row = $this->mbl_m->getDetailer($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  function _upload_gambar($id)
  {
    $this->load->library('upload');
    $path = "./uploads/detailer";
    if (!is_dir($path)) {
      mkdir($path, 0777, true);
    }

    $config['upload_path']      = $path;
    $config['allowed_types']    = 'jpg|png|jpeg|bmp|gif';
    $config['max_size']         = '1024';
    $config['max_width']        = '3000';
    $config['max_height']       = '3000';
    $config['remove_spaces']    = TRUE;
    $config['overwrite']        = TRUE;
    $config['file_ext_tolower'] = TRUE;
    $config['file_name']        = $id;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('gambar')) {
      $new_path = substr($path, 2, 40);
      $filename = $this->upload->file_name;
      $params = [
        'path' => $path,
        'file_name' => $this->upload->file_name
      ];
      $dt['gambar_big'] = $new_path . '/' . $filename;
      $dt['gambar_small'] = $new_path . '/' . create_thumbs($params);
      return $dt;
    } else {
      // $response = ['status' => 0, 'pesan' => $this->upload->display_errors()];
      // send_json($response);
    }
  }
}
