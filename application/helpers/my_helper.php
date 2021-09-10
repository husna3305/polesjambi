<?php

function search_array($array, $search_list)
{

  // Create the result array 
  $result = array();

  // Iterate over each array element 
  foreach ($array as $key => $value) {

    // Iterate over each search condition 
    foreach ($search_list as $k => $v) {

      // If the array element does not meet 
      // the search condition then continue 
      // to the next element 
      if (!isset($value[$k]) || $value[$k] != $v) {

        // Skip two loops 
        continue 2;
      }
    }

    // Append array element's key to the 
    //result array 
    $result[] = $value;
  }

  // Return result  
  return $result;
}

function tanggal()
{
  return gmdate("Y-m-d", time() + 60 * 60 * 7);
}
function tahun()
{
  return gmdate("Y", time() + 60 * 60 * 7);
}
function tahun_bulan()
{
  return gmdate("Y-m", time() + 60 * 60 * 7);
}

function waktu()
{
  return gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
}
function jam()
{
  return gmdate("H:i", time() + 60 * 60 * 7);
}

function _imp($arr)
{
  $expl = explode(',', $arr);
  // $res = '';
  foreach ($expl as $val) {
    $res[] = "'$val'";
  }
  return implode(',', $res);
}

function arr_sql($arr)
{
  foreach ($arr as $val) {
    $res[] = "'$val'";
  }
  if (isset($res)) {
    return implode(',', $res);
  } else {
    return "'-'";
  }
}

function send_json($arr)
{
  echo json_encode($arr);
  die();
}

function msg_wrong()
{
  return ['status' => 'error', 'judul' => 'Peringatan', 'pesan' => 'Telah terjadi kesalahan !'];
}
function msg_kombinasi_login_salah()
{
  return 'Kombinasi Email atau Username dengan Password Anda salah. Mohon cek kembali';
}
function msg_not_found()
{
  return  ['status' => 'error', 'title' => 'Peringatan', 'text' => 'Data tidak ditemukan'];
}
function msg_error($pesan)
{
  return ['status' => 'error', 'title' => 'Peringatan', 'text' => $pesan];
}
function msg_sukses($text)
{
  return  ['status' => 'success', 'title' => 'Informasi', 'text' => $text];
}
function msg_sukses_simpan()
{
  return  ['status' => 'success', 'title' => 'Informasi', 'text' => 'Data berhasil disimpan'];
}
function msg_sukses_update()
{
  return  ['status' => 'success', 'title' => 'Informasi', 'text' => 'Data berhasil diupdate'];
}

function msg_sukses_upload()
{
  return  ['status' => 'success', 'title' => 'Success!', 'text' => 'Upload data berhasil'];
}

function msg_sukses_hapus()
{
  return  ['status' => 'success', 'title' => 'Informasi', 'text' => 'Data berhasil dihapus'];
}

function msg_no_access()
{
  return  ['status' => 'error', 'title' => 'Peringatan', 'text' => 'Anda tidak memiliki akses'];
}

function random_numbers($digits)
{
  $min = pow(10, $digits - 1);
  $max = pow(10, $digits) - 1;
  return mt_rand($min, $max);
}

function alnum($string)
{
  return preg_replace("/[^a-zA-Z0-9]+/", "", $string);
}


function random_id()
{
  return substr(strtotime(waktu()), -6) . random_numbers(2);
}

