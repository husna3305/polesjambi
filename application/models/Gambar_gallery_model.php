<?php
class Gambar_gallery_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getGambarGallery($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "*";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_merk_mobil id, merk_mobil text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id'])) {
        if ($filter['id'] != '') {
          $where .= " AND mu.id='{$filter['id']}'";
        }
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (mu.id_merk_mobil LIKE '%{$filter['search']}%'
                           OR mu.merk_mobil LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'merk_mobil', 'aktif', null];
      if ($order != '') {
        $order_clm  = $order_column[$order['0']['column']];
        $order_by   = $order['0']['dir'];
        $order_data = " ORDER BY $order_clm $order_by ";
      }
    }

    $limit = '';
    if (isset($filter['limit'])) {
      $limit = $filter['limit'];
    }

    $data = $this->db->query("SELECT $select
    FROM ms_image_gallery AS mu
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Merk mobil tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }

  function getGambarFor($for=null,$id_gambar=null)
  {
    $where = "WHERE 1=1 ";
    if ($for!=null) {
      $where.="AND for_pages='$for' ";
    }
    if ($id_gambar!=null) {
      $where.="AND mig.id='$id_gambar' ";
    }
    return $this->db->query("SELECT path_img_big,for_pages,
      CASE WHEN for_pages='hasil' THEN 'Hasil Pengerjaan' 
            WHEN for_pages='proses' THEN 'Proses Detailing' 
            ELSE '' 
      END for_pages_desc
      FROM ms_image_gallery mig 
      JOIN ms_image_gallery_for migf ON migf.id_img=mig.id
      $where
    ");
  }

  function getGambarGalleryWithFor()
  {
    $gbr = $this->getGambarGallery()->result();
    foreach ($gbr as $gb) {
      $for =[];
      foreach (for_pages() as $key => $value) {
        $checked = $this->getGambarFor($key,$gb->id)->row();
        $checked = $checked==null?0:1;
        $for[]=['key'=>$key,'value'=>$value,'checked'=>$checked];
      }
      $gb->for = $for;
      $new_res[]=$gb;
    }
    if (isset($new_res)) {
      return $new_res;
    }
  }

}
