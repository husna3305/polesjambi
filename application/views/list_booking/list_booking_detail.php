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
<style>
  .detailers-dipilih {
    background-color: #d1e2fd !important;
    margin-top: -.25rem;
    margin-bottom: .25rem;
    -webkit-box-shadow: 0 .5rem 1rem 0 rgba(0, 0, 0, .2);
    box-shadow: 0 .25rem .5rem 0 rgba(0, 0, 0, .2)
  }
</style>
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
                      <h6><?= $row->nama_lengkap ?> melakukan booking <?= $row->tot_servis ?> services untuk mobil <?= $row->merk_mobil ?> <?= $row->jenis_mobil ?></h6>
                      <p style="font-weight:500"><?= $row->created_at ?></p>
                    </div>
                  </div>
                  <p class="card-text">Booking untuk tanggal : <?= $row->tanggal_booking . ' ' . $row->jam_booking ?></p>
                  <div class="card" style="background-color:#f4f4f4">
                    <div class="card-body">
                      <!-- <button class="btn btn-sm btn-outline-secondary mb-2" type="button" data-bs-target="#t2_details" data-bs-toggle="collapse">Detail Services <i class="bx bx-caret-down"></i></button> -->
                      <div class="collapse show" id="t2_details">
                        <ul class="list-group list-group-flush radius-10">
                          <?php $total = 0;
                          foreach ($services_booking as $key => $srv) {
                            $total += $srv->biaya; ?>
                            <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1 ms-2">
                                  <h6 class="mb-0"><?= $srv->judul ?></h6>
                                </div>
                              </div>
                              <div class="ms-auto"><?= mata_uang_rp($srv->biaya) ?></div>
                            </li>
                          <?php } ?>
                          <hr>
                          <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                            <div class="d-flex align-items-center">
                              <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">Total</h6>
                              </div>
                            </div>
                            <div class="ms-auto"><b><?= mata_uang_rp($total) ?></b></div>
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
          <?php
          $data = ['row' => $row, 'bayar_dp' => $bayar_dp];
          $this->load->view('list_booking/list_booking_pembayaran_dp', $data); ?>

          <?php
          $data = ['row' => $row];
          if ($row->status == 'dp_lunas' || $row->status == 'menunggu_kedatangan' || $row->status == 'sedang_dikerjakan' || $row->status == 'selesai' || $row->status == 'menunggu_pelunasan') {
            $this->load->view('list_booking/list_booking_pengerjaan', $data);
          } ?>

          <?php
          $data = [
            'row' => $row,
            'pelunasan' => $pelunasan,
            'services_pelunasan' => $services_pelunasan,
            'biaya_tambahan' => $biaya_tambahan
          ];
          if ($row->status == 'selesai' || $row->status == 'menunggu_pelunasan') {
            $this->load->view('list_booking/list_booking_pelunasan', $data);
          } ?>
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