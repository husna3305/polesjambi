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
      <div class="card-body" id="app_services">
        <div class="row mb-3">
          <div class="col-sm-8">
            <h6>Pengerjaan </h6>
          </div>
          <div class="col-sm-4" align='right'>
            <?php if ($row->status == 'menunggu_kedatangan') { ?>
              <!-- <button type="button" class="btn btn-info px-2 radius-30 btn-sm ">Menunggu Kedatangan</button> -->
            <?php } else { ?>
              <!-- <button type="button" class="btn btn-info px-2 radius-30 btn-sm">Sedang Dikerjakan</button> -->
            <?php } ?>
          </div>
        </div>

        <div class="card" v-for="(srv, index) of services">
          <div class="card-header" style="padding-bottom:0px !important">
            <div class="row">
              <div class="col-sm-6" style="padding-top:6px">
                <h6>{{srv.judul}}</h6>
              </div>
              <div class="col-sm-6 right">
                <button type="button" class="btn btn-secondary px-2 radius-30 btn-sm" v-if="srv.status=='' || srv.status==null">Belum Dikerjakan</button>
                <button type="button" class="btn btn-info px-2 radius-30 btn-sm" v-if="srv.status=='start'">Sedang Dikerjakan</button>
                <button type="button" class="btn btn-warning px-2 radius-30 btn-sm" v-if="srv.status=='pause'">Pause</button>
                <button type="button" class="btn btn-success px-2 radius-30 btn-sm" v-if="srv.status=='end'">Selesai</button>
                <!-- <button type="button" class="btn btn-danger px-2 btn-sm" v-if="srv.status!='end'">Batal</button> -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4" v-for="(dtlr, index) of srv.detailers">
                <div class="parent-product-img border py-1 radius-10 cursor-pointer mb-1">
                  <div class="d-flex align-items-center" style="padding-left:5px">
                    <div class="product-img">
                      <img v-bind:src="'<?= base_url() ?>'+dtlr.gambar_small" alt="car" />
                    </div>
                    <div class="ms-2">
                      <h6 class="mb-1">{{dtlr.nama_detailer}}</h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4" v-if="srv.status!='end'">
                <div class="parent-product-img border py-1 radius-10 cursor-pointer mb-1" style="background-color:#efefef" @click.prevent="showModalSetDetailers(srv.id_services,srv.judul)">
                  <div class="d-flex align-items-center" style="padding-left:5px;background-color:#efefef">
                    <div class="product-img"><i class="bx bx-user-plus" style="font-size: 25px;"></i></div>
                    <div class="ms-2">
                      <h6 class="mb-1">Tambah Detailer</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer center">
            <button type="button" class="btn btn-primary btn-sm1" @click.prevent="startServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && (srv.status=='' || srv.status==null)" v-bind:id="'btnStart_'+srv.id_services">Start</button>
            <button type="button" class="btn btn-warning btn-sm1 color-white" @click.prevent="pauseServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && srv.status=='start'" v-bind:id="'btnPauseServices_'+srv.id_services">Pause</button>

            <button type="button" class="btn btn-info btn-sm1 color-white" @click.prevent="resumeServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && srv.status=='pause'" v-bind:id="'btnResumeServices_'+srv.id_services">Resume</button>

            <button type="button" class="btn btn-success btn-sm1 color-white" @click.prevent="endServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && (srv.status=='pause' || srv.status=='start')" v-bind:id="'btnEndServices_'+srv.id_services">End</button>
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
        <h5 class="modal-title">Detailers Untuk {{judul}}</h5>
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
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" @click.prevent="simpanDetailers()" id="btnSimpanDetailers">Simpan Detailer</button>
      </div>
    </div>
  </div>
</div>
<script>
  var app_services = new Vue({
    el: '#app_services',
    data: {
      services: <?= json_encode($services) ?>
    },
    methods: {
      showModalSetDetailers: function(id_srv, judul) {
        modalSetDetailers.id_services = id_srv;
        modalSetDetailers.judul = judul;
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
      },
      startServices: function(id_srv, judul) {
        Swal.fire({
          text: 'Apakah Anda Yakin Melakukan Start Untuk Services : ' + judul + ' ?',
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
                $('#btnStart_' + id_srv).html('<i class="fa fa-spinner fa-spin"></i> Process');
                $('#btnStart_' + id_srv).attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/startServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnStart_' + id_srv).attr('disabled', false);
                }
                $('#btnStart_' + id_srv).html('Start');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })
      },
      pauseServices: function(id_srv, judul) {
        Swal.fire({
          text: 'Apakah Anda Yakin Melakukan Pause Untuk Services : ' + judul + ' ?',
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
                $('#btnPauseServices_' + id_srv).html('<i class="fa fa-spinner fa-spin"></i> Process');
                $('#btnPauseServices_' + id_srv).attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/pauseServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnPauseServices_' + id_srv).attr('disabled', false);
                }
                $('#btnPauseServices_' + id_srv).html('Pause');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })
      },
      resumeServices: function(id_srv, judul) {
        Swal.fire({
          text: 'Apakah Anda Yakin Melakukan Resume Untuk Services : ' + judul + ' ?',
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
                $('#btnResumeServices_' + id_srv).html('<i class="fa fa-spinner fa-spin"></i> Process');
                $('#btnResumeServices_' + id_srv).attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/resumeServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnResumeServices_' + id_srv).attr('disabled', false);
                }
                $('#btnResumeServices_' + id_srv).html('Resume');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })
      },
      endServices: function(id_srv, judul) {
        Swal.fire({
          text: 'Apakah Anda Yakin Mengakhiri Services : ' + judul + ' ?',
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
                $('#btnEndServices_' + id_srv).html('<i class="fa fa-spinner fa-spin"></i> Process');
                $('#btnEndServices_' + id_srv).attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/endServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnEndServices_' + id_srv).attr('disabled', false);
                }
                $('#btnEndServices_' + id_srv).html('End');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })

      },
    },
  })

  var modalSetDetailers = new Vue({
    el: '#modalSetDetailers',
    data: {
      id_services: '',
      judul: '',
      detailers_services: []
    },
    methods: {
      simpanDetailers: function(id) {
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
            $('#btnSimpanDetailers').html('<i class="fa fa-spinner fa-spin"></i> Process');
            $('#btnSimpanDetailers').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/simpanDetailersServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('#btnSimpanDetailers').attr('disabled', false);
            }
            $('#btnSimpanDetailers').html('Simpan Data');
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

  function batalServices(el, id_srv, judul) {
    values = {
      id_services: id_srv
    }
    Swal.fire({
      text: 'Apakah Anda Yakin Membatalkan Services : ' + judul + ' ?',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          beforeSend: function() {
            $(el).html('<i class="fa fa-spinner fa-spin"></i>');
            $(el).attr('disabled', true);
          },
          enctype: 'multipart/form-data',
          url: '<?= site_url(get_controller() . '/batalServices') ?>',
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
              $(el).attr('disabled', false);
            }
            $(el).html('Batal');
          },
          error: function() {
            round_error_noti('Telah terjadi kesalahan !');
            $(el).html('Batal');
            $(el).attr('disabled', false);
          }
        });
      } else if (result.isDenied) {
        // Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }
</script>