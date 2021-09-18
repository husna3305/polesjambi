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
                  <!-- <p class="mb-0"></p> -->
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
</script>

<div class="modal fade" id="modalTambahServicesBaru" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">List Services</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="serverside-tables" class="table table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Services</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Estimasi Waktu Pengerjaan</th>
                <th width='12%'>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    var dataTable = $('#serverside-tables').DataTable({
      "processing": true,
      "serverSide": true,
      // "scrollX": true,
      "language": {
        "infoFiltered": "",
        "processing": "<p style='font-size:18pt;background:#d9d9d9b8;color:black;width:100%'><i class='fa fa-refresh fa-spin'></i></p>",
      },
      "order": [],
      "lengthMenu": [
        [10, 25, 50, 75, 100],
        [10, 25, 50, 75, 100]
      ],
      "ajax": {
        url: "<?php echo site_url(get_controller() . '/fetchDataServices'); ?>",
        type: "POST",
        dataSrc: "data",
        data: function(d) {
          d.id_booking = '<?= $row->id_booking ?>';
          return d;
        },
      },
      "columnDefs": [{
          "targets": [0, 4],
          "orderable": false
        },
        {
          "targets": [4],
          "className": 'text-center'
        },
        {
          "targets": [2],
          "className": 'right'
        },
        // // { "targets":[0],"checkboxes":{'selectRow':true}}
        // { "targets":[4],"className":'text-right'}, 
        // // { "targets":[2,4,5], "searchable": false } 
      ],
    });
  });

  function pilihServices(params) {
    Swal.fire({
      text: 'Apakah Anda Yakin Menambah Services : ' + params.judul + ' ?',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        values = {
          id_services: params.id_services,
          id_booking: '<?= $row->id_booking ?>',
        }
        $.ajax({
          beforeSend: function() {
            $('.btnPilihListServices').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.btnPilihListServices').attr('disabled', true);
          },
          type: 'POST',
          url: '<?= site_url(get_controller() . '/tambahServices') ?>',
          data: values,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              window.location = response.url;
            } else {
              $('.btnPilihListServices').attr('disabled', false);
            }
            $('.btnPilihListServices').html('<i class="fa fa-plus"></i>');
          }
        });
      } else if (result.isDenied) {
        // Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }
</script>