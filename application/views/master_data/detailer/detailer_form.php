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
              <label class="form-label">Nama Detailer *</label>
              <div class="form-input">
                <input type="text" class="form-control" name="nama_detailer" value="<?= isset($row) ? $row->nama_detailer : '' ?>" required <?= $disabled ?>>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">No. HP</label>
              <div class="form-input">
                <input type="text" class="form-control" name="no_hp" value="<?= isset($row) ? $row->no_hp : '' ?>" <?= $disabled ?> max-length=20>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Foto Detailer</label>
              <div class="form-input">
                <div class="input-group mb-3">
                  <input type="file" class="form-control" name="gambar" <?= $disabled ?>>
                  <?php if (isset($row)) {
                    if ((string)$row->gambar_big != '') { ?>
                      <label class="input-group-text btn-info text-white" onclick="showModalPreviewImages('<?= base_url($row->gambar_big) ?>')"><i class='fa fa-eye'></i></label>
                  <?php }
                  } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Cabang *</label>
              <div class="form-input">
                <select class='form-control' id="id_cabang" name="id_cabang" <?= $disabled ?> required>
                  <?php if (isset($row)) { ?>
                    <option value="<?= $row->id_cabang ?>"> <?= $row->nama_cabang ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Alamat</label>
              <div class="form-input">
                <input type="text" class="form-control" name="alamat" value="<?= isset($row) ? $row->alamat : '' ?>" <?= $disabled ?>>
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
<?php $this->load->view('additionals/modal_preview_images'); ?>
<?php
$send['data'] = ['selectCabang'];
$this->load->view("additionals/dropdown_cabang", $send);
?>
<script>
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
    var values = new FormData($('#form_')[0]);
    <?php if (isset($row)) { ?>
      values.append('id_detailer', <?= $row->id_detailer ?>);
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