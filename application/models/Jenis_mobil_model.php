<?php
class Jenis_mobil_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getJenisMobil($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = '*';
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_jenis_mobil id, jenis_mobil text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_jenis_mobil'])) {
        if ($filter['id_jenis_mobil'] != '') {
          $where .= " AND mu.id_jenis_mobil='{$filter['id_jenis_mobil']}'";
        }
      }
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
          $where .= " AND (mu.id_jenis_mobil LIKE '%{$filter['search']}%'
                           OR mu.jenis_mobil LIKE '%{$filter['search']}%'
                           OR mb.merk_mobil LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'jenis_mobil', 'merk_mobil', 'aktif', null];
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
    FROM ms_jenis_mobil AS mu
    JOIN ms_merk_mobil mb ON mb.id_merk_mobil=mu.id_merk_mobil
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Jenis mobil tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
