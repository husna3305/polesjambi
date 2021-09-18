<?php
$disabled = '';
if ($pelunasan != null) {
  $disabled = 'disabled';
} ?>
<div class="row">
  <div class="col-auto text-center flex-column d-none d-sm-flex">
    <div class="row h-50">
      <div class="col border-end">&nbsp;</div>
      <div class="col">&nbsp;</div>
    </div>
    <h5 class="m-2">
      <span class="badge rounded-pill <?= ($row->status == 'selesai' || $row->status == 'menunggu_pelunasan') == true ? 'bg-primary' : 'bg-light border' ?>">&nbsp;</span>
    </h5>
  </div>
  <div class="col py-2">
    <div class="card border-primary shadow radius-15">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-sm-8">
            <h6>Pelunasan </h6>
          </div>
          <div class="col-sm-4" align='right'>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-12">
            <div class="card" style="background-color:#f4f4f4">
              <div class="card-body">
                <ul class="list-group list-group-flush radius-10">
                  <h6>Services</h6>
                  <?php $tot_services = 0;
                  foreach ($services_pelunasan as $key => $srv) {
                    $tot_services += $srv->biaya; ?>
                    <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-2">
                          <h7 class="mb-0"><?= $srv->judul ?></h7>
                        </div>
                      </div>
                      <div class="ms-auto"><?= mata_uang_rp($srv->biaya) ?></div>
                    </li>
                  <?php } ?>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Total Services</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><b><?= mata_uang_rp($tot_services) ?></b></div>
                  </li>
                  <hr>
                  <h6>Potongan</h6>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h7 class="mb-0">Total DP</h7>
                      </div>
                    </div>
                    <div class="ms-auto"><?= mata_uang_rp($row->grand_tot_dp) ?></div>
                  </li>
                  <hr>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Grand Total</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><b><?= mata_uang_rp($row->grand_total) ?></b></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card" style="background-color:#f4f4f4">
              <div class="card-header">
                <button type="button" class="btn btn-success btn-sm2 mb-1 mt-1" data-bs-target="#content_upload_pembayaran" data-bs-toggle="collapse">Pelunasan</button>
              </div>
              <div class="collapse" id="content_upload_pembayaran">
                <div class="card-body">
                  <form style='min-height:250px' id="form_pelunasan">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran *</label>
                        <div class="form-input">
                          <select class="form-control" name="metode_pembayaran" required <?= $disabled ?>>
                            <option disabled selected>Pilih</option>
                            <option value="cash" <?= $pelunasan != null ? 'selected' : '' ?>>Cash</option>
                            <option value="transfer_bank" <?= $pelunasan != null ? 'selected' : '' ?>>Transfer Bank</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Bank *</label>
                        <div class="form-input">
                          <select class="form-control" name="nama_bank" <?= $disabled ?>>
                            <option disabled selected>Pilih</option>
                            <option value="bri" <?= $pelunasan != null ? $pelunasan->nama_bank == 'bri' ? 'selected' : '' : '' ?>>BRI</option>
                            <option value="bca" <?= $pelunasan != null ? $pelunasan->nama_bank == 'bca' ? 'selected' : '' : '' ?>>BCA</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Waktu Pembayaran *</label>
                        <div class="form-input">
                          <input type="text" class="form-control datetimepicker" name="waktu_pembayaran" value="<?= $pelunasan == null ? '' : $pelunasan->waktu_pembayaran ?>" required <?= $disabled ?>>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Nominal Pembayaran</label>
                        <div class="form-input">
                          <input type="number" class="form-control" name="nominal_pembayaran" value="<?= $row->grand_total ?>" required <?= $disabled ?>>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <?php if ($row->status == 'menunggu_pelunasan') { ?>
                  <div class="card-footer">
                    <div class="col-12 center">
                      <button type="button" class="btn btn-primary px-4" id="submitPelunasan">Simpan Pelunasan</button>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#submitPelunasan').click(function() {
    $('#form_pelunasan').validate({
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
    var values = new FormData($('#form_pelunasan')[0]);
    <?php if (isset($row)) { ?>
      values.append('id_booking', <?= $row->id_booking ?>);
    <?php } ?>
    if ($('#form_pelunasan').valid()) // check if form is valid
    {
      Swal.fire({
        text: 'Apakah Anda Yakin Menyimpan Transaksi Pelunasan ?',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            beforeSend: function() {
              $('#submitPelunasan').html('<i class="fa fa-spinner fa-spin"></i> Process');
              $('#submitPelunasan').attr('disabled', true);
            },
            enctype: 'multipart/form-data',
            url: '<?= site_url(get_controller() . '/simpanPelunasan') ?>',
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
                $('#submitPelunasan').attr('disabled', false);
              }
              $('#submitPelunasan').html('Simpan Pelunasan');
            },
            error: function() {
              round_error_noti('Telah terjadi kesalahan !');
              $('#submitPelunasan').html('Simpan Pelunasan');
              $('#submitPelunasan').attr('disabled', false);
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