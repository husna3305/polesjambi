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
    $this->load->model('services_model', 'srv_m');
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
      $html .= '<div class="btn-group-vertical" role="group">';
      $selesai_bayar_dp = $rs->status == 'menunggu_pembayaran' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '<i class="fa fa-check"></i>';
      $button = '<button type="button" class="btn btn-outline-primary btn-sm left">' . $selesai_bayar_dp . ' Menunggu Pembayaran</i></button>';
      if ($rs->status != 'menunggu_pembayaran') {
        $button .= '<button type="button" class="btn btn-outline-success btn-sm left"><i class="fa fa-check"></i> DP Lunas</i></button>';
      }
      if (($rs->status == 'menunggu_kedatangan')) {
        $button .= '<button type="button" class="btn btn-outline-info btn-sm left"><i class="fa fa-check"></i> Menunggu Kedatangan</i></button>';
      }
      if (($rs->status == 'sedang_dikerjakan')) {
        $button .= '<button type="button" class="btn btn-outline-info btn-sm left"><i class="fa fa-check"></i> Sedang Dikerjakan</i></button>';
      }
      if (($rs->status == 'selesai_dikerjakan')) {
        $button .= '<button type="button" class="btn btn-outline-info btn-sm left"><i class="fa fa-check"></i> Selesai Dikerjakan</i></button>';
      }
      if (($rs->status == 'selesai')) {
        $button = '<button type="button" class="btn btn-outline-success btn-sm left"><i class="fa fa-check"></i> Selesai</i></button>';
      }
      $html .= $button;
      $html .= '</div>';
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
      $filter['tambahan'] = 0;
      $filter['batal'] = 0;
      $data['services_booking'] = $this->book_m->getBookingServices($filter)->result();
      $data['services']         = $this->book_m->getBookingDetailerServices($params['id_0']);
      $data['bayar_dp']         = $this->book_m->getBookingPembayaranDp($filter)->row();
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
    $book = $this->book_m->getBooking($filter);


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

    if ($book->tanggal_booking == tanggal()) {
      $upd_header['status'] = 'menunggu_kedatangan';
    }
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

  function getDetailersVsServices()
  {
    $id_booking = $this->input->post('id_booking');
    $id_services = $this->input->post('id_services');
    $dipilih = "SELECT COUNT(id_detailer) FROM booking_detailer WHERE id_booking=$id_booking AND id_services=$id_services AND id_detailer=mu.id_detailer";
    $data = $this->db->query("SELECT id_detailer,nama_detailer,($dipilih) dipilih,CASE WHEN IFNULL(mu.gambar_small,'')='' THEN 'assets/images/avatars/avatar.png' ELSE mu.gambar_small END gambar_small FROM ms_detailer mu")->result();
    $fserv = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $srv = $this->book_m->getBookingServices($fserv)->row();
    // send_json($srv);
    $services = ['tot_detailers' => $srv->tot_detailers, 'status' => $srv->status];
    send_json(['status' => 1, 'data' => $data, 'services' => $services]);
  }

  function simpanDetailersServices()
  {
    $id_services = $this->input->post('id_services');
    $id_booking = $this->input->post('id_booking');

    $fserv = ['id_services' => $id_services, 'response_validate' => true, 'id_booking' => $id_booking];
    $srv = $this->book_m->getBookingServices($fserv);

    $user = user();

    foreach ($this->input->post('detailers') as $dtl) {
      if ($dtl['dipilih'] == 1) {
        $ins_detailers_services[] = [
          'id_booking'  => $id_booking,
          'id_services' => $id_services,
          'tambahan'    => $srv->tambahan,
          'id_detailer' => $dtl['id_detailer'],
          'created_at'  => waktu(),
          'created_by'  => $user->id_user,
        ];
      }
    }
    $this->db->trans_begin();
    $upd = [
      'id_booking' => $id_booking,
      'id_services' => $id_services
    ];
    $this->db->delete('booking_detailer', $upd);
    $this->db->insert_batch('booking_detailer', $ins_detailers_services);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Detailer Untuk Services ' . $srv->judul . ' Berhasil Disimpan'));
    }
    send_json($response);
  }

  function startServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $filter = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $upd = ['status' => 'start'];
    $this->db->update('booking_services', $upd, $filter);

    $filter = ['id_booking' => $id_booking];
    $upd = ['status' => 'sedang_dikerjakan'];
    $this->db->update('booking', $upd, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Melakukan Start Untuk Services ' . $srv->judul));
    }
    send_json($response);
  }
  function pauseServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $filter = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $upd = ['status' => 'pause'];
    $this->db->update('booking_services', $upd, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Melakukan Pause Untuk Services ' . $srv->judul));
    }
    send_json($response);
  }

  function resumeServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $filter = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $upd = ['status' => 'start'];
    $this->db->update('booking_services', $upd, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Melakukan Resume Untuk Services ' . $srv->judul));
    }
    send_json($response);
  }
  function endServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $filter = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $upd = ['status' => 'end'];
    $this->db->update('booking_services', $upd, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Menyelesaikan Services ' . $srv->judul));
    }
    send_json($response);
  }

  public function fetchDataServices()
  {
    $fetch_data = $this->_makeQueryServices();
    $data = array();
    $no = $this->input->post('start') + 1;
    foreach ($fetch_data as  $rs) {
      $html = '<div class="d-flex align-items-center">
      <div class="font-4">
      <!--<img src="' . base_url($rs->gambar_small) . '" class="user-img" alt="user avatar">--!>
      </div>
      <div class="flex-grow-1 ms-2">
      <p style="font-weight:500" class="mb-0">' . $rs->judul . '</p>
      </div>
      </div>
      ';

      $json_rs = [
        'id_services' => $rs->id_services,
        'judul' => $rs->judul,
        'detailers' => []
      ];
      $button = '
      <script>var serv_' . $rs->id_services . '=' . json_encode($json_rs) . '</script>
      <button class="btn btn-primary btn-xs btnPilihListServices" onclick="pilihServices(serv_' . $rs->id_services . ')">&nbsp;&nbsp;<i class="fa fa-plus"></i></button>';
      $sub_array   = array();
      $sub_array[] = $html;
      $sub_array[] = $rs->kategori;
      $sub_array[] = mata_uang_rp($rs->estimasi_biaya);
      $sub_array[] = $rs->estimasi_waktu_jam . ':' . $rs->estimasi_waktu_menit;
      $sub_array[] = $button;
      $data[]      = $sub_array;
      $no++;
    }
    $output = array(
      "draw"            => intval($_POST["draw"]),
      "recordsFiltered" => $this->_makeQueryServices(true),
      "data"            => $data
    );
    echo json_encode($output);
  }

  function _makeQueryServices($recordsFiltered = false)
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
      'filter_id_booking' => $this->input->post('id_booking'),
      'aktif' => 1
    ];
    if ($recordsFiltered == true) {
      return $this->srv_m->getServices($filter)->num_rows();
      return 1;
    } else {
      return $this->srv_m->getServices($filter)->result();
    }
  }

  function tambahServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $insert = [
      'id_booking'  => $id_booking,
      'id_services' => $id_services,
      'biaya'       => $srv->estimasi_biaya,
      'waktu_menit' => time_to_minutes($srv->estimasi_waktu_jam, $srv->estimasi_waktu_menit),
      'created_at'  => waktu(),
      'created_by'  => $user->id_user,
      'tambahan'    => 1
    ];
    // send_json($insert);
    $this->db->insert('booking_services', $insert);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Menambahkan Services ' . $srv->judul));
    }
    send_json($response);
  }

  function batalServices()
  {
    $id_services = $this->input->post('id_services');
    $fserv = ['id_services' => $id_services, 'response_validate' => true];
    $srv = $this->srv_m->getServices($fserv);
    $id_booking = $this->input->post('id_booking');
    $user = user();

    $this->db->trans_begin();
    $filter = ['id_booking' => $id_booking, 'id_services' => $id_services];
    $upd = ['status' => 'batal', 'batal' => 1];
    $this->db->update('booking_services', $upd, $filter);
    $upd = ['batal' => 1];
    $this->db->update('booking_detailer', $upd, $filter);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $response = [
        'status' => 1,
        'url' => site_url(get_slug() . '/detail?' . set_crypt("id_0=$id_booking"))
      ];
      $this->session->set_flashdata(msg_sukses('Berhasil Membatalkan Services ' . $srv->judul));
    }
    send_json($response);
  }
}
