(function () {
  const animated = document.querySelectorAll("[data-animate]");
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const heroVideo = document.querySelector("[data-hero-video]");
  if (heroVideo && reduceMotion) {
    heroVideo.removeAttribute("autoplay");
    heroVideo.pause();
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

  document.querySelectorAll("[data-priority-toggle]").forEach((button) => {
    button.addEventListener("click", () => {
      const panel = document.getElementById(button.getAttribute("aria-controls") || "");
      if (!panel) return;
      const expanded = button.getAttribute("aria-expanded") === "true";
      button.setAttribute("aria-expanded", expanded ? "false" : "true");
      panel.hidden = expanded;
    });
    button.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        button.click();
      }
    });
  });
})();
