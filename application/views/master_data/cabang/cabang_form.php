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
    <div class="card">
      <div class="card-header border-bottom bg-transparent">
        <div class="d-flex align-items-center">
          <a type="button" class="btn btn-outline-primary px-3 btn-sm2" href="<?= site_url(get_slug()) ?>"><i class="bx bx-chevron-left-circle mr-1"></i>Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form style='min-height:250px' id="form_">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Cabang *</label>
              <div class="form-input">
                <input type="text" class="form-control" name="nama_cabang" value="<?= isset($row) ? $row->nama_cabang : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Deskripsi Cabang</label>
              <div class="form-input">
                <textarea id="deskripsi_cabang" name="deskripsi_cabang" <?= $disabled ?>><?= isset($row) ? $row->deskripsi_cabang : '' ?></textarea>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">No. HP</label>
              <div class="form-input">
                <input type="text" class="form-control" name="no_hp_cabang" value="<?= isset($row) ? $row->no_hp_cabang : '' ?>" <?= $disabled ?>>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">No. Telepon</label>
              <div class="form-input">
                <input type="text" class="form-control" name="no_telp_cabang" value="<?= isset($row) ? $row->no_telp_cabang : '' ?>" <?= $disabled ?>>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Kepala Cabang</label>
              <div class="form-input">
                <input type="text" class="form-control" name="kepala_cabang" value="<?= isset($row) ? $row->kepala_cabang : '' ?>" <?= $disabled ?>>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Alamat Cabang</label>
              <div class="form-input">
                <input type="text" class="form-control" name="alamat" value="<?= isset($row) ? $row->alamat : '' ?>" <?= $disabled ?>>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Provinsi</label>
              <div class="form-input">
                <select class='form-control' id="provinsi_id" name="provinsi_id" <?= $disabled ?>>
                  <?php if (isset($row)) { ?>
                    <option value="<?= $row->provinsi_id ?>"> <?= $row->provinsi ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Kabupaten</label>
              <div class="form-input">
                <select class='form-control' id="kabupaten_id" name="kabupaten_id" <?= $disabled ?>>
                  <?php if (isset($row)) { ?>
                    <option value="<?= $row->kabupaten_id ?>"> <?= $row->kabupaten ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Kecamatan</label>
              <div class="form-input">
                <select class='form-control' id="kecamatan_id" name="kecamatan_id" <?= $disabled ?>>
                  <?php if (isset($row)) { ?>
                    <option value="<?= $row->kecamatan_id ?>"> <?= $row->kecamatan ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Kelurahan</label>
              <div class="form-input">
                <select class='form-control' id="kelurahan_id" name="kelurahan_id" <?= $disabled ?>>
                  <?php if (isset($row)) { ?>
                    <option value="<?= $row->kelurahan_id ?>"> <?= $row->kelurahan ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-input">
                <label class="form-label pr-5">Aktif</label>
                <input class="form-check-input" type="checkbox" name="aktif" <?= isset($row) ? $row->aktif == 1 ? 'checked' : '' : 'checked' ?> <?= $disabled ?>>
              </div>
            </div>
          </div>
        </form>
        <?php if ($mode != 'detail') { ?>
          <hr>
          <div class="col-12 center">
            <button type="button" class="btn btn-primary px-4" id="submitButton">Simpan Data</button>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php
$send['data'] = ['selectProvinsi', 'selectKabupaten', 'selectKecamatan', 'selectKelurahan'];
$this->load->view("additionals/dropdown_wilayah", $send);
?>
<script>
  tinymce.init({
    selector: '#deskripsi_cabang',
    readonly: <?= $mode == 'detail' ? 1 : 0 ?>
  });
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
    tinymce.triggerSave();
    var values = new FormData($('#form_')[0]);
    <?php if (isset($row)) { ?>
      values.append('id_cabang', '<?= $row->id_cabang ?>');
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