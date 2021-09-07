<?php
class Detailer_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getDetailer($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "mu.*,
    CASE WHEN IFNULL(mu.gambar_small,'')='' THEN 'assets/images/avatars/avatar.png' ELSE mu.gambar_small END gambar_small,
    CASE WHEN IFNULL(mu.gambar_big,'')='' THEN 'assets/images/avatars/avatar.png' ELSE mu.gambar_big END gambar_big,cab.nama_cabang
    ";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_detailer id, detailer text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_detailer'])) {
        if ($filter['id_detailer'] != '') {
          $where .= " AND mu.id_detailer='{$filter['id_detailer']}'";
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
          $where .= " AND (mu.id_detailer LIKE '%{$filter['search']}%'
                           OR mu.nama_detailer LIKE '%{$filter['search']}%'
                           OR mu.no_hp LIKE '%{$filter['search']}%'
                           OR mu.alamat LIKE '%{$filter['search']}%'
                           OR cab.nama_cabang LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'detailer', 'aktif', null];
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
    FROM ms_detailer AS mu
    JOIN ms_cabang cab ON cab.id_cabang=mu.id_cabang
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Data detailer tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
