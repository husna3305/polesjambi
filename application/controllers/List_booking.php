<?php
defined('BASEPATH') or exit('No direct script access allowed');
class List_booking extends Crm_Controller
{
  var $title  = "List Booking";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('merk_mobil_model', 'mbl_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'list_booking_index';
    if (isset($_GET['isCalendar'])) {
      $data['isCalendar'] = true;
    }
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
        'get'   => "id = " . $rs->id
      ];
      $aktif = '';
      if ($rs->aktif == 1) {
        $aktif = '<i class="fa fa-check"></i>';
      }

      $sub_array   = array();
      $html = '<a href="' . site_url(get_slug() . '/detail?id=' . $rs->id) . '" style="color:black" class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
      <div class="d-flex align-items-center">
        <div class="font-4">
        <img src="http://localhost/polesjambi/assets/images/avatars/avatar.png" class="user-img" alt="user avatar">
        </div>
        <div class="flex-grow-1 ms-2">
          <p style="font-weight:500" class="mb-0">User ' . $rs->id . ' melakukan booking 4 services untuk mobil ' . $rs->mobil . '</p>
          <p style="font-size:13px" class="mb-0">Booking untuk tanggal : ' . $rs->tgl . '</p>
        </div>
      </div>
      <div class="ms-auto">';
      if ($rs->id == 1) {
        $html .= '<button type="button" class="btn btn-outline-primary btn-sm">Menunggu Pembayaran</button>';
      } elseif ($rs->id == 2) {
        $html .= '<button type="button" class="btn btn-outline-info btn-sm">Menunggu Kedatangan</button>';
      } elseif ($rs->id == 3) {
        $html .= '<button type="button" class="btn btn-outline-info btn-sm">Sedang Dikerjakan</button>';
      }
      $html .= '<!-- <div class="btn-group">
                  <button type="button" class="btn btn-outline-secondary btn-sm">Action</button>
                  <button type="button" class="btn btn-outline-secondary split-bg-outline-secondary dropdown-toggle dropdown-toggle-split btn-sm" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                <ul class="dropdown-menu"></ul> -->
    </div>
      </div>
    </a>
      ';
      $sub_array[] = $html;
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
      // return $this->mbl_m->getMerkMobil($filter)->num_rows();
      return 1;
    } else {
      // return $this->mbl_m->getMerkMobil($filter)->result();
      $sample[] = ['id' => 1, 'mobil' => 'Toyota Avanza', 'aktif' => 1, 'tgl' => '01 September 2021, 08:00'];
      $sample[] = ['id' => 2, 'mobil' => 'Daihatsu Xenia', 'aktif' => 1, 'tgl' => '01 September 2021, 10:00'];
      $sample[] = ['id' => 3, 'mobil' => 'Daihatsu Terios', 'aktif' => 1, 'tgl' => '01 September 2021, 15:00'];
      $sample = json_decode(json_encode($sample), FALSE);
      return $sample;
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'list_booking_form';
    $data['mode']  = 'insert';
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $this->load->library('upload');
    $post     = $this->input->post();

    $insert = [
      'merk_mobil' => $post['merk_mobil'],
      'aktif'      => isset($_POST['aktif']) ? 1 : 0,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_merk_mobil', $insert);
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
    $data['file']  = 'list_booking_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_merk_mobil']  = $params['id'];
    $row = $this->mbl_m->getMerkMobil($filter)->row();
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
    $filter = ['id_merk_mobil' => $this->input->post('id_merk_mobil')];
    $row = $this->mbl_m->getMerkMobil($filter)->row();
    if ($row == NULL) {
      $result = [
        'status' => 0,
        'pesan' => 'Data tidak ditemukan'
      ];
      send_json($result);
    }
    $update = [
      'merk_mobil' => $post['merk_mobil'],
      'aktif'        => isset($_POST['aktif']) ? 1 : 0,
      'updated_at'   => waktu(),
      'updated_by'   => $user->id_user,
    ];

    $tes = ['update' => $update];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->update('ms_merk_mobil', $update, $filter);
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
    $data['file']  = 'list_booking/list_booking_detail';
    $data['mode']  = 'detail';
    $data['id'] = $this->input->get('id');
    $this->template_portal($data);

    // $params = get_params($this->input->get(), true);
    // $filter['id_merk_mobil']  = $params['id'];
    // $row = $this->mbl_m->getMerkMobil($filter)->row();
    // if ($row != NULL) {
    //   $data['row'] = $row;
    //   $this->template_portal($data);
    // } else {
    //   $this->session->set_flashdata(msg_not_found());
    //   redirect(get_slug());
    // }
  }
}
