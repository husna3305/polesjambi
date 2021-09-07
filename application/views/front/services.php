<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" /> -->
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/services.css" />
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/png" />


  <!-- Fontawesome -->
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>fontawesome/css/all.css" />
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
  <title>Services</title>
</head>

<body>
  <!-- ===== Navbar ===== -->
  <nav class="navbar navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Polesjambi</a>
    </div>
  </nav>

  <section class="services" id="services" style='min-height:600px'>
    <div class="container">
      <div class="row justify-content-center" id="form_">
        <div class="col-md-12 mb-5 box-service">
          <h2 class="mt-3">Pilih Services</h2>
          <div class="row mt-4">
            <div class="col-sm-12 col-md-4 mb-4" v-for="(srv, index) of services">
              <div :class="srv.dipilih==0?'category-service':'category-service category-service-selected'">
                <img v-bind:src="'<?= base_url() ?>'+srv.gambar_small" alt="car" />
                <p class="choose-services">{{srv.judul}}</p>
                <p class="price text-danger">Rp. {{srv.estimasi_biaya | toCurrency}}</p>
                <p class="description"><i class="far fa-clock"></i><span v-if="srv.estimasi_waktu_jam>0">{{srv.estimasi_waktu_jam}} Jam,</span> <span>{{srv.estimasi_waktu_menit}} Menit</span></p>
                <button type="button" :class="classBtnPilih(index)" @click.prevent="pilihServices(index)">
                  <p class="teks">{{labelBtnPilih(index)}} <span v-if="srv.dipilih==1"><i class="fa fa-check"></i></span></p>
                </button>
                <button type="button" class="btn btn-detail" @click.prevent="showModalServices(srv.id_services)">
                  <p class="teks text-warning">Detail</p>
                </button>
              </div>
            </div>
          </div>
          <div class="row justify-content-end">
            <button @click.prevent="nextPage()" id="btnNextPage" class="btn btn-primary btn-next active next" role="button" aria-pressed="true">Next</button>
          </div>
        </div>
        <div class="modal fade" id="modalDetailServices" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="titleModalDetailServices"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id='contentModalDetailServices'></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script>
    var form_ = new Vue({
      el: '#form_',
      data: {
        services: <?= json_encode($services) ?>
      },
      methods: {
        labelBtnPilih: function(idx) {
          cek = this.services[idx].dipilih;
          if (cek == 0) {
            return 'Pilih';
          }
        },
        classBtnPilih: function(idx) {
          cek = this.services[idx].dipilih;
          if (cek == 0) {
            return 'btn btn-outline-info pilih';
          } else {
            return 'btn btn-outline-info pilih btn-dipilih';
          }
        },
        showModalServices: function(id) {
          $.ajax({
            type: 'POST',
            url: '<?= site_url('front/getDetailServices') ?>' + '?id=' + id,
            data: '',
            dataType: 'json',
            success: function(response) {
              if (response.status == 1) {
                data = response.data;
                $('#titleModalDetailServices').text(data.judul);
                $('#contentModalDetailServices').html(data.deskripsi);
                $('#modalDetailServices').modal('show')
              } else {
                // $('#btnNextPage').attr('disabled', false);
              }
              // $('#btnNextPage').html('Simpan Data');
            }
          });
        },
        pilihServices: function(idx) {
          cek = this.services[idx].dipilih;
          if (cek == 1) {
            this.services[idx].dipilih = 0;
          } else {
            this.services[idx].dipilih = 1;
          }
        },
        nextPage: function() {
          let set = 0;
          new_serv = [];
          for (x of this.services) {
            if (x.dipilih == 1) {
              new_serv.push(x.id_services);
            }
          }
          if (new_serv.length == 0) {
            alert('Silahkan pilih services yang tersedia');
            return false;
          }
          var values = {
            services: new_serv
          };

          $.ajax({
            beforeSend: function() {
              $('#btnNextPage').attr('disabled', true);
              $('#btnNextPage').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            enctype: 'multipart/form-data',
            url: '<?= site_url('front/dataBooking') ?>',
            type: "POST",
            data: values,
            // processData: false,
            // contentType: false,
            // cache: false,
            dataType: 'JSON',
            success: function(response) {
              if (response.status == 1) {
                window.location = response.link;
              } else {
                $('#btnNextPage').attr('disabled', false);
                toast(response.pesan)
              }
              $('#btnNextPage').html('Next');
            },
            error: function() {
              toast(msg_error)
              $('#btnNextPage').html('Next');
              $('#btnNextPage').attr('disabled', false);
            }
          });
        }
      },
    })
  </script>
</body>

</html>