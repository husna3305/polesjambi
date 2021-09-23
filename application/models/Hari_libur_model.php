<?php
class Hari_libur_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getHariLibur($filter = null)
  {
    $where = 'WHERE 1=1';

    $tgl_mulai   = "SELECT tgl_libur FROm ms_hari_libur mulai WHERE mulai.id_generated = mu.id_generated ORDER BY tgl_libur ASC LIMIT 1";
    $tgl_selesai = "SELECT tgl_libur FROm ms_hari_libur selesai WHERE selesai.id_generated = mu.id_generated ORDER BY tgl_libur DESC LIMIT 1";
    $select = "*,($tgl_mulai) tgl_mulai,($tgl_selesai) tgl_selesai";

    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_generated id, tgl_libur text";
      } elseif ($filter['select'] == 'for_calendar') {
        $select = "keterangan_libur title,($tgl_mulai) start,($tgl_selesai) end";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_generated'])) {
        if ($filter['id_generated'] != '') {
          $where .= " AND mu.id_generated='{$filter['id_generated']}'";
        }
      }
      if (isset($filter['deleted'])) {
        $where .= " AND mu.deleted='{$filter['deleted']}'";
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (mu.id_generated LIKE '%{$filter['search']}%'
                           OR mu.tgl_libur LIKE '%{$filter['search']}%'
                      )
          
          ";
        }
      }
    }

    $order_data = '';
    if (isset($filter['order'])) {
      $order = $filter['order'];
      $order_column = [null, 'tgl_libur', 'aktif', null];
      if ($order != '') {
        $order_clm  = $order_column[$order['0']['column']];
        $order_by   = $order['0']['dir'];
        $order_data = " ORDER BY $order_clm $order_by ";
      }
    }

    $group_by = '';
    if (isset($filter['group_by'])) {
      $group_by = "GROUP BY {$filter['group_by']}";
    }

    $limit = '';
    if (isset($filter['limit'])) {
      $limit = $filter['limit'];
    }

    $data = $this->db->query("SELECT $select
    FROM ms_hari_libur AS mu
    $where
    $group_by
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Hari libur tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
