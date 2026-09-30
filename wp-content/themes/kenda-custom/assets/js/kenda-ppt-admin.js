jQuery(document).ready(function ($) {

    let mediaFrame = null;

    $('.kenda-select-card-image').on('click', function (event) {

        event.preventDefault();

        const button = $(this);
        const cardIndex = button.data('card-index');

        mediaFrame = wp.media({
            title: 'Select Card Image',
            button: {
                text: 'Use This Image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        mediaFrame.on('select', function () {

            const attachment = mediaFrame
                .state()
                .get('selection')
                .first()
                .toJSON();

            $('#kenda-card-image-' + cardIndex).val(attachment.id);

            let imageUrl = attachment.url;

            if (attachment.sizes && attachment.sizes.medium) {
                imageUrl = attachment.sizes.medium.url;
            }

            $('#kenda-card-image-preview-' + cardIndex).html(
                '<img src="' +
                imageUrl +
                '" style="max-width:150px;height:auto;display:block;" />'
            );

            $('.kenda-remove-card-image[data-card-index="' + cardIndex + '"]')
                .show();
        });

        mediaFrame.open();
    });

    $('.kenda-remove-card-image').on('click', function (event) {

        event.preventDefault();

        const button = $(this);
        const cardIndex = button.data('card-index');

        $('#kenda-card-image-' + cardIndex).val('');

        $('#kenda-card-image-preview-' + cardIndex).html('');

        button.hide();
    });

});