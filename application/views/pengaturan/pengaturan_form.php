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

        </div>
      </div>
      <div class="card-body">
        <form style='min-height:250px' id="form_">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Batas Maksimal Booking Kedepan</label>
              <div class="form-input">
                <input type="number" class="form-control" name="batas_maks_booking_kedepan" value="<?= isset($row) ? $row->batas_maks_booking_kedepan : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <div class="form-input">
                <select class="form-select" name='batas_maks_booking_kedepan_per'>
                  <option value="days">Hari</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Batas Maksimal Waktu Pembayaran DP Booking</label>
              <div class="form-input">
                <input type="number" class="form-control" name="batas_maks_pembayaran_booking" value="<?= isset($row) ? $row->batas_maks_pembayaran_booking : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <div class="form-input">
                <select class="form-select" name='batas_maks_pembayaran_booking_per'>
                  <option value="hours" <?= $row->batas_maks_pembayaran_booking_per == 'hours' ? 'selected' : '' ?>>Jam</option>
                  <option value="days" <?= $row->batas_maks_pembayaran_booking_per == 'days' ? 'selected' : '' ?>>Hari</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Nominal DP Booking</label>
              <div class="form-input">
                <input type="number" class="form-control" name="nominal_dp_booking" value="<?= isset($row) ? $row->nominal_dp_booking : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <div class="form-input">
                <select class="form-select" name='nominal_dp_booking_per'>
                  <option value="persen" <?= $row->nominal_dp_booking_per == 'persen' ? 'selected' : '' ?>>Persen</option>
                  <option value="rupiah" <?= $row->nominal_dp_booking_per == 'rupiah' ? 'selected' : '' ?>>Rupiah</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Toleransi Keterlambatan</label>
              <div class="form-input">
                <input type="number" class="form-control" name="toleransi_keterlambatan_datang" value="<?= isset($row) ? $row->toleransi_keterlambatan_datang : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <div class="form-input">
                <select class="form-select" name='toleransi_keterlambatan_datang_per'>
                  <option value="minutes" <?= $row->toleransi_keterlambatan_datang_per == 'minutes' ? 'selected' : '' ?>>Menit</option>
                  <option value="hours" <?= $row->toleransi_keterlambatan_datang_per == 'hours' ? 'selected' : '' ?>>Jam</option>
                </select>
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