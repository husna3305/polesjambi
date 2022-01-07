<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gambar_landing_page extends Crm_Controller
{
  var $title  = "Gambar Landing Page";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('gambar_gallery_model', 'gbr_m');
  }

  public function index()
  {
    $data['title']    = $this->title;
    $data['file']     = 'gambar_landing_page_form';
    $data['mode']     = 'insert';
    $data['gambars']  = $this->gbr_m->getGambarGalleryWithFor();
    // send_json($data);
    $this->template_portal($data);
  }

  function upload_gambar()
  {
    $id = next_auto_increment('ms_image_gallery');
    $user = user();
    $this->load->library('upload');
    $path = "./uploads/landing";
    if (!is_dir($path)) {
      mkdir($path, 0777, true);
    }

    $config['upload_path']        = $path;
    $config['allowed_types']      = 'jpg|png|jpeg|bmp';
    $config['max_size']           = '2024';
    $config['max_width']          = '3000';
    $config['max_height']         = '3000';
    $config['remove_spaces']      = TRUE;
    $config['overwrite']          = TRUE;
    $config['file_ext_tolower']   = TRUE;
    $config['file_name']          = $id;
    $this->upload->initialize($config);
    if ($this->upload->do_upload('gambar')) {
      $new_path = substr($path, 2, 40);
      $filename = $this->upload->file_name;
      $params = [
        'path' => $path,
        'file_name' => $this->upload->file_name
      ];
      $dt['path_img_big'] = $new_path . '/' . $filename;
      $dt['path_img_small'] = $new_path . '/' . create_thumbs($params);
    } else {
      $response = ['status' => 0, 'pesan' => $this->upload->display_errors()];
      send_json($response);
    }
    $insert =[
      'created_at' => waktu(),
      'created_by' => $user->id_user,
      'path_img_big'=>$dt['path_img_big'],
      'path_img_small'=>$dt['path_img_small'],
    ];
    $tes = ['insert' => $insert];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert('ms_image_gallery', $insert);
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

  public function atur_gambar()
  {
    $user = user();
    $for = $this->input->post('for');
    $this->db->trans_begin();
    $id_img = $this->input->post('id');
    foreach ($for as $key => $val) {
      $checked = $val['checked'];
      $cond = ['for_pages'=>$val['key'], 'id_img'=>$id_img];

      if ($checked==1) {
        $cek = $this->db->get_where('ms_image_gallery_for',$cond)->row();
        if ($cek==null) {
          $ins_upd=[
            'id_img'=>$id_img,
            'for_pages'=>$val['key'],
            'created_at'=>waktu(),
            'created_by'=>$user->id_user
          ];
          $this->db->insert('ms_image_gallery_for',$ins_upd);
        }
      }else{
        $this->db->delete('ms_image_gallery_for',$cond);
      }
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
  
  public function hapus_gambar()
  {
    $user = user();
    $id = $this->input->post('id');
    $gambar = $this->db->get_where('ms_image_gallery',['id'=>$id])->row();
    $this->db->trans_begin();
    $cond = ['id_img'=>$id];
    $this->db->delete('ms_image_gallery_for',$cond);
    $cond = ['id'=>$id];
    $this->db->delete('ms_image_gallery',$cond);
    //Hapus File
    if (file_exists(base_url($gambar->path_img_small))) {   
      unlink($gambar->path_img_small);
    }
    if (file_exists(base_url($gambar->path_img_big))) {   
      unlink($gambar->path_img_big);
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
      $this->session->set_flashdata(msg_sukses('Berhasil menghapus data'));
    }
    send_json($response);
  }
}
