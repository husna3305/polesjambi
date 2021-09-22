<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer extends Crm_Controller
{
  var $title  = "Laporan Customer";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('booking_model', 'book_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'customer_index';
    $this->template_portal($data);
  }

  function getReport()
  {
    $this->load->library('pdfgenerator');
    $params = json_decode($_GET['params'], true);

    // title dari pdf
    $this->data['title'] = 'Laporan Data Customer';
    $this->data['params'] = $params;
    $this->data['details'] = $this->book_m->getBooking()->result();

    // filename dari pdf ketika didownload
    $file_pdf = $this->data['file_pdf'] = 'laporan_data_customer_' . strtotime(waktu());
    // setting paper
    $paper = 'A4';
    //orientasi paper potrait / landscape
    $orientation = "portrait";
    if ($params['tipe'] == 'pdf') {
      $html = $this->load->view(get_controller() . '/customer_cetak', $this->data, true);
      $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    } else {
      $html = $this->load->view(get_controller() . '/customer_cetak', $this->data);
    }
  }
}
