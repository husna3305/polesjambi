<?php
if (in_array('selectMerkMobil', $data)) { ?>
  <script>
    $(document).ready(function() {
      $("#id_merk_mobil").select2({
        theme: 'bootstrap4',
        // minimumInputLength: 2,
        ajax: {
          url: "<?= site_url('api/private/mobil/selectMerkMobil') ?>",
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

<?php
if (in_array('selectJenisMobil', $data)) { ?>
  <script>
    $(document).ready(function() {
      $("#id_jenis_mobil").select2({
        theme: 'bootstrap4',
        // minimumInputLength: 2,
        ajax: {
          url: "<?= site_url('api/private/mobil/selectJenisMobil') ?>",
          type: "POST",
          dataType: 'json',
          delay: 100,
          data: function(params) {
            return {
              id_merk_mobil: $('#id_merk_mobil').val(),
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