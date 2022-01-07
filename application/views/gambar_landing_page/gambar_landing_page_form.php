<?php
$disabled = '';
$form = '';
if ($mode == 'detail') {
  $disabled = 'disabled';
} elseif ($mode == 'edit') {
  $form = 'saveEdit';
} elseif ($mode == 'insert') {
  $form = 'saveData';
} ?>
  <script src="<?= base_url() ?>assets/plugins/vue/vue.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/vue/accounting.js"></script>
  <script src="<?= base_url() ?>assets/plugins/vue/vue-numeric.min.js"></script>
  <script>
    Vue.use(VueNumeric.default);
    Vue.filter('toCurrency', function(value) {
      return accounting.formatMoney(value, "", 0, ".", ",");
      return value;
    });
  </script>
<div class="page-wrapper">
  <div class="page-content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header border-bottom bg-transparent">
            <div class="d-flex align-items-center">
              <div>
                <h6 class="mb-2 mt-2"><?= $title ?></h6>
              </div>
              <div class="ms-auto">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header border-bottom bg-transparent">
        <div class="d-flex align-items-center">

        </div>
      </div>
      <div class="card-body">
        <form id="form_">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Upload Gambar</label>
              <div class="form-input">
                <input type="file" class="form-control" name="gambar">
              </div>
            </div>
          </div>
        </form>
        <hr>
        <div class="col-12 center">
          <button type="button" class="btn btn-primary px-4" id="submitButton">Simpan Data</button>
        </div>
      </div>
    </div>
    <div id="form_vue">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
        <div class="col" v-for="(gb, index) of gambars">
          <div class="card">
            <img v-bind:src="gb.path_img_small" class="card-img-top" alt="...">
            <div class="card-body">
              <!-- <h6 class="card-title cursor-pointer">Nest Shaped Chair</h6> -->
              <div class="clearfix center mb-2">
                  <div v-for="(gbf, index) of gb.for"><input type="checkbox" v-model="gbf.checked" true-value='1' false-value='0'> {{gbf.value}}</div>
              </div>
              <div class="clearfix center">
                <button class="btn btn-primary btn-sm" @click.prevent="aturGambar(gb)">Atur Gambar</button>
                <button class="btn btn-danger btn-sm" @click.prevent="hapusGambar(gb)">Hapus Gambar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#submitButton').click(function() {
    // Swal.fire('Any fool can use a computer')
    $('#form_').validate({
      highlight: function(element, errorClass, validClass) {
        var elem = $(element);
        if (elem.hasClass("select2-hidden-accessible")) {
          $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass);
        } else {
          $(element).parents('.form-input').addClass('has-error');
        }
      },
      unhighlight: function(element, errorClass, validClass) {
        var elem = $(element);
        if (elem.hasClass("select2-hidden-accessible")) {
          $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
        } else {
          $(element).parents('.form-input').removeClass('has-error');
        }
      },
      errorPlacement: function(error, element) {
        var elem = $(element);
        if (elem.hasClass("select2-hidden-accessible")) {
          element = $("#select2-" + elem.attr("id") + "-container").parent();
          error.insertAfter(element);
        } else {
          error.insertAfter(element);
        }
      }
    })
    var values = new FormData($('#form_')[0]);
    if ($('#form_').valid()) // check if form is valid
    {
      Swal.fire({
        text: 'Apakah Anda Yakin ?',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            beforeSend: function() {
              $('#submitButton').html('<i class="fa fa-spinner fa-spin"></i> Process');
              $('#submitButton').attr('disabled', true);
            },
            enctype: 'multipart/form-data',
            url: '<?= site_url(get_controller() . '/upload_gambar') ?>',
            type: "POST",
            data: values,
            processData: false,
            contentType: false,
            // cache: false,
            dataType: 'JSON',
            success: function(response) {
              if (response.status == 1) {
                window.location = response.url;
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
    } else {
      round_error_noti('Silahkan tentukan field yang wajib diisi')
    }
  })

  var form_ = new Vue({
    el: '#form_vue',
    data: {
      gambars: <?= json_encode($gambars) ?>
    },
    methods: {
      aturGambar: function(params) {
        $.ajax({
          beforeSend: function() {
            $('#submitButton').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#submitButton').attr('disabled', true);
          },
          enctype: 'multipart/form-data',
          url: '<?= site_url(get_controller() . '/atur_gambar') ?>',
          type: "POST",
          data: params,
          // processData: false,
          // contentType: false,
          // cache: false,
          dataType: 'JSON',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
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
      },
      hapusGambar: function(params) {
        $.ajax({
          beforeSend: function() {
            $('#submitButton').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#submitButton').attr('disabled', true);
          },
          enctype: 'multipart/form-data',
          url: '<?= site_url(get_controller() . '/hapus_gambar') ?>',
          type: "POST",
          data: params,
          // processData: false,
          // contentType: false,
          // cache: false,
          dataType: 'JSON',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
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
      },
    }
  })
</script>