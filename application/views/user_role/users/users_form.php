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
          <a type="button" class="btn btn-outline-primary px-3 btn-sm2" href="<?= site_url(get_slug()) ?>"><i class="bx bx-chevron-left-circle mr-1"></i>Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap</label>
              <div class="form-input">
                <input type="text" class="form-control" name="nama_lengkap" value="<?= isset($row) ? $row->nama_lengkap : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Username</label>
              <div class="form-input">
                <input type="text" class="form-control" name="username" value="<?= isset($row) ? $row->username : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <div class="form-input">
                <input type="email" class="form-control" name="email" value="<?= isset($row) ? $row->email : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">No. HP</label>
              <div class="form-input">
                <input type="text" class="form-control" name="no_hp" value="<?= isset($row) ? $row->no_hp : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Group</label>
              <div class="form-input">
                <input type="text" class="form-control" name="no_hp" value="<?= isset($row) ? $row->no_hp : '' ?>" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="col-12 center">
            <button type="button" class="btn btn-primary px-4">Simpan Data</button>
          </div>
        </form>
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
          "targets": [0, 8],
          "orderable": false
        },
        {
          "targets": [7, 8],
          "className": 'text-center'
        },
        // {
        //   "targets": [3],
        //   "className": 'text-right'
        // },
        // // { "targets":[0],"checkboxes":{'selectRow':true}}
        // { "targets":[4],"className":'text-right'}, 
        // // { "targets":[2,4,5], "searchable": false } 
      ],
    });
  });
</script>