<?php
if (in_array('selectCabang', $data)) { ?>
  <script>
    $(document).ready(function() {
      $("#id_cabang").select2({
        theme: 'bootstrap4',
        // minimumInputLength: 2,
        ajax: {
          url: "<?= site_url('api/private/cabang/selectCabang') ?>",
          type: "POST",
          dataType: 'json',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term, // search term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    });
  </script>
<?php } ?>