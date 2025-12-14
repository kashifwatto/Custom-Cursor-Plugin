jQuery(document).ready(function ($) {

    let mediaUploader;

    $('#ccp_upload_button').on('click', function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Select Cursor Image',
            button: { text: 'Use this image' },
            library: { type: ['image/png', 'image/svg+xml'] },
            multiple: false
        });

        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();

            // Save URL in hidden input
            $('#ccp_cursor_image').val(attachment.url);

            // Update preview
            $('#ccp-image-preview').html(
                '<img src="' + attachment.url + '" style="max-width:80px; height:auto;">'
            );

            // Change button text
            $('#ccp_upload_button').text('Change Image');
        });

        mediaUploader.open();
    });

});
