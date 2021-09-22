<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer extends Crm_Controller
{
  var $title  = "Laporan Customer";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('merk_mobil_model', 'mbl_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'customer_index';
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
          <p style="font-weight:500" class="mb-0">User A melakukan booking 4 services untuk mobil ' . $rs->mobil . '</p>
          <p style="font-size:13px" class="mb-0">Booking untuk tanggal : 01 September 2021, 08:00</p>
        </div>
      </div>
      <div class="ms-auto">';
      if ($rs->id == 1) {
        $html .= '<button type="button" class="btn btn-outline-primary btn-sm">Menunggu Pembayaran</button>';
      } elseif ($rs->id == 2) {
        $html .= '<button type="button" class="btn btn-outline-info btn-sm">Menunggu Kedatangan</button>';
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
      $sample[] = ['id' => 1, 'mobil' => 'Toyota Avanza', 'aktif' => 1];
      $sample[] = ['id' => 2, 'mobil' => 'Daihatsu Xenia', 'aktif' => 1];
      $sample = json_decode(json_encode($sample), FALSE);
      return $sample;
    }
  }
  function tes()
  {
    // $this->load->library('pdfgenerator');
    // $file_pdf = strtotime(waktu());
    // $paper = 'A4';
    // $orientation = "portrait";
    // $html = "<p>Tes</p>";
    // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

    // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
    $this->load->library('pdfgenerator');

    // title dari pdf
    $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';

    // filename dari pdf ketika didownload
    $file_pdf = 'laporan_penjualan_toko_kita';
    // setting paper
    $paper = 'A4';
    //orientasi paper potrait / landscape
    $orientation = "portrait";

    // $html = $this->load->view('laporan_pdf', $this->data, true);
    $html = "<p>Tes</p>";

    // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
