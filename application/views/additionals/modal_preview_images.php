<div class="modal fade" id="modalPreviewImages" tabindex="-1" aria-labelledby="modalPreviewImagesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPreviewImagesLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="img_preview" width="100%">
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<script>
  function showModalPreviewImages(src, title = 'Preview Images') {
    $('#img_preview').attr('src', src)
    $('#modalPreviewImages').modal('show');
    $('#modalPreviewImagesLabel').text(title)
  }
</script>