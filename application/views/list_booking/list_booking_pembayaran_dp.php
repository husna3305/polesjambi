<?php
$disabled = '';
if ($bayar_dp != null) {
  $disabled = 'disabled';
} ?>
<div class="row">
  <div class="col-auto text-center flex-column d-none d-sm-flex">
    <div class="row h-50">
      <div class="col border-end">&nbsp;</div>
      <div class="col">&nbsp;</div>
    </div>
    <h5 class="m-2">
      <span class="badge rounded-pill <?= ($row->status == 'menunggu_pembayaran' || $row->status == 'dp_lunas') == true ? 'bg-primary' : 'bg-light border' ?>">&nbsp;</span>
    </h5>
    <?php if (($row->status == 'menunggu_pembayaran' || $row->status == 'dp_lunas') == false) { ?>
      <div class="row h-50">
        <div class="col border-end">&nbsp;</div>
        <div class="col">&nbsp;</div>
      </div>
    <?php } ?>
  </div>
  <div class="col py-2">
    <div class="card border-primary shadow radius-15">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-sm-8">
            <h6>Pembayaran DP Booking </h6>
          </div>
          <div class="col-sm-4" align='right'>
            <?php if ($row->status == 'menunggu_pembayaran') {
              $text_btn = "<i class='fa fa-upload'></i> Upload Bukti Pembayaran"; ?>
              <button type="button" class="btn btn-primary px-2 radius-30 btn-sm">Menunggu Pembayaran</button>
            <?php } else {
              $text_btn = "Bukti Pembayaran"; ?>
              <button type="button" class="btn btn-success px-2 radius-30 btn-sm">Lunas</button>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-12">
            <div class="card" style="background-color:#f4f4f4">
              <div class="card-header">
                <button type="button" class="btn btn-success btn-sm2 mb-1 mt-1" data-bs-target="#content_upload_pembayaran" data-bs-toggle="collapse"><?= $text_btn ?></button>
              </div>
              <div class="collapse" id="content_upload_pembayaran">
                <div class="card-body">
                  <form style='min-height:250px' id="form_bukti_pembayaran">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran *</label>
                        <div class="form-input">
                          <select class="form-control" name="metode_pembayaran" required <?= $disabled ?>>
                            <option disabled selected>Pilih</option>
                            <option value="transfer_bank" <?= $bayar_dp != null ? 'selected' : '' ?>>Transfer Bank</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Bank *</label>
                        <div class="form-input">
                          <select class="form-control" name="nama_bank" required <?= $disabled ?>>
                            <option disabled selected>Pilih</option>
                            <option value="bri" <?= $bayar_dp != null ? $bayar_dp->nama_bank == 'bri' ? 'selected' : '' : '' ?>>BRI</option>
                            <option value="bca" <?= $bayar_dp != null ? $bayar_dp->nama_bank == 'bca' ? 'selected' : '' : '' ?>>BCA</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Waktu Pembayaran *</label>
                        <div class="form-input">
                          <input type="text" class="form-control datetimepicker" name="waktu_pembayaran" value="<?= $bayar_dp == null ? '' : $bayar_dp->waktu_pembayaran ?>" required <?= $disabled ?>>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Nominal Pembayaran</label>
                        <div class="form-input">
                          <input type="number" class="form-control" name="nominal_pembayaran" value="<?= $bayar_dp == null ? $row->grand_tot_dp : $bayar_dp->nominal_pembayaran ?>" required <?= $disabled ?>>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <label class="form-label">Bukti Pembayaran</label>
                        <div class="form-input">
                          <div class="input-group mb-3">
                            <input type="file" class="form-control" name="bukti_pembayaran" required <?= $disabled ?>>
                            <label class="input-group-text btn-info text-white" onclick="showModalPreviewImages('<?= base_url($bayar_dp == null ? '' : $bayar_dp->bukti_pembayaran) ?>','Bukti Pembayaran')"><i class='fa fa-eye'></i></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if ($row->status == 'menunggu_pembayaran') { ?>
                      <div class="card-footer">
                        <div class="col-12 center">
                          <button type="button" class="btn btn-primary px-4" id="submitButtonPembayaranDP">Simpan Data</button>
                        </div>
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card" style="background-color:#f4f4f4">
              <div class="card-body">
                <ul class="list-group list-group-flush radius-10">
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h7 class="mb-0">Total DP</h7>
                      </div>
                    </div>
                    <div class="ms-auto"><?= mata_uang_rp($row->total_dp) ?></div>
                  </li>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h7 class="mb-0">Nominal Unik</h7>
                      </div>
                    </div>
                    <div class="ms-auto"><?= mata_uang_rp($row->nominal_unik) ?></div>
                  </li>
                  <hr>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Total DP</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><?= mata_uang_rp($row->grand_tot_dp) ?></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#submitButtonPembayaranDP').click(function() {
    $('#form_bukti_pembayaran').validate({
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
    var values = new FormData($('#form_bukti_pembayaran')[0]);
    <?php if (isset($row)) { ?>
      values.append('id_booking', <?= $row->id_booking ?>);
    <?php } ?>
    if ($('#form_bukti_pembayaran').valid()) // check if form is valid
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
              $('#submitButtonPembayaranDP').html('<i class="fa fa-spinner fa-spin"></i> Process');
              $('#submitButtonPembayaranDP').attr('disabled', true);
            },
            enctype: 'multipart/form-data',
            url: '<?= site_url(get_controller() . '/saveBuktiPembayaranDP') ?>',
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
                $('#submitButtonPembayaranDP').attr('disabled', false);
              }
              $('#submitButtonPembayaranDP').html('Simpan Data');
            },
            error: function() {
              round_error_noti('Telah terjadi kesalahan !');
              $('#submitButtonPembayaranDP').html('Simpan Data');
              $('#submitButtonPembayaranDP').attr('disabled', false);
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