<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Hari_libur extends Crm_Controller
{
  var $title  = "Hari Libur";

  public function __construct()
  {
    parent::__construct();
    if (!logged_in()) redirect('auth/login');
    $this->load->model('hari_libur_model', 'lbr_m');
  }

  public function index()
  {
    $data['title'] = $this->title;
    $data['file']  = 'hari_libur_index';
    if (isset($_GET['isCalendar'])) {
      $data['isCalendar'] = true;
    }
    $this->template_portal($data);
  }

  public function fetchData()
  {
    $fetch_data = $this->_makeQuery();
    $user = user();
    $data = array();
    $no = $this->input->post('start') + 1;
    foreach ($fetch_data as $rs) {
      $params      = [
        'get'   => "id_generated=" . $rs->id_generated
      ];

      $sub_array   = array();
      $sub_array[] = $no;
      $sub_array[] = $rs->tgl_mulai;
      $sub_array[] = $rs->tgl_selesai;
      $sub_array[] = $rs->keterangan_libur;
      $sub_array[] = link_on_data_details($params, $user->id_group);
      $data[]      = $sub_array;
      $no++;
    }
    $output = array(
      "draw"            => intval($_POST["draw"]),
      "recordsFiltered" => $this->_makeQuery(true),
      "data"            => $data
    );
    echo json_encode($output);
  }

  function _makeQuery($recordsFiltered = false)
  {
    $start  = $this->input->post('start');
    $length = $this->input->post('length');
    $limit  = "LIMIT $start, $length";
    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST['order'] : '',
      'search' => $this->input->post('search')['value'],
      'order_column' => 'view',
      'group_by' => 'id_generated',
      'deleted' => false
    ];
    if ($recordsFiltered == true) {
      return $this->lbr_m->getHariLibur($filter)->num_rows();
      return 1;
    } else {
      return $this->lbr_m->getHariLibur($filter)->result();
    }
  }

  public function insert()
  {
    $data['title'] = $this->title;
    $data['file']  = 'hari_libur_form';
    $data['mode']  = 'insert';
    if (isset($_GET['isCalendar'])) {
      $data['isCalendar'] = true;
    }
    $this->template_portal($data);
  }

  public function saveData()
  {
    $user         = user();
    $post         = $this->input->post();
    $dates        = loop_dates($post['tgl_mulai_libur'], $post['tgl_selesai_libur']);
    $id_generated =  $this->dm->getIdGenerated('ms_hari_libur', 'id_generated');

    if ($dates) {
      foreach ($dates as $dt) {
        $inserts[] = [
          'id_generated'     => $id_generated,
          'tgl_libur'        => $dt,
          'keterangan_libur' => $post['keterangan_libur'],
          'created_at'       => waktu(),
          'created_by'       => $user->id_user,
        ];
      }
    } else {
      $inserts[] = [
        'id_generated'     => $id_generated,
        'tgl_libur'        => $post['tgl_mulai_libur'],
        'keterangan_libur' => $post['keterangan_libur'],
        'created_at'       => waktu(),
        'created_by'       => $user->id_user,
      ];
    }

    // $tes = ['inserts' => $inserts];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->insert_batch('ms_hari_libur', $inserts);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $isCalendar = $this->input->post('isCalendar') == null ? '' : '?isCalendar';

      $response = [
        'status' => 1,
        'url' => site_url(get_slug()) . $isCalendar
      ];
      $this->session->set_flashdata(msg_sukses_simpan());
    }
    send_json($response);
  }

  public function edit()
  {
    $data['title'] = 'Edit ' . $this->title;
    $data['file']  = 'hari_libur_form';
    $data['mode']  = 'edit';
    $params = get_params($this->input->get(), true);
    $filter['id_generated']  = $params['id_generated'];
    $filter['group_by']  = 'id_generated';
    $row = $this->lbr_m->getHariLibur($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  public function saveEdit()
  {
    $user         = user();
    $post         = $this->input->post();
    $dates        = loop_dates($post['tgl_mulai_libur'], $post['tgl_selesai_libur']);
    $id_generated = $this->input->post('id_generated');

    foreach ($dates as $dt) {
      $inserts[] = [
        'id_generated'     => $id_generated,
        'tgl_libur'        => $dt,
        'keterangan_libur' => $post['keterangan_libur'],
        'updated_at'       => waktu(),
        'updated_by'       => $user->id_user,
      ];
    }

    $tes = ['inserts' => $inserts];
    // send_json($tes);
    $this->db->trans_begin();
    $this->db->delete('ms_hari_libur', ['id_generated' => $id_generated]);
    $this->db->insert_batch('ms_hari_libur', $inserts);
    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = ['status' => 0, 'pesan' => 'Telah terjadi kesalahan !'];
    } else {
      $this->db->trans_commit();
      $isCalendar = $this->input->post('isCalendar') == null ? '' : '?isCalendar';
      $response = [
        'status' => 1,
        'url' => site_url(get_slug()) . $isCalendar
      ];
      $this->session->set_flashdata(msg_sukses_simpan());
    }
    send_json($response);
  }

  public function detail()
  {
    $data['title'] = 'Detail ' . $this->title;
    $data['file']  = 'hari_libur_form';
    $data['mode']  = 'detail';
    $params = get_params($this->input->get(), true);
    $filter['id_merk_mobil']  = $params['id'];
    $row = $this->lbr_m->getHariLibur($filter)->row();
    if ($row != NULL) {
      $data['row'] = $row;
      $this->template_portal($data);
    } else {
      $this->session->set_flashdata(msg_not_found());
      redirect(get_slug());
    }
  }

  function getListForCalendar()
  {
    $filter = [
      'group_by' => 'id_generated',
      'select' => 'for_calendar'
    ];
    $libur = $this->lbr_m->getHariLibur($filter)->result_array();
    $response = ['status' => 1, 'data' => $libur];
    send_json($response);
  }
}
