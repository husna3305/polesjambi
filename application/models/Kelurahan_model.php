<?php
class Kelurahan_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getKelurahan($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "*";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "kelurahan_id id, kelurahan text";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['provinsi_id'])) {
        if ($filter['provinsi_id'] != '') {
          $where .= " AND kab.provinsi_id='{$filter['provinsi_id']}'";
        }
      }
      if (isset($filter['kabupaten_id'])) {
        if ($filter['kabupaten_id'] != '') {
          $where .= " AND kab.kabupaten_id='{$filter['kabupaten_id']}'";
        }
      }
      if (isset($filter['kecamatan_id'])) {
        if ($filter['kecamatan_id'] != '') {
          $where .= " AND kec.kecamatan_id='{$filter['kecamatan_id']}'";
        }
      }
      if (isset($filter['kelurahan_id'])) {
        if ($filter['kelurahan_id'] != '') {
          $where .= " AND mu.kelurahan_id='{$filter['kelurahan_id']}'";
        }
      }
      if (isset($filter['kelurahan'])) {
        if ($filter['kelurahan'] != '') {
          $where .= " AND mu.kelurahan='{$filter['kelurahan']}'";
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
          $where .= " AND (kab.provinsi_id LIKE '%{$filter['search']}%'
                           OR prov.provinsi LIKE '%{$filter['search']}%'
                           OR kab.kabupaten LIKE '%{$filter['search']}%'
                           OR kab.kabupaten_id LIKE '%{$filter['search']}%'
                           OR kec.kecamatan LIKE '%{$filter['search']}%'
                           OR mu.kecamatan_id LIKE '%{$filter['search']}%'
                           OR mu.kelurahan LIKE '%{$filter['search']}%'
                           OR mu.kelurahan_id LIKE '%{$filter['search']}%'
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
    FROM wilayah_kelurahan AS mu
    JOIN wilayah_kecamatan kec ON kec.kecamatan_id=mu.kecamatan_id
    JOIN wilayah_kabupaten kab ON kab.kabupaten_id=kec.kabupaten_id
    JOIN wilayah_provinsi prov ON prov.provinsi_id=kab.provinsi_id
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Kelurahan tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
}
