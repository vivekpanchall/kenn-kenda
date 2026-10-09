(function () {
  const animated = document.querySelectorAll("[data-animate]");
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const heroVideo = document.querySelector("[data-hero-video]");
  const heroAudioToggle = document.querySelector("[data-hero-audio-toggle]");

  if (heroVideo && heroAudioToggle && heroAudioToggle.dataset.heroAudioToggleBound !== "true") {
    const syncHeroAudioToggle = () => {
      const isMuted = heroVideo.muted;
      const label = isMuted ? "Listen" : "Mute Audio";

      heroAudioToggle.textContent = label;
      heroAudioToggle.setAttribute("aria-label", label);
      heroAudioToggle.setAttribute("title", label);
      heroAudioToggle.setAttribute("aria-pressed", String(!isMuted));
    };

    const toggleHeroAudio = () => {
      if (!heroVideo) {
        return;
      }

      heroVideo.muted = !heroVideo.muted;
      syncHeroAudioToggle();
    };

    heroAudioToggle.addEventListener("click", toggleHeroAudio);
    heroVideo.addEventListener("volumechange", syncHeroAudioToggle);
    heroVideo.addEventListener("error", () => {
      heroVideo.muted = true;
      syncHeroAudioToggle();
    });

    heroAudioToggle.dataset.heroAudioToggleBound = "true";
    syncHeroAudioToggle();
  }

  if (heroVideo && reduceMotion) {
    heroVideo.removeAttribute("autoplay");
    heroVideo.pause();
    heroVideo.muted = true;
    if (heroAudioToggle) {
      const toggleText = heroAudioToggle.querySelector(".hero__scroll-hint-text");
      if (toggleText) {
        toggleText.textContent = "Listen";
      }
      heroAudioToggle.setAttribute("aria-label", "Listen");
      heroAudioToggle.setAttribute("title", "Listen");
      heroAudioToggle.setAttribute("aria-pressed", "false");
    }
  }

  if (reduceMotion) {
    animated.forEach((el) => el.classList.add("is-visible"));
    return;
  }

  if ("IntersectionObserver" in window && animated.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
    );
    animated.forEach((el) => observer.observe(el));
  } else {
    animated.forEach((el) => el.classList.add("is-visible"));
  }

  document.querySelectorAll("[data-priority-toggle]").forEach(function (button) {
    button.addEventListener("click", function () {

          const panelId = button.getAttribute("aria-controls");

          if (!panelId) {
              return;
          }

          const panel = document.getElementById(panelId);

          if (!panel) {
              return;
          }

          const expanded = button.getAttribute("aria-expanded") === "true";

          button.setAttribute(
              "aria-expanded",
              expanded ? "false" : "true"
          );

          panel.hidden = expanded;
    });

    button.addEventListener("keydown", function (event) {

          if (event.key === "Enter" || event.key === " ") {

              event.preventDefault();

              button.click();
          }
    });
  });


  document.querySelectorAll("[data-slide04-toggle]").forEach(function (button) {

      button.addEventListener("click", function () {

          const panelId = button.getAttribute("aria-controls");

          if (!panelId) {
              return;
          }

          const panel = document.getElementById(panelId);

          if (!panel) {
              return;
          }

          const expanded = button.getAttribute("aria-expanded") === "true";

          button.setAttribute(
              "aria-expanded",
              expanded ? "false" : "true"
          );

          panel.hidden = expanded;
      });

      button.addEventListener("keydown", function (event) {

          if (event.key === "Enter" || event.key === " ") {

              event.preventDefault();

              button.click();
          }
      });
  });

  document.querySelectorAll("[data-slide07-toggle]").forEach(function (button) {

      button.addEventListener("click", function () {

          const panelId = button.getAttribute("aria-controls");

          if (!panelId) {
              return;
          }

          const panel = document.getElementById(panelId);

          if (!panel) {
              return;
          }

          const expanded = button.getAttribute("aria-expanded") === "true";

          button.setAttribute(
              "aria-expanded",
              expanded ? "false" : "true"
          );

          panel.hidden = expanded;
      });

      button.addEventListener("keydown", function (event) {

          if (event.key === "Enter" || event.key === " ") {

              event.preventDefault();

              button.click();
          }
      });

  });
})();