function create_thumbs($params)
{
  $CI = &get_instance();

  $exp_file_name = explode('.', $params['file_name']);
  $file_name_thumb = $exp_file_name[0] . '-small.' . $exp_file_name[1];
  $new_image_small = $params['path'] . '/' . $file_name_thumb;

  // Image resizing config
  $config = array(
    // // Image Large
    // array(
    //   'image_library' => 'GD2',
    //   'source_image'  => './assets/images/' . $file_name,
    //   'maintain_ratio' => FALSE,
    //   'width'         => 700,
    //   'height'        => 467,
    //   'new_image'     => './assets/images/large/' . $file_name
    // ),
    // // image Medium
    // array(
    //   'image_library' => 'GD2',
    //   'source_image'  => './assets/images/' . $file_name,
    //   'maintain_ratio' => FALSE,
    //   'width'         => 600,
    //   'height'        => 400,
    //   'new_image'     => './assets/images/medium/' . $file_name
    // ),
    // Image Small
    array(
      'image_library' => 'GD2',
      'source_image'  => $params['path'] . '/' . $params['file_name'],
      'maintain_ratio' => TRUE,
      // 'create_thumb' => TRUE,
      'width'         => 250,
      // 'height'        => 200,
      // 'thumb_marker' => '_thumb',
      'new_image'     => $new_image_small
    )
  );
  // send_json($config);
  $CI->load->library('image_lib', $config[0]);
  foreach ($config as $item) {
    $CI->image_lib->initialize($item);
    if (!$CI->image_lib->resize()) {
      return false;
    }
    $CI->image_lib->clear();
  }

  return $file_name_thumb;
}


function date2min($hms)
{

  // $fromTime = strtotime($hms);
  // // send_json($fromTime);
  // $getMins = round(abs($fromTime) / 60, 2);

  // $getMins = date('i', strtotime($hms));

  $time = explode(':', $hms);
  $getMins = ($time[0] * 60) + ($time[1]) + ($time[2] / 60);

  return $getMins;
}


function get_slug($cek = false)
{
  $CI = &get_instance();
  $segment =  $CI->uri->segment(1);

  $links = array_keys(links_on_table());
  $links[] = 'fetchData';
  $links[] = 'saveData';
  $links[] = 'saveEdit';
  $links[] = 'insert';
  $links[] = 'detail';
  $links[] = 'saveRoleAkses';
  $links[] = 'saveDataFileToDB';
  $links[] = 'saveBuktiPembayaranDP';

  if ($CI->uri->segment(2) != NULL) {
    $seg2 = $CI->uri->segment(2);
    if (!in_array($seg2, $links)) {
      $segment .= "/$seg2";
    }
  }
  if ($CI->uri->segment(3) != NULL) {
    $seg3 = $CI->uri->segment(3);
    if (!in_array($seg3, $links)) {
      $segment .= "/$seg3";
    }
  }

  if ($CI->uri->segment(4) != NULL) {
    $seg4 = $CI->uri->segment(4);
    if (!in_array($seg4, $links)) {
      $segment .= "/$seg4";
    }
  }

  if ($cek == true) {
    $cek = 'w';
  }
  $cek = $CI->db->query("SELECT slug FROM ms_menu WHERE slug='$segment' OR controller='$segment' $cek")->row();
  if ($cek != NULL) {
    return $cek->slug;
  }
}

function get_controller()
{
  $CI = &get_instance();
  $segment =  $CI->uri->segment(1);
  $links = array_keys(links_on_table());
  $links[] = 'fetchData';
  $links[] = 'saveData';
  $links[] = 'saveEdit';
  $links[] = 'insert';
  $links[] = 'detail';
  $links[] = 'role_akses';
  $links[] = 'saveBuktiPembayaranDP';
  $links[] = 'saveRoleAkses';
  $links[] = 'saveDataFileToDB';

  if ($CI->uri->segment(2) != '') {
    $seg2 = $CI->uri->segment(2);
    if (!in_array($seg2, $links)) {
      $segment .= "/$seg2";
    }
  }

  if ($CI->uri->segment(3) != NULL) {
    $seg3 = $CI->uri->segment(3);
    if (!in_array($seg3, $links)) {
      $segment .= "/$seg3";
    }
  }

  if ($CI->uri->segment(4) != NULL) {
    $seg4 = $CI->uri->segment(4);
    if (!in_array($seg4, $links)) {
      $segment .= "/$seg4";
    }
  }
  $cek = $CI->db->query("SELECT controller FROM ms_menu WHERE slug='$segment' OR controller='$segment'")->row();
  if ($cek != NULL) {
    return $cek->controller;
  }
}

