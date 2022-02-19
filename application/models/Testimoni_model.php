<?php
class Testimoni_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getTestimoni($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "mu.*";
    $join = '';
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id id, judul text";
      }
    }
    if ($filter != null) {
      if (isset($filter['id_in'])) {
        if ($filter['id_in'] != '') {
          $where .= " AND mu.id IN ({$filter['id_in']})";
        }
      }
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id'])) {
        if ($filter['id'] != '') {
          $where .= " AND mu.id='{$filter['id']}'";
        }
      }
      if (isset($filter['deleted'])) {
        $where .= " AND mu.deleted='{$filter['deleted']}'";
      }
      if (isset($filter['aktif'])) {
        $where .= " AND mu.aktif='{$filter['aktif']}'";
      }
      if (isset($filter['filter_id_booking'])) {
        $join .= " LEFT JOIN booking_services bs ON bs.id_booking='{$filter['filter_id_booking']}' AND bs.id=mu.id";
        $where .= " AND bs.id IS NULL";
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (mu.id LIKE '%{$filter['search']}%'
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
    FROM ms_testimoni AS mu
    $join
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Testimoni tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
