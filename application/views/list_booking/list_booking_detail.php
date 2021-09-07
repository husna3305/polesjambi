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
    <div class="card" style="background-color:#fff0">
      <div class="card-header border-bottom bg-transparent">
        <div class="d-flex align-items-center">
          <a type="button" class="btn btn-outline-primary px-3 btn-sm2" href="<?= site_url(get_slug()) ?>"><i class="bx bx-chevron-left-circle mr-1"></i>Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <div class="container py-2">
          <div class="row">
            <!-- timeline item 1 left dot -->
            <div class="col-auto text-center flex-column d-none d-sm-flex">
              <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
              <h5 class="m-2">
                <span class="badge rounded-pill bg-light border">&nbsp;</span>
              </h5>
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
            </div>
            <!-- timeline item 1 event content -->
            <div class="col py-2">
              <div class="card radius-15">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>User A melakukan booking 4 services untuk mobil Toyota Avanza</h6>
                      <p style="font-weight:500">Minggu, 29 Agustus 2021 09:00</p>
                    </div>
                  </div>
                  <p class="card-text">Booking untuk tanggal : 01 September 2021, 08:00</p>
                  <div class="card" style="background-color:#f4f4f4">
                    <div class="card-body">
                      <button class="btn btn-sm btn-outline-secondary mb-2" type="button" data-bs-target="#t2_details" data-bs-toggle="collapse">Detail Services <i class="bx bx-caret-down"></i></button>
                      <div class="collapse" id="t2_details">
                        <ul class="list-group list-group-flush radius-10">
                          <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Services 1</h6>
                              </div>
                            </div>
                            <div class="ms-auto">Rp. 200.000</div>
                          </li>
                          <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Services 2</h6>
                              </div>
                            </div>
                            <div class="ms-auto">Rp. 300.000</div>
                          </li>
                          <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Services 3</h6>
                              </div>
                            </div>
                            <div class="ms-auto">Rp. 100.000</div>
                          </li>
                          <hr>
                          <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Total</h6>
                              </div>
                            </div>
                            <div class="ms-auto"><b>Rp. 600.000</b></div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/row-->
          <!-- timeline item 2 -->
          <div class="row">
            <div class="col-auto text-center flex-column d-none d-sm-flex">
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
              <h5 class="m-2">
                <span class="badge rounded-pill <?= $id == 1 ? 'bg-primary' : 'bg-light border' ?>">&nbsp;</span>
              </h5>
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
            </div>
            <div class="col py-2">
              <div class="card border-primary shadow radius-15">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Pembayaran DP Booking </h6>
                      <?php if ($id == 1) { ?>
                        <button type="button" class="btn btn-primary px-2 radius-30 btn-sm">Menunggu Pembayaran</button>
                      <?php } else { ?>
                        <button type="button" class="btn btn-success px-2 radius-30 btn-sm mb-2">Lunas</button>
                        <br>
                        <button type="button" class="btn btn-primary px-5 btn-sm2" onclick="showModalPreviewImages()">Bukti Transfer</button>
                      <?php } ?>
                      <br><br>
                      <ul class="list-group list-group-flush radius-10">
                        <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">Total DP</h6>
                            </div>
                          </div>
                          <div class="ms-auto">Rp. 300.000</div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/row-->
          <!-- timeline item 3 -->
          <div class="row">
            <div class="col-auto text-center flex-column d-none d-sm-flex">
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
              <h5 class="m-2">
                <?php
                $bg = 'bg-light border';
                if ($id == 2 || $id == 3) {
                  $bg = 'bg-primary';
                } ?>
                <span class="badge rounded-pill <?= $bg ?>">&nbsp;</span>
              </h5>
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
            </div>
            <div class="col py-2">
              <div class="card radius-15">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Action Booking</h6>
                      <?php if ($id == 2) { ?>
                        <button type="button" class="btn btn-info color-white px-2 radius-30 btn-sm">Menunggu Kedatangan</button>
                        <br>
                        <br>
                        <div class="card">
                          <div class="card-header">
                            Detailers
                          </div>
                          <div class="card-body">
                            <div class="row center">
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 1</h5>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 2</h5>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 3</h5>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 4</h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row center">
                          <div class="col">
                            <button type="button" class="btn btn-outline-primary px-5 radius-30">Start</button>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if ($id == 3) { ?>
                        <button type="button" class="btn btn-info color-white px-2 radius-30 btn-sm">Sedang Dikerjakan</button>
                        <br>
                        <br>
                        <div class="card">
                          <div class="card-header">
                            Detailers
                          </div>
                          <div class="card-body">
                            <div class="row center">
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 1</h5>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="card shadow-none border radius-15">
                                  <div class="card-body">
                                    <img src="<?= base_url() ?>assets/images/avatars/avatar.png" alt="user avatar" style="height:100px !important;border-radius:50%;border: 0 solid #e5e5e5;padding: 0;">
                                    <h5 class="mt-3 mb-0">Detailer 2</h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row center">
                          <div class="col">
                            <button type="button" class="btn btn-primary px-5 radius-30" disabled>Start</button>
                          </div>
                          <div class="col">
                            <button type="button" class="btn btn-outline-warning px-5 radius-30">Pause</button>
                          </div>
                          <div class="col">
                            <button type="button" class="btn btn-outline-success px-5 radius-30">Done</button>
                          </div>
                        </div>
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/row-->
          <!-- timeline item 4 -->
          <div class="row">
            <div class="col-auto text-center flex-column d-none d-sm-flex">
              <div class="row h-50">
                <div class="col border-end">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
              <h5 class="m-2">
                <span class="badge rounded-pill bg-light border">&nbsp;</span>
              </h5>
              <div class="row h-50">
                <div class="col">&nbsp;</div>
                <div class="col">&nbsp;</div>
              </div>
            </div>
            <div class="col py-2">
              <div class="card radius-15">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Selesai</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/row-->
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('additionals/modal_preview_images'); ?>
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
      values.append('id_merk_mobil', <?= $row->id_merk_mobil ?>);
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