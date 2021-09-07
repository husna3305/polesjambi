<!doctype html>
<html lang="en" class="<?= theme_style() ?> <?= sidebar_background() ?> <?= headercolor() ?>">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="<?= base_url() ?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- loader-->
  <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />
  <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/app.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet">
  <!-- Theme Style CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/dark-theme.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/semi-dark.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/header-colors.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/notifications/css/lobibox.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2-bootstrap4.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datetimepicker/css/classic.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datetimepicker/css/classic.time.css">
  <style>
    .btn-sm {
      padding: 2px 5px;
    }

    .btn-sm2 {
      padding: 3px 6px;
    }

    .center {
      text-align: center
    }

    .right {
      text-align: right
    }

    .pr-5 {
      padding-right: 15px;
    }

    .list-group-item:hover {
      background-color: #f1f1f1;
    }

    .right {
      text-align: right;
    }

    .color-white {
      color: #fff
    }

    .color-white:hover {
      color: #fff;
      background-color: #0fb1d2;
    }

    .color-red {
      color: #d22323;
    }

    .color-red:hover {
      color: #fff;
      background-color: #ec7474;
    }
  </style>
  <title><?= title() ?></title>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/notifications/js/notification-custom-script.js"></script>
  <script src="<?= base_url() ?>assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/select2/js/select2.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/2aumo75wknuygy36uj3kktirip8p4b3gtb8bdp3tscos8xc5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="<?= base_url() ?>assets/plugins/moment/moment.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.time.js"></script>

  <script>
    var list_link = JSON.parse('<?= json_link() ?>');
    $('.timepicsker').pickatime({
      // Escape any “rule” characters with an exclamation mark (!).
      format: 'T!ime selected: h:i a',
      formatLabel: '<b>h</b>:i <!i>a</!i>',
      formatSubmit: 'HH:i',
      hiddenPrefix: 'prefix__',
      hiddenSuffix: '__suffix'
    })
  </script>
</head>

<body>
  <!--wrapper-->
  <div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
        <div>
          <img src="<?= base_url() ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
          <h4 class="logo-text">Poles Jambi</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-menu'></i>
        </div>
      </div>
      <!--navigation-->
      <?php
      $html = "";
      function build_menu($data, $menus)
      {
        $html = '';
        //Cek Apakah Parent Menu Atau Separated Menu
        $url = $data['slug'] == NULL ? 'javascript:;' : site_url($data['slug']);
        if ($data['controller'] == NULL) {
          //Cek Apakah Separated Menu
          if ($data['tot_child'] == 0) {
            $html .= "<li class='header'>{$data['nama_menu']}</li>";
          } else {
            $html .= "<li>
          <a href='$url' class='has-arrow'>
            <div class='parent-icon'><i class='{$data['fa_icon_menu']}'></i></div>
            <div class='menu-title'>{$data['nama_menu']}</div>
          </a>
          <ul>
          ";
            $level = $data['level'] + 1;
            $child = search_array($menus, ['level' => $level, 'parent_id_menu' => $data['id_menu']]);
            if (count($child) > 0) {
              foreach ($child as $chld) {
                $html .= build_menu($chld, $menus);
              }
            }
            $html .= "</ul></li>";
          }
        } else {
          $icon = $data['fa_icon_menu'] == '' ? '- ' : $data['fa_icon_menu'];
          $html .= "<li><a href='$url'>
                        <div class='parent-icon'><i class='$icon'></i></div> 
                        <div class='menu-title'>{$data['nama_menu']}</div>
                        </a></li>";
        }
        return $html;
      } ?>
      <ul class="metismenu" id="menu">
        <?php
        $lvl1 = search_array($menus, ['level' => 1]);
        foreach ($lvl1 as $l1) {
          if ($l1['id_menu'] != 999) {
            echo build_menu($l1, $menus);
          }
        }
        ?>
        <!-- <li class="menu-label">Others</li> -->
      </ul>
      <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
    <!--start header -->
    <header>
      <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
          <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
          </div>
          <div class="top-menu ms-auto">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" aria-expanded="false">&nbsp;</a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="javascript:;">
                    <div class="msg-header">
                      <p class="msg-header-title">Notifications</p>
                      <p class="msg-header-clear ms-auto">Marks all as read</p>
                    </div>
                  </a>
                  <div class="header-notifications-list">
                    <a class="dropdown-item" href="javascript:;">
                      <div class="d-flex align-items-center">
                        <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
                              ago</span></h6>
                          <p class="msg-info">5 new user registered</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  <a href="javascript:;">
                    <div class="text-center msg-footer">View All Notifications</div>
                  </a>
                </div>
              </li>
              <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">1</span>
                  <i class='bx bx-bell'></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="javascript:;">
                    <div class="msg-header">
                      <p class="msg-header-title">Notifikasi</p>
                      <p class="msg-header-clear ms-auto" style="color:#4f8eea">Tandai Semua Sudah Dibaca</p>
                    </div>
                  </a>
                  <div class="header-message-list">
                    <a class="dropdown-item" href="javascript:;">
                      <div class="d-flex align-items-center">
                        <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
                              ago</span></h6>
                          <p class="msg-info">5 new user registered</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  <a href="javascript:;">
                    <div class="text-center msg-footer" style="color:#4f8eea">Lihat Semua Notifikasi</div>
                  </a>
                </div>
              </li>
            </ul>
          </div>
          <div class="user-box dropdown">
            <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= base_url() ?>assets/images/avatars/avatar.png" class="user-img" alt="user avatar">
              <div class="user-info ps-3">
                <p class="user-name mb-0"><?= $user->nama_lengkap ?></p>
                <p class="designattion mb-0"><?= $user->username ?></p>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
              </li>
              <li>
                <div class="dropdown-divider mb-0"></div>
              </li>
              <li><a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!--end header -->