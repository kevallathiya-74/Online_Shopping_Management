<script>
    function previewImage(url) {
        var img = document.getElementById('imagePreviewImg');
        var placeholder = document.getElementById('imagePreviewPlaceholder');
        var previewBox = document.getElementById('imagePreviewBox');
        var status = document.getElementById('imageStatus');

        if (!img || !placeholder || !previewBox || !status) {
            return;
        }

        if (!url || url.trim() === '') {
            img.classList.add('d-none');
            placeholder.classList.remove('d-none');
            previewBox.classList.remove('preview-valid', 'preview-invalid');
            status.innerHTML = '';
            return;
        }

        status.innerHTML = '<small class="text-info"><i class="fas fa-spinner fa-spin"></i> Loading image...</small>';

        img.onload = function () {
            img.classList.remove('d-none');
            placeholder.classList.add('d-none');
            previewBox.classList.remove('preview-invalid');
            previewBox.classList.add('preview-valid');
            status.innerHTML = '<small class="text-success"><i class="fas fa-check-circle"></i> Image loaded successfully.</small>';
        };

        img.onerror = function () {
            img.classList.add('d-none');
            placeholder.classList.remove('d-none');
            previewBox.classList.remove('preview-valid');
            previewBox.classList.add('preview-invalid');
            status.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> Could not load this URL. Use a direct image link.</small>';
        };

        img.src = url;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var imageInput = document.getElementById('image');
        if (imageInput && imageInput.value) {
            previewImage(imageInput.value);
        }
    });
</script>