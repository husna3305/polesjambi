<?php
class Services_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getServices($filter = null)
  {
    $where = 'WHERE 1=1';
    $gambar_small = "(SELECT gambar_small FROM ms_services_gambar WHERE id_services=mu.id_services AND utama=1 ORDER BY created_at DESC LIMIT 1)";
    $gambar_big = "(SELECT gambar_big FROM ms_services_gambar WHERE id_services=mu.id_services AND utama=1 ORDER BY created_at DESC LIMIT 1)";
    $select = "mu.*,
    CASE WHEN IFNULL($gambar_small,'')='' THEN 'assets/images/logo-icon.png' ELSE $gambar_small END gambar_small,
    CASE WHEN IFNULL($gambar_big,'')='' THEN 'assets/images/logo-icon.png' ELSE $gambar_big END gambar_big
    ";
    $join = '';
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_services id, judul text";
      } elseif ($filter['select'] == 'for_booking_services') {
        $select = "id_services,judul,CASE WHEN IFNULL($gambar_small,'')='' THEN 'assets/images/logo-icon.png' ELSE $gambar_small END gambar_small,estimasi_biaya,estimasi_waktu_menit,estimasi_waktu_jam,0 dipilih,kategori";
      } elseif ($filter['select'] == 'for_booking_services_details') {
        $select = "id_services,judul,deskripsi";
      }
    }
    if ($filter != null) {
      if (isset($filter['id_services_in'])) {
        if ($filter['id_services_in'] != '') {
          $where .= " AND mu.id_services IN ({$filter['id_services_in']})";
        }
      }
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_services'])) {
        if ($filter['id_services'] != '') {
          $where .= " AND mu.id_services='{$filter['id_services']}'";
        }
      }
      if (isset($filter['deleted'])) {
        $where .= " AND mu.deleted='{$filter['deleted']}'";
      }
      if (isset($filter['aktif'])) {
        $where .= " AND mu.aktif='{$filter['aktif']}'";
      }
      if (isset($filter['filter_id_booking'])) {
        $join .= " LEFT JOIN booking_services bs ON bs.id_booking='{$filter['filter_id_booking']}' AND bs.id_services=mu.id_services";
        $where .= " AND bs.id_services IS NULL";
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (mu.id_services LIKE '%{$filter['search']}%'
                           OR mu.judul LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'judul', 'aktif', null];
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
    FROM ms_services AS mu
    $join
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Services tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
