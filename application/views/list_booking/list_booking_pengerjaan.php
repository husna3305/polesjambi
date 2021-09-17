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
      <span class="badge rounded-pill <?= ($row->status == 'sedang_dikerjakan' || $row->status == 'menunggu_kedatangan') == true ? 'bg-primary' : 'bg-light border' ?>">&nbsp;</span>
    </h5>
    <?php if ($row->status == 'selesai') { ?>
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
            <h6>Pengerjaan </h6>
          </div>
          <div class="col-sm-4" align='right'>
            <?php if ($row->status == 'menunggu_kedatangan') { ?>
              <button type="button" class="btn btn-info px-2 radius-30 btn-sm ">Menunggu Kedatangan</button>
            <?php } else { ?>
              <button type="button" class="btn btn-info px-2 radius-30 btn-sm">Sedang Dikerjakan</button>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card" style="background-color:#f4f4f4">
              <div class="card-body">
                <ul class="list-group list-group-flush radius-10">
                  <?php $total = 0;
                  foreach ($services as $key => $srv) {
                    $total += $srv->biaya; ?>
                    <li class="list-group-item d-flex align-items-center radius-10 mb-2 shadow-sm">
                      <div class="col-sm-6">
                        <h7 class="mb-0"><?= $srv->judul ?></h7>
                      </div>
                      <div class="col-sm-4">
                        <?php if ($srv->status == null || $srv->status == '') { ?>
                          <button type="button" class="btn btn-secondary px-2 radius-30 btn-sm">Belum Dikerjakan</button>
                        <?php } elseif ($srv->status == 'start') { ?>
                          <button type="button" class="btn btn-info px-2 radius-30 btn-sm">Sedang Dikerjakan</button>
                        <?php } elseif ($srv->status == 'pause') { ?>
                          <button type="button" class="btn btn-warning px-2 radius-30 btn-sm color-white">Pause</button>
                        <?php } elseif ($srv->status == 'end') { ?>
                          <button type="button" class="btn btn-success px-2 radius-30 btn-sm color-white">End</button>
                        <?php } ?>
                      </div>
                      <div class="col-sm-2 right">
                        <button type="button" class="btn btn-primary position-relative me-lg-2 btn-sm mt-1" onclick="showModalSetDetailers(<?= $srv->id_services ?>)"> <i class="bx bx-group align-middle"></i> Detailers <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $srv->tot_detailers ?> <span class="visually-hidden"></span></span>
                        </button>
                      </div>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalSetDetailers" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detailers Services Tes ABC</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="product-list p-1 mb-10">
          <div :class="classDetailersDipilih(index)" v-for="(srv, index) of detailers_services" @click.prevent="pilihDetailers(index)">
            <div class="col-sm-8">
              <div class="d-flex align-items-center">
                <div class="product-img">
                  <img v-bind:src="'<?= base_url() ?>'+srv.gambar_small" alt="car" />
                </div>
                <div class="ms-2">
                  <h6 class="mb-1">{{srv.nama_detailer}}</h6>
                  <!-- <p class="mb-0">$240.00</p> -->
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div id="chart5"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-primary" @click.prevent="startServices()" id="btnStart" v-if="tot_detailers==0">Start</button>
        <button type="button" class="btn btn-warning color-white" @click.prevent="pauseServices()" id="btnPauseServices" v-if="tot_detailers>0 && status_services=='start'">Pause</button>

        <button type="button" class="btn btn-info color-white" @click.prevent="resumeServices()" id="btnResumeServices" v-if="tot_detailers>0 && status_services=='pause'">Resume</button>

        <button type="button" class="btn btn-success color-white" @click.prevent="endServices()" id="btnEndServices" v-if="tot_detailers>0 && status_services!='end'">End</button>
      </div>
    </div>
  </div>
</div>
<script>
  function showModalSetDetailers(id_srv) {

    modalSetDetailers.id_services = id_srv;
    values = {
      id_services: id_srv,
      id_booking: '<?= $row->id_booking ?>'
    }
    $.ajax({
      type: 'POST',
      url: '<?= site_url(get_controller() . '/getDetailersVsServices') ?>',
      data: values,
      dataType: 'json',
      success: function(response) {
        if (response.status == 1) {
          modalSetDetailers.detailers_services = response.data;

          services = response.services;
          modalSetDetailers.tot_detailers = services.tot_detailers;
          modalSetDetailers.status_services = services.status;
          $('#modalDetailServices').modal('show')
        } else {
          // $('#btnNextPage').attr('disabled', false);
        }
        // $('#btnNextPage').html('Simpan Data');
      }
    });
    $('#modalSetDetailers').modal('show');
  }
  var modalSetDetailers = new Vue({
    el: '#modalSetDetailers',
    data: {
      id_services: '',
      tot_detailers: 0,
      status_services: '',
      detailers_services: []
    },
    methods: {
      startServices: function(id) {
        let cek_pilih = 0;
        for (x of this.detailers_services) {
          if (x.dipilih == 1) {
            cek_pilih++;
          }
        }
        if (cek_pilih == 0) {
          round_error_noti('Silahkan tentukan detailers terlebih dahulu');
          return false;
        }
        values = {
          detailers: this.detailers_services,
          id_services: this.id_services,
          id_booking: '<?= $row->id_booking ?>',
        }
        $.ajax({
          beforeSend: function() {
            $('#btnStart').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#btnStart').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/simpanDetailersServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('#btnStart').attr('disabled', false);
            }
            $('#btnStart').html('Start');
          }
        });
      },
      pauseServices: function(id) {
        values = {
          id_services: this.id_services,
          id_booking: '<?= $row->id_booking ?>',
        }
        $.ajax({
          beforeSend: function() {
            $('#btnPauseServices').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#btnPauseServices').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/pauseServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('#btnPauseServices').attr('disabled', false);
            }
            $('#btnPauseServices').html('Pause');
          }
        });
      },
      resumeServices: function(id) {
        values = {
          id_services: this.id_services,
          id_booking: '<?= $row->id_booking ?>',
        }
        $.ajax({
          beforeSend: function() {
            $('#btnResumeServices').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#btnResumeServices').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/resumeServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('#btnResumeServices').attr('disabled', false);
            }
            $('#btnResumeServices').html('Resume');
          }
        });
      },
      endServices: function(id) {
        values = {
          id_services: this.id_services,
          id_booking: '<?= $row->id_booking ?>',
        }
        $.ajax({
          beforeSend: function() {
            $('#btnEndServices').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#btnEndServices').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/endServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('#btnEndServices').attr('disabled', false);
            }
            $('#btnEndServices').html('End');
          }
        });
      },
      pilihDetailers: function(idx) {
        cek = this.detailers_services[idx].dipilih;
        if (cek == 1) {
          this.detailers_services[idx].dipilih = 0;
        } else {
          this.detailers_services[idx].dipilih = 1;
        }
      },
      classDetailersDipilih: function(idx) {
        cek = this.detailers_services[idx].dipilih;
        if (cek == 0) {
          return 'row border mx-0 mb-3 py-2 radius-10 cursor-pointer';
        } else {
          return 'row border mx-0 mb-3 py-2 radius-10 cursor-pointer detailers-dipilih';
        }
      },
    },
  })
</script>