function all_links()
{
  $CI = &get_instance();
  $cek = $CI->db->query("SELECT link, deskripsi, ikon FROM ms_menu_links ORDER BY order_link ASC")->result();
  $ck = [];
  foreach ($cek as $c) {
    $ck[$c->link] = ['ikon' => $c->ikon, 'deskripsi' => $c->deskripsi];
  }
  return $ck;
}

function links_on_table()
{
  $links = [
    'detail' => [
      'class' => "",
      'icon' => '<i class="fa fa-eye"></i>',
      'title' => 'Detail',
      'show_title' => 0,
      'tipe' => 'href',
    ],
    'edit' => [
      'class' => "",
      'icon' => '<i class="fa fa-edit"></i>',
      'title' => 'Edit',
      'show_title' => 0,
      'tipe' => 'href',
    ],
    'role_akses' => [
      'class' => "",
      'icon' => '<i class="fa fa-cogs"></i>',
      'title' => 'Role Akses',
      'show_title' => 0,
      'tipe' => 'href',
    ],
    'history' => [
      'class' => "",
      'icon' => '<i class="fa fa-list"></i>',
      'title' => 'History',
      'show_title' => 0,
      'tipe' => 'button',
      'function' => 'showHistoryLeads'
    ],
    'delete' => [
      'class'      => "color-red",
      'icon'       => '<i class = "fa fa-trash"></i>',
      'title'      => 'Hapus',
      'show_title' => 0,
      'tipe'       => 'button',
      'function'   => 'deleteData'
    ]

  ];
  return $links;
}

function json_link()
{
  $links = [];
  foreach (all_links() as $key => $value) {
    $links[] = $key;
  }
  return json_encode($links);
}

function link_on_data_details($params, $id_group, $skip_if = NULL)
{
  $CI = &get_instance();
  $filter = [
    'controller' => get_controller()
  ];
  $links = links_on_table();
  $menu = $CI->dm->getMenus($filter)->row();
  $button = '<div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm">Action</button>
                <button type="button" class="btn btn-outline-secondary split-bg-outline-secondary dropdown-toggle dropdown-toggle-split btn-sm" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
              <ul class="dropdown-menu">';
  $explode_links = explode(',', $menu->links_menu);
  $get_links = cekAkasesMenuBySlug($id_group, $menu->slug);
  $explode_links = [];
  foreach ($get_links as $lks) {
    if ($id_group == 1) {
      $explode_links[] = $lks->link;
    } else {
      if ($lks->akses == 1) {
        $explode_links[] = $lks->link;
      }
    }
  }
  foreach ($links as $key => $lk) {
    if (in_array($key,  $explode_links)) {
      $title = $lk['title'];
      $parameter = set_crypt(preg_replace('/\s+/', '', $params['get']));
      $url = site_url("$menu->slug/$key?$parameter");
      if ($lk['tipe'] == 'href') {
        $button .= '<li><a class="dropdown-item" href="' . $url . '">' . $lk['icon'] . ' ' . $title . '</a></li>';
      } else {
        $params_delete = json_encode(['url' => $url]);
        $function = $lk['function'];
        $parameter = substr($parameter, 0, 20);
        $button .= "<script>var_$parameter=$params_delete</script>";
        $button .= '<li><button type="button" class="dropdown-item ' . $lk['class'] . '" onclick="' . $function . '(this,var_' . $parameter . ')">' . $lk['icon'] . ' ' . $title . '</button></li>';
      }
    }
  }
  $button .= "</ul>
  </div>";
  return $button;
}

function link_on_data_top($id_group)
{
  $slug = get_slug();
  $button = '';

  $buttons['insert'] = '<a href="' . site_url($slug . '/insert') . '"> <button class="btn bg-blue btn-flat"><i class="fa fa-plus"></i> Add New</button></a>';
  $buttons['upload'] = '<button class="btn btn-info btn-flat" onclick="upload(this)"><i class="fa fa-upload"></i> Upload</button>';
  //Cek Insert
  $links = cekAkasesMenuBySlug($id_group, $slug);
  foreach ($links as $lk) {
    if (isset($buttons[$lk->link]) && $lk->akses == 1) {
      $button .= $buttons[$lk->link];
    }
  }
  return $button;
}

