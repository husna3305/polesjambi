<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" /> -->
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/booking.css" />

  <!-- DatePicker -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

  <script src="<?= base_url() ?>assets/plugins/select2/js/select2.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2-bootstrap4.css">

  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>fontawesome/css/all.css" />
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/png" />


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

  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datetimepicker/css/classic.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datetimepicker/css/classic.time.css">
  <script src="<?= base_url() ?>assets/plugins/moment/moment.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datetimepicker/js/picker.time.js"></script>

  <title>Booking Form</title>
</head>

<body>
  <div class="jumbotron" style="background-image: url(<?= base_url('assets/front/') ?>assets/img/background.jpg)">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form class="form-booking" id="form_">
            <h2 class="text-center">Data Booking</h2>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="no_polisi">No. Polisi</label>
                <input type="text" class="form-control" id="no_polisi" name='no_polisi' v-model="no_polisi" placeholder="No. Polisi" />
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama">Nama Lengkap</label>
              <input type="text" class="form-control" id="inputNama" name='nama_lengkap' v-model="nama_lengkap" placeholder="Nama Lengkap" />
            </div>
            <div class="form-group">
              <label for="inputNoWa">No. Wa (Aktif)</label>
              <input type="text" class="form-control" id="inputNoWa" name='no_wa' v-model="no_wa" placeholder="No. Wa" />
            </div>
            <div class="form-group">
              <label for="id_merk_mobil">Merk Mobil</label>
              <select id="id_merk_mobil" class="form-control" name="id_merk_mobil" style="width:100%">
                <option selected disabled>Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="id_jenis_mobil">Jenis Mobil</label>
              <select id="id_jenis_mobil" class="form-control" name="id_jenis_mobil" style="width:100%">
                <option selected disabled>Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="jadwal">Jadwal Booking</label>
              <input class='datetimepicker form-control' name="jadwal_booking" readonly />
            </div>
            <div class="form-group">
              <label for="jadwal">Apakah Ingin Dijemput</label>&nbsp;&nbsp;&nbsp;
              <input type="checkbox" v-model="dijemput" />
            </div>
            <div class="form-group" v-if="dijemput==true">
              <label for="alamat">Alamat ( Jika antar jemput )</label>
              <textarea class="form-control" id="alamat" rows="5" name="alamat"></textarea>
              <label for="provinsi">Provinsi</label>
              <select id="provinsi_id" name="provinsi_id" class="form-control" style="width:100%">
                <option selected value="15">Jambi</option>
              </select>
              <label for="kabupaten">Kota</label>
              <select id="kabupaten_id" name="kabupaten_id" class="form-control" style="width:100%">
                <option selected value='1571'>Kota Jambi</option>
              </select>
              <label for="kecamatan_id">Kecamatan</label>
              <select id="kecamatan_id" name="kecamatan_id" class="form-control" style="width:100%">
                <option selected>Pilih</option>
              </select>
              <label for="kelurahan_id">Kelurahan</label>
              <select id="kelurahan_id" name="kelurahan_id" class="form-control" style="width:100%">
                <option selected>Pilih</option>
              </select>
            </div>
            <button type="button" @click.prevent="showModalRincian" class="btn btn-primary">
              Submit
            </button>
            <div class="modal fade" id="modalRincian" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Rincian Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-4">Nomor Polisi</div>
                      <div class="col-md-6">: {{no_polisi}}</div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">Nama Lengkap</div>
                      <div class="col-md-6">: {{nama_lengkap}}</div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">No Whatsapp</div>
                      <div class="col-md-6">: {{no_wa}}</div>
                    </div>

                    <br>
                    <p style='font-weight:bold'>Services</p>
                    <div class="row" v-for="(srv, index) of services">
                      <div class="col-md-4">{{srv.judul}}</div>
                      <div class="col-md-4 ml-auto" align='right'>Rp. {{srv.estimasi_biaya | toCurrency}}</div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-4">Subtotal</div>
                      <div class="col-md-4 ml-auto" align='right'>Rp. {{subtotal | toCurrency}}</div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">Discount</div>
                      <div class="col-md-4 ml-auto" align='right'>Rp. {{diskon | toCurrency}}</div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">Pajak</div>
                      <div class="col-md-4 ml-auto" align='right'>Rp. {{ppn | toCurrency}}</div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-4">Total</div>
                      <div class="col-md-4 ml-auto" align='right'>Rp. {{grandtotal | toCurrency}}</div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnSimpanBooking" @click.prevent="simpanBooking" class="btn btn-primary btn-next active" role="button" aria-pressed="true">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>

  <?php
  $send['data'] = ['selectMerkMobil', 'selectJenisMobil'];
  $this->load->view("additionals/dropdown_mobil", $send);
  ?>

  <?php
  $send['data'] = ['selectProvinsi', 'selectKabupaten', 'selectKecamatan', 'selectKelurahan'];
  $this->load->view("additionals/dropdown_wilayah", $send);
  ?>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>
