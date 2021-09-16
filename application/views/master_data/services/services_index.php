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
    <div class="card">
      <div class="card-header border-bottom bg-transparent">
        <div class="d-flex align-items-center">
          <a type="button" class="btn btn-outline-primary px-2 btn-sm2" href="<?= site_url(get_slug() . '/insert') ?>"><i class="bx bx-plus mr-1"></i>Tambah Baru</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="serverside-tables" class="table" style="width:100%">
            <thead>
              <tr>
                <th width="8%">#</th>
                <th>Services</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Estimasi Waktu Pengerjaan</th>
                <th width='12%'>Aktif</th>
                <th width='12%'>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
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
        url: "<?php echo site_url(get_controller() . '/fetchData'); ?>",
        type: "POST",
        dataSrc: "data",
        data: function(d) {
          // d.periode = '';
          return d;
        },
      },
      "columnDefs": [{
          "targets": [0, 6],
          "orderable": false
        },
        {
          "targets": [5, 6],
          "className": 'text-center'
        },
        {
          "targets": [3],
          "className": 'right'
        },
        // // { "targets":[0],"checkboxes":{'selectRow':true}}
        // { "targets":[4],"className":'text-right'}, 
        // // { "targets":[2,4,5], "searchable": false } 
      ],
    });
  });
</script>