function clear_removed_html($value)
{
  return str_replace('[removed]', '', $value);
}

function convert_datetime($val)
{
  $explode = explode(' ', $val);
  if (count($explode) > 1) {
    $explode[1] = sprintf('%02s', date_parse($explode[1])['month']);
    return $explode[2] . '-' . $explode[1] . '-' . $explode[0] . ' ' . $explode[3];
  } else {
    return $val;
  }
}

function time_to_minutes($jam, $menit)
{
  $from = date('Y-m-d 00:00:00');
  $waktu = sprintf('%02s', $jam) . ':' . sprintf('%02s', $menit) . ':00';
  $to = date('Y-m-d ' . $waktu);
  $diff = strtotime($to) - strtotime($from);
  $minutes = $diff / 60;
  return  $minutes;
}

function convert_datetime_str($val)
{
  return date("d F Y H:i:s", strtotime($val));
}

function convert_no_hp($val)
{
  if (substr($val, 0, 1) == '+') {
    $val = '0' . substr($val, 3, 30);
  }
  return $val;
}

function convert_no_telp($val)
{
  if (substr($val, 0, 1) == '+') {
    $val = '0' . substr($val, 2, 30);
  }
  return $val;
}

function sql_convert_date($field)
{
  return "DATE_FORMAT($field,'%d %M %Y %H:%i:%s')";
}

function sql_convert_date_dmy($field)
{
  return "DATE_FORMAT($field,'%d/%m/%Y')";
}

function date_iso_8601_to_datetime($date)
{
  return date('Y-m-d H:i:s', strtotime($date));
}

function selisih_2tanggal($start, $end)
{
  $tgl1 = new DateTime(substr($start, 0, 10));
  $tgl2 = new DateTime(substr($end, 0, 10));
  return $tgl2->diff($tgl1);
}

function selisih_detik($start, $end)
{
  $tgl1 = strtotime($start);
  $tgl2 = strtotime($end);
  return $tgl2 - $tgl1;
}

function detik_ke_menit($detik)
{
  return round($detik / 60);
}

function detik_ke_jam($detik)
{
  $menit = detik_ke_menit($detik);
  return round($menit / 60);
}

function detik_ke_hari($detik)
{
  $jam = detik_ke_jam($detik);
  return round($jam / 24);
}

function convert_date($val)
{
  $date = str_replace('/', '-', $val);
  return date('Y-m-d', strtotime($date));
}

function clean_no_hp($no_hp)
{
  $no_hp = preg_replace("/[^0-9]+/", "", $no_hp);
  if (substr($no_hp, 0, 3) == '62') {
    $no_hp = '0' . substr($no_hp, 3, 30);
  } elseif (substr($no_hp, 0, 2) == '62') {
    $no_hp = '0' . substr($no_hp, 2, 30);
  } elseif (substr($no_hp, 0, 1) != '0') {
    $no_hp = '0' . substr($no_hp, 1, 30);
  }
  return $no_hp;
}

function set_periode($input)
{
  $periode = explode('-', $input);
  $periodeSet = NULL;
  if (count($periode) > 1) {
    foreach ($periode as $val) {
      $periodeSet[] = convert_date(str_replace(' ', '', $val));
    }
  }
  return $periodeSet;
}

function dMYHIS_en()
{
  return gmdate("d F Y H:i:s", time() + 60 * 60 * 7);
}

function cek_error_no_hp($no_hp)
{
  if (strlen($no_hp) < 10) {
    return 'No. HP kurang dari 10 karakter';
  } elseif (strlen($no_hp) > 15) {
    return 'No. HP kurang dari 15 karakter';
  }
}

