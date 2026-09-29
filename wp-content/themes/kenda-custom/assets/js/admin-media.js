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
})(jQuery);
