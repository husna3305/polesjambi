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
          <a type="button" class="btn btn-outline-primary px-3 btn-sm2" href="<?= site_url(get_slug()) ?>"><i class="bx bx-chevron-left-circle mr-1"></i>Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form style='min-height:250px' id="form_">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Tgl. Libur</label>
              <div class="form-input">
                <input type="text" class="form-control" name="tgl_libur" id="tgl_libur" required <?= $disabled ?> value="<?= isset($row) ? $row->tgl_mulai . ' s/d ' . $row->tgl_selesai : '' ?>">
                <input type="hidden" class="form-control" name="tgl_mulai_libur" id="tgl_mulai_libur" required <?= $disabled ?> value="<?= isset($row) ? $row->tgl_mulai : '' ?>">
                <input type="hidden" class="form-control" name="tgl_selesai_libur" id="tgl_selesai_libur" required <?= $disabled ?> value="<?= isset($row) ? $row->tgl_selesai : '' ?>">
              </div>
            </div>
            <script>
              $(function() {
                $('#tgl_libur').daterangepicker({
                  // opens: 'left',
                  autoUpdateInput: false,
                  locale: {
                    format: 'YYYY-MM-DD'
                  }
                }, function(start, end, label) {
                  $('#tgl_mulai_libur').val(start.format('YYYY-MM-DD'));
                  $('#tgl_selesai_libur').val(end.format('YYYY-MM-DD'));
                }).on('apply.daterangepicker', function(ev, picker) {
                  $(this).val(picker.startDate.format('YYYY-MM-DD') + ' s/d ' + picker.endDate.format('YYYY-MM-DD'));
                }).on('cancel.daterangepicker', function(ev, picker) {
                  $(this).val('');
                  $('#tgl_mulai_libur').val('');
                  $('#tgl_selesai_libur').val('');
                });
              });
            </script>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Keterangan Libur</label>
              <div class="form-input">
                <input type="text" class="form-control" name="keterangan_libur" value="<?= isset($row) ? $row->keterangan_libur : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
          </div>
        </form>
        <?php if ($mode != 'detail') { ?>
          <hr>
          <div class="col-12 center">
            <button type="button" class="btn btn-primary px-4" id="submitButton">Simpan Data</button>
          </div>
        <?php } ?>
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
    <?php if (isset($row)) { ?>
      values.append('id_generated', '<?= $row->id_generated ?>');
    <?php } ?>
    <?php if (isset($isCalendar)) { ?>
      values.append('isCalendar', 1);
    <?php } ?>
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
            url: '<?= site_url(get_controller() . '/' . $form) ?>',
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
</script>