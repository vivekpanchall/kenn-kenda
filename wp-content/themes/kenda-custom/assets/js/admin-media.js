(function ($) {
  function bindField($field) {
    const $input = $field.find(".kenda-media-id");
    const $preview = $field.find(".kenda-media-preview");

    $field.find(".kenda-media-select").on("click", function (event) {
      event.preventDefault();
      const frame = wp.media({
        title: "Select media",
        button: { text: "Use this file" },
        multiple: false,
      });
      frame.on("select", function () {
        const attachment = frame.state().get("selection").first().toJSON();
        $input.val(attachment.id);
        const img = attachment.type === "image" ? attachment.url : attachment.icon;
        $preview.html('<img src="' + img + '" style="max-width:120px;height:auto;" />');
      });
      frame.open();
    });

    $field.find(".kenda-media-remove").on("click", function (event) {
      event.preventDefault();
      $input.val("");
      $preview.empty();
    });
  }

  $(".kenda-media-field").each(function () {
    bindField($(this));
  });

  function bindGalleryField($field) {
    const $input = $field.find(".kenda-gallery-ids");
    const $preview = $field.find(".kenda-gallery-preview");
    const $clear = $field.find(".kenda-gallery-clear");

    function renderPreview(attachments) {
      $preview.empty();
      attachments.forEach(function (attachment) {
        let thumb = attachment.url;
        let label = "Image";

        if (attachment.type === "video") {
          label = "Video";
          thumb =
            (attachment.image && attachment.image.src) ||
            (attachment.icon) ||
            thumb;
        } else if (attachment.sizes && attachment.sizes.thumbnail) {
          thumb = attachment.sizes.thumbnail.url;
        }

        $preview.append(
          '<span class="kenda-gallery-preview__item" style="display:inline-block;border:1px solid #ccd0d4;border-radius:4px;padding:4px;background:#fff;">' +
            '<img src="' +
            thumb +
            '" alt="" style="display:block;width:72px;height:72px;object-fit:cover;" />' +
            '<small style="display:block;margin-top:4px;text-align:center;">' +
            label +
            "</small></span>"
        );
      });
    }

    $field.find(".kenda-gallery-select").on("click", function (event) {
      event.preventDefault();

      const frame = wp.media({
        title: "Select gallery photos and videos",
        button: { text: "Add to gallery" },
        multiple: true,
        library: {
          type: ["image", "video"],
        },
      });

      const existing = String($input.val() || "")
        .split(",")
        .map(function (id) {
          return parseInt(id, 10);
        })
        .filter(Boolean);

      frame.on("open", function () {
        const selection = frame.state().get("selection");
        existing.forEach(function (id) {
          const attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment);
        });
      });

      frame.on("select", function () {
        const selection = frame.state().get("selection").toJSON();
        const ids = selection.map(function (item) {
          return item.id;
        });
        $input.val(ids.join(","));
        renderPreview(selection);
        if (ids.length) {
          $clear.show();
        } else {
          $clear.hide();
        }
      });

      frame.open();
    });

    $clear.on("click", function (event) {
      event.preventDefault();
      $input.val("");
      $preview.empty();
      $clear.hide();
    });
  }

  $(".kenda-gallery-field").each(function () {
    bindGalleryField($(this));
  });
})(jQuery);
