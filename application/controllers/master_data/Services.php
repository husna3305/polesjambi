<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Services extends Crm_Controller
{
  var $title  = "Services";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('services_model', 'srv_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'services_index';
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
        'get'   => "id_services=" . $rs->id_services
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $html = '<div class="d-flex align-items-center">
      <div class="font-4">
      <img src="' . base_url($rs->gambar_small) . '" class="user-img" alt="user avatar">
      </div>
      <div class="flex-grow-1 ms-2">
        <p style="font-weight:500" class="mb-0">' . $rs->judul . '</p>
        <p style="font-size:13px;font-style: italic;" class="mb-0">Last Updated : ' . $rs->updated_at . '</p>
      </div>
    </div>';
      $sub_array   = array();
      $sub_array[] = $no;
      $sub_array[] = $html;
      $sub_array[] = $rs->kategori;
      $sub_array[] = mata_uang_rp($rs->estimasi_biaya);
      $sub_array[] = $rs->estimasi_waktu_jam . ':' . $rs->estimasi_waktu_menit;
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
      return $this->srv_m->getServices($filter)->num_rows();
      return 1;
    } else {
      return $this->srv_m->getServices($filter)->result();
      // $sample[] = ['id' => 1, 'nama_jasa' => 'Pembersihan Kaca', 'deskripsi_jasa' => 'Pembersihan Kaca small car/medium car', 'harga_jasa' => 'Rp. 200.000', 'estimasi_jasa' => '10 Menit', 'aktif' => 1];
      // $sample = json_decode(json_encode($sample), FALSE);
      // return $sample;
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'services_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $this->load->library('upload');
    $post     = $this->input->post();

    $id = $this->dm->getLastIdIncrement('ms_services');
    $gambar = $this->_upload_gambar("$id" . "1");
    if ($gambar) {
      $ins_gambar = [
        'id_services' => $id,
        'id_gambar'  => 1,
        'utama'      => 1,
        'created_at' => waktu(),
        'created_by' => $user->id_user,
        'gambar_big'    => $gambar == true ? $gambar['gambar_big'] : null,
        'gambar_small'  => $gambar == true ? $gambar['gambar_small'] : null,
      ];
    }

    $insert = [
      'id_services'          => $id,
      'judul'                => $post['judul'],
      'deskripsi'            => $post['deskripsi'],
      'estimasi_biaya'       => $post['estimasi_biaya'],
      'estimasi_waktu_jam'   => $post['estimasi_waktu_jam'],
      'estimasi_waktu_menit' => $post['estimasi_waktu_menit'],
      'kategori'             => $post['kategori'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    // $tes = [
    //   'insert' => $insert,
    //   'ins_gambar' => $ins_gambar,
    // ];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_services', $insert);
    if (isset($ins_gambar)) {
      $this->db->insert('ms_services_gambar', $ins_gambar);
    }
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
    $data['file']  = 'services_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_services']  = $params['id_services'];
    $row = $this->srv_m->getServices($filter)->row();
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
    $id_services = $this->input->post('id_services');
    $filter = ['id_services' => $id_services, 'response_validate' => true];
    $row = $this->srv_m->getServices($filter);

    $gambar = $this->_upload_gambar("$id_services" . "1");
    if ($gambar) {
      $cek = $this->db->query("SELECT id_services FROM ms_services_gambar WHERE id_gambar=1 AND id_services='$id_services'")->row();
      if ($cek == null) {
        $ins_gambar = [
          'id_services' => $id_services,
          'id_gambar'  => 1,
          'utama'      => 1,
          'created_at' => waktu(),
          'created_by' => $user->id_user,
          'gambar_big'    => $gambar == true ? $gambar['gambar_big'] : null,
          'gambar_small'  => $gambar == true ? $gambar['gambar_small'] : null,
        ];
      } else {
        $upd_gambar = [
          'id_services' => $id_services,
          'id_gambar'  => 1,
          'utama'      => 1,
          'updated_at' => waktu(),
          'updated_by' => $user->id_user,
          'gambar_big'    => $gambar == true ? $gambar['gambar_big'] : null,
          'gambar_small'  => $gambar == true ? $gambar['gambar_small'] : null,
        ];
      }
    }

    if ($post['estimasi_waktu_menit'] > 59) {
      $response = ['status' => 0, 'pesan' => 'Estimasi waktu menit melewati batas. Maks : 59'];
      send_json($response);
    }
    $update = [
      'judul'                => $post['judul'],
      'deskripsi'            => $post['deskripsi'],
      'estimasi_biaya'       => $post['estimasi_biaya'],
      'estimasi_waktu_jam'   => $post['estimasi_waktu_jam'],
      'estimasi_waktu_menit' => $post['estimasi_waktu_menit'],
      'kategori'             => $post['kategori'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'updated_at' => waktu(),
      'updated_by' => $user->id_user,
    ];

    $tes = [
      'update' => $update,
      'upd_gambar' => isset($upd_gambar) ? $upd_gambar : null,
      'ins_gambar' => isset($ins_gambar) ? $ins_gambar : null,
    ];
    // send_json($tes);
    unset($filter['response_validate']);
    $this->db->trans_begin();
    $this->db->update('ms_services', $update, $filter);
    if (isset($upd_gambar)) {
      $filter['id_gambar'] = 1;
      $this->db->update('ms_services_gambar', $upd_gambar, $filter);
    }
    if (isset($ins_gambar)) {
      $this->db->insert('ms_services_gambar', $ins_gambar);
    }
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
    $data['file']  = 'services_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_services']  = $params['id_services'];
    $row = $this->srv_m->getServices($filter)->row();
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
    $path = "./uploads/services";
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

  public function delete()
  {
    $params = get_params($this->input->get(), true);
    $filter['id_services']  = $params['id_services'];
    $row = $this->srv_m->getServices($filter)->row();
    if ($row != NULL) {
      $this->db->trans_begin();
      $upd = ['aktif' => 0, 'deleted' => 1];
      $this->db->update('ms_services', $upd, $filter);
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
