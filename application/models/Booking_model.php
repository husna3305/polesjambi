<?php
class Booking_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getBooking($filter = null)
  {
    $where = 'WHERE 1=1';
    $tot_servis = "SELECT COUNT(id_booking) FROm booking_services WHERE id_booking=book.id_booking";
    $select = "book.*,merk.merk_mobil,jenis.jenis_mobil,provinsi,kabupaten,kecamatan,kelurahan,($tot_servis) tot_servis,(book.total_dp+book.nominal_unik) grand_tot_dp";
    if (isset($filter['select'])) {
      if ($filter['select'] == 'dropdown') {
        $select = "id_merk_mobil id, merk_mobil text";
      } elseif ($filter['select'] == 'calendar_view') {
        $select = "CONCAT(book.no_polisi,', ',($tot_servis),' services') title,tanggal_booking start,tanggal_booking end";
      }
    }
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_booking'])) {
        if ($filter['id_booking'] != '') {
          $where .= " AND book.id_booking='{$filter['id_booking']}'";
        }
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (book.id_merk_mobil LIKE '%{$filter['search']}%'
                           OR book.merk_mobil LIKE '%{$filter['search']}%'
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
    FROM booking AS book
    JOIN ms_merk_mobil merk ON merk.id_merk_mobil=book.id_merk_mobil
    JOIN ms_jenis_mobil jenis ON jenis.id_jenis_mobil=book.id_jenis_mobil
    LEFT JOIN wilayah_provinsi prov ON prov.provinsi_id=book.provinsi_id
    LEFT JOIN wilayah_kabupaten kab ON kab.kabupaten_id=book.kabupaten_id
    LEFT JOIN wilayah_kecamatan kec ON kec.kecamatan_id=book.kecamatan_id
    LEFT JOIN wilayah_kelurahan kel ON kel.kelurahan_id=book.kelurahan_id
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'ID Booking :' . $filter['id_booking'] . ' Tidak Ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
  function getBookingServices($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "bserv.*,srv.judul";
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_booking'])) {
        if ($filter['id_booking'] != '') {
          $where .= " AND book.id_booking='{$filter['id_booking']}'";
        }
      }
      if (isset($filter['search'])) {
        if ($filter['search'] != '') {
          $filter['search'] = $this->db->escape_str($filter['search']);
          $where .= " AND (book.id_merk_mobil LIKE '%{$filter['search']}%'
                           OR book.merk_mobil LIKE '%{$filter['search']}%'
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
    FROM booking_services AS bserv
    JOIN booking book ON book.id_booking=bserv.id_booking
    JOIN ms_services srv ON srv.id_services=bserv.id_services
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Data booking tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }
  function getBookingPembayaran($filter = null)
  {
    $where = 'WHERE 1=1';
    $select = "bbyr.*";
    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['id_booking'])) {
        if ($filter['id_booking'] != '') {
          $where .= " AND book.id_booking='{$filter['id_booking']}'";
        }
      }
      if (isset($filter['jenis_pembayaran'])) {
        if ($filter['jenis_pembayaran'] != '') {
          $where .= " AND bbyr.jenis_pembayaran='{$filter['jenis_pembayaran']}'";
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
    FROM booking_pembayaran AS bbyr
    JOIN booking book ON book.id_booking=bbyr.id_booking
    $where
    $order_data
    $limit
    ");
    if (isset($filter['response_validate'])) {
      $data = $data->row();
      if ($data == NULL) {
        $response = ['status' => 0, 'pesan' => 'Data pembayaran booking tidak ditemukan'];
        send_json($response);
      } else {
        return $data;
      }
    } else {
      return $data;
    }
  }

  function getBookingPembayaranDp($id_booking)
  {
    $filter['jenis_pembayaran'] = 'dp';
    return $this->getBookingPembayaran($filter);
  }

  function getID()
  {
    $get_data  = $this->db->query("SELECT RIGHT(id_booking,3) id_booking FROM booking 
                  ORDER BY id_booking,created_at DESC LIMIT 0,1");
    if ($get_data->num_rows() > 0) {
      $last_id        = $get_data->row()->id_booking;
      $new = sprintf('%03s', $last_id + 1);
      $new_kode   = gmdate("ymd", time() + 60 * 60 * 7) . $new;
      $i = 0;
      while ($i < 1) {
        $cek = $this->db->get_where('booking', ['id_booking' => $new_kode])->num_rows();
        if ($cek > 0) {
          $last_id = substr($new_kode, -3);
          $new = sprintf('%03s', $last_id + 1);
          $new_kode   = gmdate("ymd", time() + 60 * 60 * 7) . $new;
          $i = 0;
        } else {
          $i++;
        }
      }
    } else {
      $new_kode   = gmdate("ymd", time() + 60 * 60 * 7) . '001';
    }
    return strtoupper($new_kode);
  }
}
