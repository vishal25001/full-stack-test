$(document).ready(function() {
    // Tab click handler
    $('#tabMenu a').click(function(e) {
        e.preventDefault();
        const tabId = $(this).data('tab');
        $('#tabMenu a').removeClass('active');
        $(this).addClass('active');
        $('.carousel-item').removeClass('active');
        $(`.carousel-item[data-tab="${tabId}"]`).first().addClass('active');
        updateImagePreview();
    });

    // Slider change handler
    $('#slider, .mobile-slider').on('slid.bs.carousel', function() {
        updateImagePreview();
    });

    // Update image preview in column 3
    function updateImagePreview() {
        const activeSlide = $('.carousel-item.active');
        const tabId = activeSlide.data('tab');
        $.getJSON('get_slide.php?tab_id=' + tabId, function(data) {
            $('#image-preview img').attr('src', 'uploads/' + data.image);
        });
    }

    // Edit slide
    $('.edit-slide').click(function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const description = $(this).data('description');
        const image = $(this).data('image');
        const tab_id = $(this).data('tab_id');

        $('#slide_id').val(id);
        $('input[name="title"]').val(title);
        $('textarea[name="description"]').val(description);
        $('#old_image').val(image);
        $('select[name="tab_id"]').val(tab_id);
        $('button[name="create"]').hide();
        $('button[name="update"]').show();
    });
});