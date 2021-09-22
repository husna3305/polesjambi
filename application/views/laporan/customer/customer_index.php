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
      <div class="card-header">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Periode</label>
            <div class="form-input">
              <input type="text" class="form-control form-control-sm set-daterangepicker" id="periode">
            </div>
          </div>
        </div>
        <hr>

        <div class="col-12 center">
          <button type="button" class="btn btn-primary btn-sm2 px-4 btnReport" onclick="getReport('pdf')">Preview PDF</button>
          <button type="button" class="btn btn-success btn-sm2 px-4 btnReport" onclick="getReport('xls')">Download XLS</button>
        </div>
      </div>
      <div class="card-body">
        <div id="loader" class="center py-4"><i class="fa fa-spinner fa-spin" style="font-size:60px"></i></div>
        <div style="min-height: 600px">
          <iframe style="overflow: auto; border: 0px solid #fff; width: 100%; height: 602px;margin-bottom: -5px;" id="showReport"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#loader').hide();
  })

  function getReport(tipe) {
    $('#showReport').hide();
    var value = {
      periode: $('#periode').val(),
      tipe: tipe,
    }

    if (value.periode == '') {
      alert('Silahkan tentukan periode terlebih dahulu');
      return false;
    } else {
      let values = JSON.stringify(value);
      $('#loader').show();
      $('.btnReport').attr('disabled', true);
      $("#showReport").attr("src", '<?php echo site_url(get_controller() . '/getReport?') ?>params=' + values);
      document.getElementById("showReport").onload = function(e) {
        $('#showReport').show();
        $('#loader').hide();
        $('.btnReport').attr('disabled', false);
      };
    }
  }
</script>