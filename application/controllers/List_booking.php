<?php
defined('BASEPATH') or exit('No direct script access allowed');
class List_booking extends Crm_Controller
{
  var $title  = "List Booking";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('booking_model', 'book_m');
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
      $params      = set_crypt("id_0=$rs->id_booking");

      $sub_array   = array();
      $html = '<a href="' . site_url(get_slug() . '/detail?' . $params) . '" style="color:black" class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
      <div class="d-flex align-items-center">
        <div class="font-4">
        <img src="' . base_url() . '/assets/images/avatars/avatar.png" class="user-img" alt="user avatar">
        </div>
        <div class="flex-grow-1 ms-2">
          <p style="font-weight:500" class="mb-0">' . $rs->nama_lengkap . ' melakukan booking ' . $rs->tot_servis . ' services untuk Mobil ' . $rs->merk_mobil . ' ' . $rs->jenis_mobil . '</p>
          <p style="font-weight:500" class="mb-0">#No. Polisi : ' . strtoupper($rs->no_polisi) . '</p>
          <p style="font-size:13px" class="mb-0">Booking untuk tanggal : ' . $rs->tanggal_booking . ' ' . $rs->jam_booking . '</p>
        </div>
      </div>
      <div class="ms-auto">';
      if ($rs->status == 'menunggu_pembayaran') {
        $html .= '<button type="button" class="btn btn-outline-primary btn-sm">Menunggu Pembayaran</button>';
      } elseif ($rs->status == 'dp_lunas') {
        $html .= '<button type="button" class="btn btn-outline-success btn-sm">Pembayaran DP Lunas</button>';
      } elseif ($rs->status == 'menunggu_kedatangan') {
        $html .= '<button type="button" class="btn btn-outline-info btn-sm">Menunggu Kedatangan</button>';
      } elseif ($rs->status == 'sedang_dikerjakan') {
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
    ];
    if ($recordsFiltered == true) {
      return $this->book_m->getBooking($filter)->num_rows();
    } else {
      return $this->book_m->getBooking($filter)->result();
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
    $data['file']  = 'list_booking_detail';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_booking']  = $params['id_0'];
    $row = $this->book_m->getBooking($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $data['services'] = $this->book_m->getBookingServices($filter)->result();
      $data['bayar_dp'] = $this->book_m->getBookingPembayaranDp($filter)->row();
      // send_json($data);
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  function getCalendarView()
  {
    header('Content-Type: application/json');
    $fbook = ['select' => 'calendar_view'];
    $data = $this->book_m->getBooking($fbook)->result();
    send_json($data);
  }

  public function saveBuktiPembayaranDP()
  {
    $user = user();
    $post = $this->input->post();
    $id_booking       = $this->input->post('id_booking');

    //Cek Data Booking
    $filter = [
      'id_booking' => $id_booking,
      'response_validate' => true
    ];
    $this->book_m->getBooking($filter);


    $bukti_pembayaran = $this->_upload_bukti_pembayaran("$id_booking-dp");

    $insert = [
      'id_booking'         => $id_booking,
      'metode_pembayaran'  => $post['metode_pembayaran'],
      'nama_bank'          => $post['nama_bank'],
      'jenis_pembayaran'   => 'dp',
      'waktu_pembayaran'   => $post['waktu_pembayaran'],
      'nominal_pembayaran' => $post['nominal_pembayaran'],
      'bukti_pembayaran'   => $bukti_pembayaran == true ? $bukti_pembayaran['bukti_pembayaran'] : null,
      'created_at' => waktu(),
      'created_by' => $user->id_user,
    ];
    $upd_header = [
      'status'     => 'dp_lunas',
      'updated_at' => waktu(),
      'updated_by' => $user->id_user,
    ];

    $tes = [
      'insert' => $insert,
      'upd_header' => $upd_header,
    ];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('booking_pembayaran', $insert);

    $filter = ['id_booking' => $id_booking];
    $this->db->update('booking', $upd_header, $filter);

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug())
      ];
      $this->session->set_flashdata(msg_sukses('Bukti Pembayaran DP ID Booking : ' . $id_booking . ' Berhasil Disimpan'));
    }
    send_json($response);
  }

  function _upload_bukti_pembayaran($id)
  {
    $this->load->library('upload');
    $path = "./uploads/bukti-pembayaran";
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
    if ($this->upload->do_upload('bukti_pembayaran')) {
      $new_path = substr($path, 2, 40);
      $filename = $this->upload->file_name;
      $dt['bukti_pembayaran'] = $new_path . '/' . $filename;
      return $dt;
    } else {
      // $response = ['status' => 0, 'pesan' => $this->upload->display_errors()];
      // send_json($response);
    }
  }
}
