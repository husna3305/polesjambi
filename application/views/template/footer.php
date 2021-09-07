<!--end page wrapper -->
<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
  <p class="mb-0">Copyright © 2021. All right reserved.</p>
</footer>
</div>
<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
  <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
  </div>
  <div class="switcher-body">
    <div class="d-flex align-items-center">
      <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
      <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
    </div>
    <hr />
    <h6 class="mb-0">Theme Styles</h6>
    <hr />
    <div class="d-flex align-items-center justify-content-between">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" <?= $theme_style == 'light-theme' ? 'checked' : '' ?>>
        <label class="form-check-label" for="lightmode">Light</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode" <?= $theme_style == 'dark-theme' ? 'checked' : '' ?>>
        <label class="form-check-label" for="darkmode">Dark</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" <?= $theme_style == 'semi-dark' ? 'checked' : '' ?>>
        <label class="form-check-label" for="semidark">Semi Dark</label>
      </div>
    </div>
    <hr />
    <div class="form-check">
      <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault" <?= $theme_style == 'minimal-theme' ? 'checked' : '' ?>>
      <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
    </div>
    <hr />
    <h6 class="mb-0">Header Colors</h6>
    <hr />
    <div class="header-colors-indigators">
      <div class="row row-cols-auto g-3">
        <div class="col">
          <div class="indigator headercolor1" id="headercolor1"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor2" id="headercolor2"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor3" id="headercolor3"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor4" id="headercolor4"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor5" id="headercolor5"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor6" id="headercolor6"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor7" id="headercolor7"></div>
        </div>
        <div class="col">
          <div class="indigator headercolor8" id="headercolor8"></div>
        </div>
      </div>
    </div>

    <hr />
    <h6 class="mb-0">Sidebar Backgrounds</h6>
    <hr />
    <div class="header-colors-indigators">
      <div class="row row-cols-auto g-3">
        <div class="col">
          <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
        </div>
        <div class="col">
          <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
        </div>
      </div>
    </div>

  </div>
</div>
<!--end switcher-->
<!--plugins-->

<script>
  $(document).ready(function() {
    let flash = <?= json_encode($this->session->flashdata()) ?>;
    if (flash.status != undefined) {
      if (flash.status == 'error') {
        round_error_noti(flash.text);
      } else if (flash.status == 'success') {
        round_success_noti(flash.text);
      }
    }
  });
</script>
<!--app JS-->
<script src="<?= base_url() ?>assets/js/app.js"></script>
<script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/jquery-validation/jquery.validate.js"></script>
<script>
  $('.datepicker').daterangepicker({
    //  timePicker: false,
    singleDatePicker: true,
    isInvalidDate: false,
    autoUpdateInput: false,
    showDropdowns: true,
    locale: {
      cancelLabel: 'Clear',
      format: 'YYYY-MM-DD',
    },
  })
  $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
  });
  $('.datepicker').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });

  $(function() {
    $('.set-daterangepicker').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
</script>
<script>
  $("#lightmode").on("click", function() {
      set_theme('light-theme', 'theme_style')
    }), $("#darkmode").on("click", function() {
      set_theme('dark-theme', 'theme_style')
    }), $("#semidark").on("click", function() {
      set_theme('semi-dark', 'theme_style')
    }), $("#minimaltheme").on("click", function() {
      set_theme('minimal-theme', 'theme_style')
    }),
    <?php for ($i = 1; $i <= 8; $i++) { ?>
  $("#sidebarcolor<?= $i ?>").on("click", function() {
    set_theme('sidebarcolor<?= $i ?>', 'sidebar_background')
  })

  $("#headercolor<?= $i ?>").on("click", function() {
    set_theme('headercolor<?= $i ?>', 'header_colors')
  })
  <?php } ?>

  function set_theme(thm, fl) {
    values = {
      theme: thm,
      field: fl,
    }
    $.ajax({
      beforeSend: function() {},
      enctype: 'multipart/form-data',
      url: '<?= site_url('api/private/theme/setTheme') ?>',
      type: "POST",
      data: values,
      // processData: false,
      // contentType: false,
      // cache: false,
      dataType: 'JSON',
      success: function(response) {
        location.reload();
      },
      error: function() {
        round_error_noti('Telah terjadi kesalahan !');
      }
    });
  }

  function deleteData(el, params) {
    Swal.fire({
      text: 'Apakah Anda Yakin Ingin Menghapus Data Ini ?',
      showCancelButton: true,
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          beforeSend: function() {},
          url: params.url,
          type: "POST",
          dataType: 'JSON',
          success: function(response) {
            if (response.status == 1) {
              location.reload();
            } else {
              round_error_noti(response.pesan);
              $('#submitButton').attr('disabled', false);
            }
            $('#submitButton').html('Simpan Data');
          },
          error: function() {
            round_error_noti('Telah terjadi kesalahan !');
            $('#submitButton').html('Simpan Data');
            $('#submitButton').attr('disabled', false);
          }
        });
      } else if (result.isDenied) {
        // Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }
</script>
</body>

</html>