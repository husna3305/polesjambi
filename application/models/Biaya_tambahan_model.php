<?php
class Biaya_tambahan_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getBiayaTambahan($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "*";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_tambahan id, deskripsi_tambahan text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_tambahan'])) {
        if ($filter['id_tambahan'] != '') {
          $where .= " AND mu.id_tambahan='{$filter['id_tambahan']}'";
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
          $where .= " AND (mu.id_tambahan LIKE '%{$filter['search']}%'
                           OR mu.deskripsi_tambahan LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'deskripsi_tambahan', 'aktif', null];
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
    FROM ms_biaya_tambahan AS mu
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Biaya tambahan tidak ditemukan'];
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
    $get_data  = $this->db->query("SELECT id_tambahan FROM ms_biaya_tambahan WHERE id_tambahan!=999
                  ORDER BY id_tambahan DESC LIMIT 0,1");
    if ($get_data->num_rows() > 0) {
      $row        = $get_data->row();
      $new_kode   = $row->id_tambahan + 1;
      $i = 0;
      while ($i < 1) {
        $cek = $this->db->get_where('ms_biaya_tambahan', ['id_tambahan' => $new_kode])->num_rows();
        if ($cek > 0) {
          $new_kode   = $new_kode + 1;
          $i = 0;
        } else {
          $i++;
        }
      }
    } else {
      $new_kode   = 1;
    }
    return strtoupper($new_kode);
  }
}
