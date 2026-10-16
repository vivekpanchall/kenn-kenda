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

jQuery(document).ready(function ($) {

    let slide14MediaFrame = null;

    $('.kenda-slide14-select-image').on('click', function (event) {

        event.preventDefault();

        slide14MediaFrame = wp.media({
            title: 'Select Thank You Image',
            button: {
                text: 'Use This Image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        slide14MediaFrame.on('select', function () {

            const attachment = slide14MediaFrame
                .state()
                .get('selection')
                .first()
                .toJSON();

            $('#kenda-slide14-image').val(attachment.id);

            let imageUrl = attachment.url;

            if (
                attachment.sizes &&
                attachment.sizes.medium
            ) {
                imageUrl = attachment.sizes.medium.url;
            }

            $('#kenda-slide14-image-preview').html(
                '<img src="' +
                imageUrl +
                '" style="max-width:300px;height:auto;display:block;" />'
            );

            $('.kenda-slide14-remove-image').show();
        });

        slide14MediaFrame.open();
    });


    $('.kenda-slide14-remove-image').on('click', function (event) {

        event.preventDefault();

        $('#kenda-slide14-image').val('');

        $('#kenda-slide14-image-preview').html('');

        $(this).hide();
    });

});

jQuery(document).ready(function ($) {

    let slide03HeadingMediaFrame = null;

    $('.kenda-slide03-select-heading-image').on('click', function (event) {

        event.preventDefault();

        slide03HeadingMediaFrame = wp.media({
            title: 'Select Heading Image',
            button: {
                text: 'Use This Image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        slide03HeadingMediaFrame.on('select', function () {

            const attachment = slide03HeadingMediaFrame
                .state()
                .get('selection')
                .first()
                .toJSON();

            $('#kenda-slide03-heading-image').val(attachment.id);

            let imageUrl = attachment.url;

            if (attachment.sizes && attachment.sizes.medium) {
                imageUrl = attachment.sizes.medium.url;
            }

            $('#kenda-slide03-heading-image-preview').html(
                '<img src="' +
                imageUrl +
                '" style="max-width:280px;height:auto;display:block;" />'
            );

            $('.kenda-slide03-remove-heading-image').show();
        });

        slide03HeadingMediaFrame.open();
    });

    $('.kenda-slide03-remove-heading-image').on('click', function (event) {

        event.preventDefault();

        $('#kenda-slide03-heading-image').val('');

        $('#kenda-slide03-heading-image-preview').html('');

        $(this).hide();
    });

});