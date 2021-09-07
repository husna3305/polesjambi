<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Front extends Crm_Controller
{
  var $title  = "Dashboard";
  public function __construct()
  {
    parent::__construct();
    $this->load->model('services_model', 'srv_m');
    $this->load->model('booking_model', 'book');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $this->load->view('front/index');
    // $this->template_front($data);
  }
  public function services()
  {
    $data['title']   = $this->title;
    $f_srv = ['aktif' => 1, 'select' => 'for_booking_services'];
    $data['services'] = $this->srv_m->getServices($f_srv)->result();
    // send_json($data);
    $this->load->view('front/services', $data);
    // $this->template_front($data);
  }

  public function dataBooking()
  {
    $generated_session = generateRandomString(50);
    $_SESSION[$generated_session] = $this->input->post();
    $response = ['status' => 1, 'link' => site_url('front/formDataBooking?' . $generated_session)];
    send_json($response);
  }
  public function formDataBooking()
  {
    $keys = '';
    foreach ($this->input->get() as $key => $value) {
      $keys = $key;
    }
    if (isset($_SESSION[$keys]) || $keys != '') {
      $sess          = $_SESSION[$keys]['services'];
      $data['title'] = $this->title;
      $data['var']   = $keys;

      $f_srv = ['aktif' => 1, 'select' => 'for_booking_services', 'id_services_in' => arr_sql($sess)];
      $data['services'] = $this->srv_m->getServices($f_srv)->result();
      $this->load->view('front/form_data_booking', $data);
    } else {
      redirect(site_url('front/services'));
    }
  }

  function saveDataBooking()
  {
    $keys = $this->input->post('var');
    if (isset($_SESSION[$keys])) {
      $services = $_SESSION[$keys]['services'];
      $id_booking = $this->book->getID();
      $tot_biaya = 0;
      foreach ($services as $svc) {
        $fsv = ['id_services' => $svc];
        $dt_svc = $this->srv_m->getServices($fsv)->row();
        if ($dt_svc == null) {
          $response = ['status' => 0, 'pesan' => 'ID Service : ' . $svc . ' tidak ditemukan'];
          send_json($response);
        } else {
          $ins_services[] = [
            'id_booking' => $id_booking,
            'id_services' => $svc,
            'biaya' => $dt_svc->estimasi_biaya,
            'waktu_menit' => time_to_minutes($dt_svc->estimasi_waktu_jam, $dt_svc->estimasi_waktu_menit),
            'created_at'      => waktu(),
            'created_by'      => 0,
          ];
          $tot_biaya += $dt_svc->estimasi_biaya;
        }
      }
      $book = [
        'id_booking'      => $id_booking,
        'no_polisi'       => $this->input->post('no_polisi'),
        'nama_lengkap'    => $this->input->post('nama_lengkap'),
        'no_wa'           => $this->input->post('no_wa'),
        'id_merk_mobil'   => $this->input->post('id_merk_mobil'),
        'id_jenis_mobil'  => $this->input->post('id_jenis_mobil'),
        'tanggal_booking' => $this->input->post('tanggal_booking'),
        'jam_booking'     => $this->input->post('jam_booking') . ':' . $this->input->post('menit_booking'),
        'alamat'          => $this->input->post('alamat'),
        'provinsi_id'     => $this->input->post('provinsi_id'),
        'kabupaten_id'    => $this->input->post('kabupaten_id'),
        'kecamatan_id'    => $this->input->post('kecamatan_id'),
        'kelurahan_id'    => $this->input->post('kelurahan_id'),
        'batas_waktu_pembayaran_dp' => $this->dm->batasPengirimanDp(),
        'total_dp' => $this->dm->nominalDP($tot_biaya),
        'nominal_unik'    => rand(100, 500),
        'created_at'      => waktu(),
        'created_by'      => 0,
      ];

      $tes = ['book' => $book, 'services' => isset($ins_services) ? $ins_services : null];
      // send_json($tes);
      $this->db->trans_begin();
      $this->db->insert('booking', $book);
      $this->db->insert_batch('booking_services', $ins_services);
      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
      } else {
        $this->db->trans_commit();
        $params = set_crypt("id=$id_booking");
        $response = [
          'status' => 1,
          'link' => site_url('front/success?' . $params)
        ];
        $this->session->set_flashdata(['sukses' => true]);
      }
      send_json($response);
    } else {
      redirect(site_url('front/formDataBooking?' . $keys));
    }
  }

  public function success()
  {
    $params = get_params($this->input->get(), true);
    $filter['id_booking']  = $params['id'];
    $sess = $this->session->flashdata();
    // if (isset($sess['sukses'])) {
    $book = $this->book->getBooking($filter)->row();
    if ($book != null) {
      $data['book'] = $book;
      $this->load->view('front/success', $data);
    } else {
      redirect(site_url('front/services'));
    }
    // } else {
    //   redirect(site_url('front/services'));
    // }
  }

  function getDetailServices()
  {
    $id = $this->input->get('id');
    $f_srv = ['aktif' => 1, 'id_services' => $id, 'select' => 'for_booking_services_details'];
    $data = $this->srv_m->getServices($f_srv)->row();
    $response = [
      'status' => $data == null ? 0 : 1,
      'data' => $data
    ];
    send_json($response);
  }
}
