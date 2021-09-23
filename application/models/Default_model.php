<?php

class Default_model extends CI_Model
{

  public $users_table;

  public function __construct()
  {
    parent::__construct();
  }

  public function getMenus($filter = null, $id_group = NULL)
  {
    $where = 'WHERE aktif=1 ';
    $where_child = '';
    $user = user();

    if ($filter != null) {
      $filter = $this->db->escape_str($filter);
      if (isset($filter['level'])) {
        $where .= " AND level ={$filter['level']} ";
      }
      if (isset($filter['slug'])) {
        $where .= " AND slug ='{$filter['slug']}' ";
      }
      if (isset($filter['controller'])) {
        $where .= " AND controller ='{$filter['controller']}' ";
      }
      if (isset($filter['slog_or_controller'])) {
        $where .= " AND slug ='{$filter['slug']}' ";
      }
      if (isset($filter['link_show'])) {
        $where .= " AND IFNULL((SELECT akses FROM ms_user_groups_role WHERE id_menu=mu.id_menu AND id_group='$id_group' AND link='show'),0)= 1 ";
      }
      if (isset($filter['link_akses'])) {
        $where .= " AND CASE WHEN mu.links_menu LIKE '%akses%'
                        THEN 
                          IFNULL((SELECT akses FROM ms_user_groups_role WHERE id_menu=mu.id_menu AND id_group='$id_group' AND link='akses'),0)
                        ELSE 0
                        END = 1
        ";
      }
    }
    return $this->db->query("SELECT id_menu,level,
      parent_id_menu,nama_menu,fa_icon_menu,slug,controller,order_menu,
      (SELECT COUNT(parent_id_menu) FROM ms_menu muc WHERE muc.parent_id_menu=mu.id_menu AND aktif=1 $where_child) AS tot_child, links_menu
    FROM ms_menu AS mu 
    $where
    ORDER BY level,order_menu ASC");
  }

  function getAllMenus()
  {
    return $this->db->query("SELECT id_menu,level,
      parent_id_menu,nama_menu,fa_icon_menu,slug,controller,order_menu,
      (SELECT COUNT(parent_id_menu) FROM ms_menu muc WHERE muc.parent_id_menu=mu.id_menu AND aktif=1) AS tot_child, links_menu
    FROM ms_menu AS mu 
    WHERE mu.aktif=1
    ORDER BY level,order_menu ASC");
  }

  function getLastIdIncrement($table)
  {
    return $this->db->query("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES
    WHERE table_name = '$table'")->row()->auto_increment;
  }

  function getPengaturan()
  {
    return $this->db->query("SELECT * FROM ms_pengaturan WHERE aktif=1")->row();
  }
  function batasPengirimanDp()
  {
    $cog = $this->getPengaturan();
    if ($cog->batas_maks_pembayaran_booking_per == 'hours') {
      return tambah_jam(waktu(), $cog->batas_maks_pembayaran_booking);
    } elseif ($cog->batas_maks_pembayaran_booking_per == 'days') {
      return tambah_hari(waktu(), $cog->batas_maks_pembayaran_booking);
    }
  }
  function nominalDP($total)
  {
    $cog = $this->getPengaturan();
    if ($cog->nominal_dp_booking_per == 'persen') {
      return ROUND($total * ($cog->nominal_dp_booking / 100));
    } else {
      return $cog->nominal_dp_booking;
    }
  }
  function getIdGenerated($table, $field)
  {
    $id_generated = generateRandomString(5);
    $i = 0;
    while ($i < 1) {
      $gen = $this->db->query("SELECT $field FROM $table WHERE $field='$id_generated'")->row();
      if ($gen != null) {
        $i = 0;
        $id_generated = generateRandomString(5);
      } else {
        $i = 1;
      }
    }
    return $id_generated;
  }

  function getHariLiburSelalu()
  {
    return $this->db->query("SELECT * FROM ms_hari_libur_selalu")->row();
  }
}
