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
      <div class="card-body" id="app_pelunasan">
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
                  <li v-for="(srv, index) of services_pelunasan" class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h7 class="mb-0">{{srv.judul}}</h7>
                      </div>
                    </div>
                    <div class="ms-auto">Rp. {{srv.biaya | toCurrency}}</div>
                  </li>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Total Services</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><b>Rp. {{totalServices | toCurrency}}</b></div>
                  </li>
                  <hr>
                  <h6>Biaya Tambahan</h6>
                  <li v-for="(tbh, index) of biaya_tambahan" class="list-group-item align-items-center radius-10 mb-2 shadow-sm">
                    <div class="row">
                      <div class="col-sm-6 col-md-7">
                        <select class="form-control form-control-sm" style="width:100%" v-model="tbh.id_tambahan" <?= $disabled ?>>
                          <option value='' disabled>Pilih Keterangan</option>
                          <option v-for="option in option_biaya_tambahan" v-bind:value="option.id">
                            {{ option.text }}
                          </option>
                        </select>
                        <input v-model="tbh.keterangan_lainnya" v-if="tbh.id_tambahan==999" class="form-control form-control-sm mt-1" placeholder="Keterangan Lainnya">
                      </div>
                      <div class="col-sm-6 col-md-4">
                        <input class="form-control form-control-sm right" placeholder="Nominal" v-model="tbh.nominal" <?= $disabled ?>>
                      </div>
                      <?php if ($row->status == 'menunggu_pelunasan') { ?>
                        <div class="col-sm-1 col-md-1 right">
                          <button class="btn btn-danger btn-sm mt-1" @click.prevent="deleteBiayaTambahan(index)">&nbsp;<i class="fa fa-trash"></i></button>
                        </div>
                      <?php } ?>
                    </div>
                  </li>
                  <?php if ($row->status == 'menunggu_pelunasan') { ?>

                    <li class="list-group-item align-items-center radius-10 mb-2 shadow-sm">
                      <div class="row">
                        <div class="col-sm-6 col-md-7">
                          <select class="form-control form-control-sm" style="width:100%" v-model="tbh.id_tambahan">
                            <option value='' disabled>Pilih Keterangan</option>
                            <option v-for="option in option_biaya_tambahan" v-bind:value="option.id">
                              {{ option.text }}
                            </option>
                          </select>
                          <input v-model="tbh.keterangan_lainnya" v-if="tbh.id_tambahan==999" class="form-control form-control-sm mt-1" placeholder="Keterangan Lainnya">
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <input class="form-control form-control-sm right" placeholder="Nominal" v-model="tbh.nominal">
                        </div>
                        <div class="col-sm-1 col-md-1 right">
                          <button class="btn btn-primary btn-sm mt-1" @click.prevent="createBiayaTambahan">&nbsp;<i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </li>
                  <?php } ?>

                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Total Biaya Tambahan</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><b>Rp. {{totalBiayaTambahan | toCurrency}}</b></div>
                  </li>
                  <?php if ($row->status == 'menunggu_pelunasan') { ?>
                    <li class="list-group-item align-items-center radius-10 mb-2 shadow-sm">
                      <div class="row">
                        <div class="col-sm-12 col-md-12 center">
                          <button @click.prevent="simpanBiayaTambahan()" type="button" class="btn btn-success px-2" id="btnSimpanBiayaTambahan">Simpan Biaya Tambahan</button>
                        </div>
                      </div>
                    </li>
                  <?php } ?>
                  <hr>
                  <h6>Potongan</h6>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h7 class="mb-0">Total DP</h7>
                      </div>
                    </div>
                    <div class="ms-auto">{{totDP | toCurrency}}</div>
                  </li>
                  <hr>
                  <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                    <div class="d-flex align-items-center">
                      <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">Grand Total</h6>
                      </div>
                    </div>
                    <div class="ms-auto"><b>{{grand_total | toCurrency}}</b></div>
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
                <button type="button" class="btn btn-success btn-sm2 mb-1 mt-1" v-if="biayaTambahanReady==1" data-bs-target="#content_upload_pembayaran" data-bs-toggle="collapse">Pelunasan</button>
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
                        <label class="form-label">Bank</label>
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
                          <input type="number" class="form-control" name="nominal_pembayaran" :value="grand_total" required <?= $disabled ?>>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <?php if ($row->status == 'menunggu_pelunasan') { ?>
                  <div class="card-footer">
                    <div class="col-12 center">
                      <button type="button" class="btn btn-primary px-4" id="submitPelunasan" onclick="simpanPelunasan()">Simpan Pelunasan</button>
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
  function simpanPelunasan() {
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
  }
</script>

<script>
  var app_pelunasan = new Vue({
    el: '#app_pelunasan',
    data: {
      services_pelunasan: <?= json_encode($services_pelunasan) ?>,
      biaya_tambahan: <?= json_encode($biaya_tambahan) ?>,
      tbh: {
        id_tambahan: '',
        keterangan_lainnya: '',
        nominal: ''
      },
      option_biaya_tambahan: <?= json_encode($option_biaya_tambahan) ?>,
      totDP: <?= $row->grand_tot_dp ?>,
      biayaTambahanReady: 1,
    },
    methods: {
      batalServices: function(id_srv, judul) {
        Swal.fire({
          text: 'Apakah Anda Yakin Membatalkan Services : ' + judul + ' ?',
          showCancelButton: true,
          confirmButtonText: 'Lanjutkan',
          cancelButtonText: 'Batal',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            values = {
              id_services: id_srv,
              id_booking: '<?= $row->id_booking ?>',
            }
            $.ajax({
              beforeSend: function() {
                $('#btnBatalServices_' + id_srv).html('<i class="fa fa-spinner fa-spin"></i>');
                $('#btnBatalServices_' + id_srv).attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/batalServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnBatalServices_' + id_srv).attr('disabled', false);
                }
                $('#btnBatalServices_' + id_srv).html('Batal');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })

      },
      createBiayaTambahan: function() {
        this.biayaTambahanReady = 0;
        if (this.tbh.id_tambahan == '') {
          round_error_noti('Silahkan tentukan keterangan biaya tambahan')
          return false;
        }
        if (parseInt(this.tbh.nominal) == 0) {
          round_error_noti('Silahkan tentukan nominal biaya tambahan')
          return false;
        }
        if (this.tbh.id_tambahan == 999 && this.tbh.keterangan_lainnya == '') {
          round_error_noti('Silahkan tentukan keterangan lainnya dari biaya tambahan')
          return false;
        }
        if (this.tbh.id_tambahan != 999 && this.tbh.keterangan_lainnya == '') {
          this.tbh.keterangan_lainnya = '';
        }
        this.biaya_tambahan.push(this.tbh);
        this.clearTbh();
      },
      clearTbh: function() {
        this.tbh = {
          id_tambahan: '',
          keterangan_lainnya: '',
          nominal: ''
        }
      },
      deleteBiayaTambahan: function(index) {
        Swal.fire({
          text: 'Apakah Anda Yakin Menghapus Data Ini ?',
          showCancelButton: true,
          confirmButtonText: 'Ya',
          cancelButtonText: 'Batal',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            this.biaya_tambahan.splice(index, 1);
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })
      },
      simpanBiayaTambahan: function() {
        Swal.fire({
          text: 'Apakah Anda Yakin Menyimpan Biaya Tambahan ?',
          showCancelButton: true,
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            values = {
              id_booking: '<?= $row->id_booking ?>',
              biaya_tambahan: this.biaya_tambahan,
            }
            $.ajax({
              beforeSend: function() {
                $('#btnSimpanBiayaTambahan').html('<i class="fa fa-spinner fa-spin"></i> Process');
                $('#btnSimpanBiayaTambahan').attr('disabled', true);
              },
              enctype: 'multipart/form-data',
              url: '<?= site_url(get_controller() . '/simpanBiayaTambahan') ?>',
              type: "POST",
              data: values,
              // processData: false,
              // contentType: false,
              // cache: false,
              dataType: 'JSON',
              success: function(response) {
                if (response.status == 1) {
                  app_pelunasan.biaya_tambahan = response.data;
                  app_pelunasan.biayaTambahanReady = 1;
                } else {
                  round_error_noti(response.pesan);
                }
                $('#btnSimpanBiayaTambahan').attr('disabled', false);
                $('#btnSimpanBiayaTambahan').html('Simpan Biaya Tambahan');
              },
              error: function() {
                round_error_noti('Telah terjadi kesalahan !');
                $('#btnSimpanBiayaTambahan').html('Simpan Biaya Tambahan');
                $('#btnSimpanBiayaTambahan').attr('disabled', false);
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })
      }
    },
    computed: {
      totalServices: function() {
        var totalServices = 0;
        for (srv of this.services_pelunasan) {
          totalServices += parseInt(srv.biaya);
        }
        return totalServices;
      },
      totalBiayaTambahan: function() {
        var totalBiayaTambahan = 0;
        for (tbh of this.biaya_tambahan) {
          totalBiayaTambahan += parseInt(tbh.nominal);
        }
        return totalBiayaTambahan;
      },
      grand_total: function() {
        return (this.totalServices + this.totalBiayaTambahan) - this.totDP;
      }
    }
  })
</script>