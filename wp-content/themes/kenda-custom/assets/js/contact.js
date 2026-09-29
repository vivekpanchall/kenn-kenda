(function () {
  if (typeof kendaContact === "undefined") return;

  const contactForm = document.getElementById("contact-form");
  const newsletterForm = document.getElementById("newsletter-form");

  async function postForm(action, form) {
    const status = form.querySelector("[data-form-status], [data-newsletter-status]");
    const submit = form.querySelector('[type="submit"]');
    if (submit) submit.disabled = true;

    try {
      const body = new FormData(form);
      body.append("action", action);
      body.append("nonce", kendaContact.nonce);
      const response = await fetch(kendaContact.ajaxUrl, {
        method: "POST",
        body,
        credentials: "same-origin",
      });
      const data = await response.json();
      if (status) {
        status.hidden = false;
        status.textContent = data.data?.message || data.message || "";
        status.style.color = response.ok ? "#23467a" : "#a42b2a";
      }
      if (response.ok) form.reset();
    } catch {
      if (status) {
        status.hidden = false;
        status.textContent = "Unable to send right now. Please call or email the campaign.";
        status.style.color = "#a42b2a";
      }
    } finally {
      if (submit) submit.disabled = false;
    }
  }

  if (contactForm) {
    contactForm.addEventListener("submit", (event) => {
      event.preventDefault();
      postForm("kenda_contact", contactForm);
    });
  }

  if (newsletterForm) {
    newsletterForm.addEventListener("submit", (event) => {
      event.preventDefault();
      postForm("kenda_newsletter", newsletterForm);
    });
  }
})();