function cekISO8601Date($dateStr)
{
  if (preg_match('/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/', $dateStr) > 0) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function tanggal_lebih_kecil($awal, $akhir)
{
  if (strtotime($awal) < strtotime($akhir)) {
    return true;
  } else {
    return false;
  }
}

function empty_to_min($val)
{
  return $val == '' ? '-' : $val;
}

function title($adds = '')
{
  return 'polesjambi.com ' . $adds;
}

function set_crypt($string, $action = 'e')
{
  // you may change these values to your own
  $secret_key = 'ecRzJZWlA3dVJTaCtzZnJpRjM3b0h2V2Y3Z2c0NG5CRGlCSTQ4VzNocGRWWT0';
  $secret_iv = 'ecYlVsYnR3cWI5TDhPd1FIWGlkRTJLQT09';

  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash('sha256', $secret_key);
  $iv = substr(hash('sha256', $secret_iv), 0, 16);

  if ($action == 'e') {
    $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
  } else if ($action == 'd') {
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }

  return $output;
}

function get_params($params, $redirect = false)
{
  foreach ($params as $key => $value) {
    $keys = $key;
  }
  $decrypt_params = set_crypt($keys, 'd');
  $exp = explode('&', $decrypt_params);
  $is_redirect = false;
  if (count($exp) > 0) {
    foreach ($exp as $val) {
      $pr = explode('=', $val);
      if (isset($pr[1])) {
        $exp_params[$pr[0]] = $pr[1];
      }
    }
    if (isset($exp_params)) {
      return $exp_params;
    } else {
      $is_redirect = true;
    }
  } else {
    $is_redirect = true;
  }
  if ($redirect == true && $is_redirect == true) {
    $CI = &get_instance();
    $CI->session->set_flashdata(msg_not_found());
    redirect(get_slug());
  }
}

function mata_uang_rp($val)
{
  if (is_numeric($val)) {
    return 'Rp. ' . number_format($val, 0, '.', '.');
  } else {
    return $val;
  }
}

function loop_dates($start, $end)
{
  $set_start = new DateTime($start);
  $set_end = new DateTime($end);

  $interval = DateInterval::createFromDateString('1 day');
  $period = new DatePeriod($set_start, $interval, $set_end);

  foreach ($period as $dt) {
    $res[] = $dt->format("Y-m-d");
  }
  if (isset($res)) {
    $res[] = $end;
    return $res;
  }
}


function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}


function theme_style()
{
  $CI   = &get_instance();
  $user = user();
  $res = $CI->db->query("SELECT theme_style FROM setting_theme_customizer WHERE id_user=$user->id_user")->row();
  if ($res != null) {
    return $res->theme_style;
  }
}
function batas_maksimal_booking()
{
  $CI   = &get_instance();
  $res = $CI->db->query("SELECT batas_maks_booking_kedepan FROM ms_pengaturan WHERE aktif=1 ORDER BY id_pengaturan LIMIT 1")->row();
  if ($res != null) {
    return tambah_hari(waktu(), $res->batas_maks_booking_kedepan);
  }
}

function sidebar_background()
{
  $CI   = &get_instance();
  $user = user();
  $res = $CI->db->query("SELECT sidebar_background FROM setting_theme_customizer WHERE id_user=$user->id_user")->row();
  if ($res != null) {
    if ($res->sidebar_background != '') {
      return 'color-sidebar ' . $res->sidebar_background;
    }
  }
}
function headercolor()
{
  $CI   = &get_instance();
  $user = user();
  $res = $CI->db->query("SELECT header_colors FROM setting_theme_customizer WHERE id_user=$user->id_user")->row();
  if ($res != null) {
    if ($res->header_colors != '') {
      return 'color-header ' . $res->header_colors;
    }
  }
}

function tambah_hari($datetime, $hari)
{
  if (function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
  $date = date_create($datetime);
  date_add($date, date_interval_create_from_date_string("$hari days"));
  return date_format($date, 'Y-m-d H:i:s');
}

function tambah_jam($datetime, $jam)
{
  if (function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
  $date = date_create($datetime);
  date_add($date, date_interval_create_from_date_string("$jam hours"));
  return date_format($date, 'Y-m-d H:i:s');
}
