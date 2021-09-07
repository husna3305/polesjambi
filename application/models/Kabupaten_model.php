<?php
class Kabupaten_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getKabupaten($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "*";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "kabupaten_id id, kabupaten text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['provinsi_id'])) {
        if ($filter['provinsi_id'] != '') {
          $where .= " AND mu.provinsi_id='{$filter['provinsi_id']}'";
        }
      }
      if (isset($filter['kabupaten_id'])) {
        if ($filter['kabupaten_id'] != '') {
          $where .= " AND mu.kabupaten_id='{$filter['kabupaten_id']}'";
        }
      }
      if (isset($filter['aktif'])) {
        if ($filter['aktif'] != '') {
          $where .= " AND mu.aktif='{$filter['aktif']}'";
        }
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (mu.provinsi_id LIKE '%{$filter['search']}%'
                           OR prov.provinsi LIKE '%{$filter['search']}%'
                           OR mu.kabupaten LIKE '%{$filter['search']}%'
                           OR mu.kabupaten_id LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'provinsi', 'aktif', null];
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
    FROM wilayah_kabupaten AS mu
    JOIN wilayah_provinsi prov ON prov.provinsi_id=mu.provinsi_id
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Kabupaten tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
