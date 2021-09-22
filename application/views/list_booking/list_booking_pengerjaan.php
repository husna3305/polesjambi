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
    <?php if ($row->status == 'selesai' || $row->status == 'menunggu_pelunasan') { ?>
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
          <div v-bind:class="setClassCardServices(index,'header')" style="padding-bottom:0px !important">
            <div class="row">
              <div class="col-sm-6" style="padding-top:6px">
                <h6>{{srv.judul}}</h6>
              </div>
              <div class="col-sm-6 right">
                <button type="button" class="btn btn-secondary px-2 radius-30 btn-xs" v-if="srv.status=='new'">Belum Dikerjakan</button>
                <button type="button" class="btn btn-info px-2 radius-30 btn-xs" v-if="srv.status=='start'">Sedang Dikerjakan</button>
                <button type="button" class="btn btn-warning px-2 radius-30 btn-xs color-white" v-if="srv.status=='pause'">Pause</button>
                <button type="button" class="btn btn-success px-2 radius-30 btn-xs" v-if="srv.status=='end'">Selesai</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="card">
                  <div class="card-body">
                    <table>
                      <tbody>
                        <tr>
                          <td>Waktu Mulai</td>
                          <td> : {{srv.start_at}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
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
              <div class="col-md-4" v-if="srv.status!='end' && srv.batal=='0'">
                <div class="parent-product-img border py-1 radius-10 cursor-pointer mb-1" style="background-color:#efefef" @click.prevent="showModalSetDetailers(srv.id_services,srv.judul)">
                  <div class="d-flex align-items-center" style="padding-left:5px;background-color:#efefef">
                    <div class="product-img"><i class="bx bx-user-plus" style="font-size: 25px;"></i></div>
                    <div class="ms-2">
                      <h6 class="mb-1">Tambah / Edit Detailer</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-bind:class="setClassCardServices(index,'footer')">
            <button type="button" class="btn btn-primary btn-sm1" @click.prevent="startServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && (srv.status=='new')" v-bind:id="'btnStart_'+srv.id_services">Start</button>
            <button type="button" class="btn btn-warning btn-sm1 color-white" @click.prevent="pauseServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && srv.status=='start'" v-bind:id="'btnPauseServices_'+srv.id_services">Pause</button>

            <button type="button" class="btn btn-info btn-sm1 color-white" @click.prevent="resumeServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && srv.status=='pause'" v-bind:id="'btnResumeServices_'+srv.id_services">Resume</button>

            <button type="button" class="btn btn-success btn-sm1 color-white" @click.prevent="endServices(srv.id_services,srv.judul)" v-if="srv.tot_detailers>0 && (srv.status=='pause' || srv.status=='start')" v-bind:id="'btnEndServices_'+srv.id_services">End</button>

            <button @click.prevent="batalServices(srv.id_services,srv.judul)" type="button" class="btn btn-danger px-2" v-if="srv.status!='end' && srv.batal==0" v-bind:id="'btnBatalServices_'+srv.id_services">Batal</button>

          </div>
        </div>
        <?php if ($row->status != 'selesai') { ?>
          <hr>
          <div class="card">
            <div class="card-header" style="padding-bottom:0px !important">
              <h6>Tambah Services Baru</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Pilih Services" disabled>
                    <label class="input-group-text btn-info text-white" @click.prevent="tambahServicesBaru()"><i class='fa fa-search'></i></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer center">
            </div>
          </div>
        <?php } ?>
        <?php if ($row->belum_selesai == 0 && ($row->status == 'selesai' || $row->status == 'menunggu_pelunasan') == false) { ?>
          <div class="card">
            <div class="card-header center">
              <button @click.prevent="selesaikanServices()" type="button" class="btn btn-success px-2" id="btnSelesaikanServices">Selesai</button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php
$data = ['row' => $row];
$this->load->view('list_booking/list_booking_pengerjaan_modal', $data);
?>

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
      tambahServicesBaru: function() {
        $('#modalTambahServicesBaru').modal('show');
      },
      setClassCardServices: function(idx, pos) {
        tambahan = this.services[idx].tambahan;
        batal = this.services[idx].batal;
        if (batal == 0) {
          if (tambahan == 1) {
            return pos == 'header' ? 'card-header card-green' : 'card-footer center card-green';
          } else {
            return pos == 'header' ? 'card-header' : 'card-footer center';
          }
        } else {
          return pos == 'header' ? 'card-header card-red' : 'card-footer center card-red';
        }
      },
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
      selesaikanServices: function() {
        Swal.fire({
          text: 'Apakah Anda Ingin Menyelesaikan Services dan Melanjutkan Ke Tahap Pelunasan Pembayaran ?',
          showCancelButton: true,
          confirmButtonText: 'Lanjutkan',
          cancelButtonText: 'Batal',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            values = {
              id_booking: '<?= $row->id_booking ?>',
            }
            $.ajax({
              beforeSend: function() {
                $('#btnSelesaikanServices').html('<i class="fa fa-spinner fa-spin"></i>');
                $('#btnSelesaikanServices').attr('disabled', true);
              },
              type: 'POST',
              url: '<?= site_url(get_controller() . '/selesaikanServices') ?>',
              data: values,
              dataType: 'json',
              success: function(response) {
                if (response.status == 1) {
                  window.location = response.url;
                } else {
                  $('#btnSelesaikanServices').attr('disabled', false);
                }
                $('#btnSelesaikanServices').html('Selesai');
              }
            });
          } else if (result.isDenied) {
            // Swal.fire('Changes are not saved', '', 'info')
          }
        })

      }
    }
  })
</script>