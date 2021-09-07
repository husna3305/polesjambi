<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengaturan extends Crm_Controller
{
  var $title  = "Pengaturan";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('merk_mobil_model', 'mbl_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'pengaturan_form';
    $data['mode']  = 'insert';
    $data['row'] = $this->dm->getPengaturan();
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user = user();
    $post = $this->input->post();

    $insert = [
      'batas_maks_booking_kedepan'         => $post['batas_maks_booking_kedepan'],
      'batas_maks_booking_kedepan_per'     => $post['batas_maks_booking_kedepan_per'],
      'batas_maks_pembayaran_booking'      => $post['batas_maks_pembayaran_booking'],
      'batas_maks_pembayaran_booking_per'  => $post['batas_maks_pembayaran_booking_per'],
      'nominal_dp_booking'                 => $post['nominal_dp_booking'],
      'nominal_dp_booking_per'             => $post['nominal_dp_booking_per'],
      'toleransi_keterlambatan_datang'     => $post['toleransi_keterlambatan_datang'],
      'toleransi_keterlambatan_datang_per' => $post['toleransi_keterlambatan_datang_per'],
      'aktif'                              => 1,
      'created_at'                         => waktu(),
      'created_by'                         => $user->id_user,
    ];

    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->update('ms_pengaturan', ['aktif' => 0], ['aktif' => 1]);
    $this->db->insert('ms_pengaturan', $insert);
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
}
