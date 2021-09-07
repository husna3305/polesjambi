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
              <input type="text" class="form-control form-control-sm set-daterangepicker" name="merk_mobil" value="" required="">
            </div>
          </div>
        </div>
        <hr>

        <div class="col-12 center">
          <button type="button" class="btn btn-primary btn-sm2 px-4" id="submitButton">Preview PDF</button>
          <button type="button" class="btn btn-success btn-sm2 px-4" id="submitButton">Download XLS</button>
        </div>
      </div>
      <div class="card-body">
        <!-- <div class="table-responsive"> -->
        <table id="serverside-tables" style="width:100%">
          <thead>
            <tr>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <!-- </div> -->
      </div>
    </div>
  </div>
</div>