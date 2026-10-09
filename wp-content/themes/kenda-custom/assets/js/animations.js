(function () {
  const animated = document.querySelectorAll("[data-animate]");
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const heroVideo = document.querySelector("[data-hero-video]");
  const heroVideoToggle = document.querySelector("[data-hero-video-toggle]");

  if (heroVideo && heroVideoToggle && heroVideoToggle.dataset.heroVideoToggleBound !== "true") {
    const syncHeroVideoToggle = () => {
      const isPaused = heroVideo.paused || heroVideo.ended;
      const label = isPaused ? "Play background video" : "Pause background video";

      heroVideoToggle.classList.toggle("is-paused", isPaused);
      heroVideoToggle.setAttribute("aria-label", label);
      heroVideoToggle.setAttribute("title", label);
    };

    const toggleHeroVideo = () => {
      if (!heroVideo) {
        return;
      }

      if (heroVideo.paused || heroVideo.ended) {
        heroVideo.play().catch(() => {
          heroVideoToggle.disabled = true;
          heroVideoToggle.setAttribute("aria-label", "Background video unavailable");
          heroVideoToggle.setAttribute("title", "Background video unavailable");
        });
        return;
      }

      heroVideo.pause();
    };

    heroVideoToggle.addEventListener("click", toggleHeroVideo);
    heroVideo.addEventListener("play", syncHeroVideoToggle);
    heroVideo.addEventListener("pause", syncHeroVideoToggle);
    heroVideo.addEventListener("ended", syncHeroVideoToggle);
    heroVideo.addEventListener("error", () => {
      heroVideoToggle.disabled = true;
      heroVideoToggle.classList.add("is-disabled");
      heroVideoToggle.setAttribute("aria-label", "Background video unavailable");
      heroVideoToggle.setAttribute("title", "Background video unavailable");
    });

    heroVideoToggle.dataset.heroVideoToggleBound = "true";
    syncHeroVideoToggle();
  }

  if (heroVideo && reduceMotion) {
    heroVideo.removeAttribute("autoplay");
    heroVideo.pause();
    if (heroVideoToggle) {
      heroVideoToggle.classList.add("is-paused");
      heroVideoToggle.setAttribute("aria-label", "Play background video");
      heroVideoToggle.setAttribute("title", "Play background video");
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
