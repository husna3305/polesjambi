<?php
class Merk_mobil_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getMerkMobil($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "*,
    CASE WHEN IFNULL(mu.logo_small,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_small END logo_small,
    CASE WHEN IFNULL(mu.logo_big,'')='' THEN 'assets/images/logo-icon.png' ELSE mu.logo_big END logo_big
    ";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_merk_mobil id, merk_mobil text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_merk_mobil'])) {
        if ($filter['id_merk_mobil'] != '') {
          $where .= " AND mu.id_merk_mobil='{$filter['id_merk_mobil']}'";
        }
      }
      if (isset($filter['deleted'])) {
        $where .= " AND mu.deleted='{$filter['deleted']}'";
      }
      if (isset($filter['aktif'])) {
        $where .= " AND mu.aktif='{$filter['aktif']}'";
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
    FROM ms_merk_mobil AS mu
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

  function getID()
  {
    $get_data  = $this->db->query("SELECT RIGHT(id_user,3) id_user FROM ms_users 
                  ORDER BY created_at DESC LIMIT 0,1");
    if ($get_data->num_rows() > 0) {
      $row        = $get_data->row();
      $new_kode   = substr(strtotime(waktu()), 5) . random_numbers(3);
      $i = 0;
      while ($i < 1) {
        $cek = $this->db->get_where('ms_users', ['id_user' => $new_kode])->num_rows();
        if ($cek > 0) {
          $new_kode   = substr(strtotime(waktu()), 5) . random_numbers(3);
          $i = 0;
        } else {
          $i++;
        }
      }
    } else {
      $new_kode   = substr(strtotime(waktu()), 5) . random_numbers(3);
    }
    return strtoupper($new_kode);
  }
}