<script>
  var form_ = new Vue({
    el: '#form_',
    data: {
      dijemput: false,
      no_polisi: '',
      nama_lengkap: '',
      no_wa: '',
      services: <?= json_encode($services) ?>
    },
    methods: {
      showModalRincian: function(idx) {
        $('#modalRincian').modal('show');
      },
      simpanBooking: function() {
        var values = new FormData($('#form_')[0]);
        // values.append('details', JSON.stringify(frm_hasil.details));
        values.append('var', '<?= $var ?>');
        $.ajax({
          beforeSend: function() {
            $('#btnSimpanBooking').attr('disabled', true);
            $('#btnSimpanBooking').html('<i class="fa fa-spinner fa-spin"></i>');
          },
          enctype: 'multipart/form-data',
          url: '<?= site_url('front/saveDataBooking') ?>',
          type: "POST",
          data: values,
          processData: false,
          contentType: false,
          cache: false,
          dataType: 'JSON',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.link;
            } else {
              $('#btnSimpanBooking').attr('disabled', false);
              toast(response.pesan)
            }
            $('#btnSimpanBooking').html('Save');
          },
          error: function() {
            toast(msg_error)
            $('#btnSimpanBooking').html('Save');
            $('#btnSimpanBooking').attr('disabled', false);
          }
        });
      }
    },
    computed: {
      subtotal: function() {
        let subtotal = 0;
        for (srv of this.services) {
          subtotal += parseInt(srv.estimasi_biaya);
        }
        return subtotal;
      },
      diskon: function() {
        return 0;
      },
      ppn: function() {
        return 0;
      },
      grandtotal: function() {
        return (this.subtotal - this.diskon) + this.ppn;
      },
    }
  })

  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0! 
  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd
  }
  if (mm < 10) {
    mm = '0' + mm
  }
  var today = yyyy + '/' + mm + '/' + dd;
  var endDate = '<?= batas_maksimal_booking() ?>';
  $('.datepicker').daterangepicker({
    //  timePicker: false,
    minDate: today,
    maxDate: endDate,
    singleDatePicker: true,
    isInvalidDate: false,
    autoUpdateInput: false,
    showDropdowns: true,
    locale: {
      cancelLabel: 'Clear',
      format: 'YYYY-MM-DD',
    },
  })
  $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
  });
  $('.datepicker').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });
  $('.datetimepicker').daterangepicker({
    timePicker: true,
    minDate: today,
    maxDate: endDate,
    timePickerIncrement: 1,
    singleDatePicker: true,
    timePicker24Hour: true,
    timePickerSeconds: false,
    isInvalidDate: false,
    autoUpdateInput: true,
    startDate: moment().startOf('seconds'),
    locale: {
      cancelLabel: 'Clear',
      format: 'YYYY-MM-DD HH:mm',
      //  monthNames: [
      //    "Januari",
      //    "Februari",
      //    "Maret",
      //    "April",
      //    "Mei",
      //    "Juni",
      //    "Jul",
      //    "Agustus",
      //    "September",
      //    "Oktober",
      //    "November",
      //    "Desember"
      //  ]
    },

  })
</script>

</html>