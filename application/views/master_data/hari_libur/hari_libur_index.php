<link href="<?= base_url() ?>assets/plugins/fullcalendar/css/main.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>assets/plugins/fullcalendar/js/main.min.js"></script>

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
          <?php $adds = isset($isCalendar) ? '?isCalendar' : ''; ?>
          <a type="button" class="btn btn-outline-primary px-2 btn-sm2" href="<?= site_url(get_slug() . '/insert' . $adds) ?>"><i class="bx bx-plus mr-1"></i>Tambah Baru</a>
        </div>
      </div>
      <div class="card-body">
        <ul class="nav nav-tabs nav-primary" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link <?= isset($isCalendar) ? '' : 'active' ?>" href="<?= site_url(get_slug()) ?>" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <!-- <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i></div> -->
                <div class="tab-title">List View</div>
              </div>
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link  <?= isset($isCalendar) ? 'active' : '' ?>" href="<?= site_url(get_slug() . '?isCalendar') ?>" role="tab" aria-selected="true">
              <div class="d-flex align-items-center">
                <!-- <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i></div> -->
                <div class="tab-title">Calendar View</div>
              </div>
            </a>
          </li>
        </ul>
        <div class="tab-content py-3">
          <div class="tab-pane fade <?= isset($isCalendar) ? '' : 'show active' ?>" id="primaryhome" role="tabpanel">
            <div class="table-responsive">
              <table id="serverside-tables" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th width="8%">#</th>
                    <th>Tanggal Mulai Libur</th>
                    <th>Tanggal Akhir Libur</th>
                    <th>Keterangan</th>
                    <th width='12%'>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade <?= isset($isCalendar) ? 'show active' : '' ?>" id="primaryprofile" role="tabpanel">
            <div class="table-responsive">
              <div id='calendar'></div>
            </div>
          </div>
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
          "targets": [0, 4],
          "orderable": false
        },
        {
          "targets": [4],
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
<script>
  $(document).ready(function() {
    $.ajax({
      beforeSend: function() {
        $('#calendar').html('<p class="center" style="font-size:80px;padding-top:20px"><i class="fa fa-spinner fa-spin"></i></p>');
      },
      enctype: 'multipart/form-data',
      url: '<?= site_url(get_controller() . '/getListForCalendar') ?>',
      type: "POST",
      data: '',
      processData: false,
      contentType: false,
      async: true,
      dataType: 'JSON',
      success: function(response) {
        $('#calendar').html('');
        if (response.status == 1) {
          render_calendar(response.data);
        }
      },
      error: function() {
        round_error_noti('Telah terjadi kesalahan !');
      }
    });
  })

  function render_calendar(params_event) {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
        // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      initialView: 'dayGridMonth',
      initialDate: '<?= tanggal() ?>',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      nowIndicator: true,
      dayMaxEvents: true, // allow "more" link when too many events
      editable: true,
      selectable: true,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: params_event,
      eventStartEditable: false,
      eventDrop: function(arg) {
        var start = arg.event.start.toDateString() + ' ' + arg.event.start.getHours() + ':' + arg.event.start.getMinutes() + ':' + arg.event.start.getSeconds();
        if (arg.event.end == null) {
          end = start;
        } else {
          var end = arg.event.end.toDateString() + ' ' + arg.event.end.getHours() + ':' + arg.event.end.getMinutes() + ':' + arg.event.end.getSeconds();
        }
        console.log(start);
        // $.ajax({
        //   url: url + "api/update.php",
        //   type: "POST",
        //   data: {
        //     id: arg.event.id,
        //     start: start,
        //     end: end
        //   },
        // });
      },
      eventClick: function(arg) {
        console.log(arg)
      },
      eventResize: function(arg) {
        var start = arg.event.start.toDateString() + ' ' + arg.event.start.getHours() + ':' + arg.event.start.getMinutes() + ':' + arg.event.start.getSeconds();
        var end = arg.event.end.toDateString() + ' ' + arg.event.end.getHours() + ':' + arg.event.end.getMinutes() + ':' + arg.event.end.getSeconds();
        console.log(end);
        // $.ajax({
        //   url: url + "api/update.php",
        //   type: "POST",
        //   data: {
        //     id: arg.event.id,
        //     start: start,
        //     end: end
        //   },
        // });
      },
    });
    calendar.render();
  }
</script>