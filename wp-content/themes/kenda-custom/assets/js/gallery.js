/**
 * Homepage gallery slideshow.
 */
(function () {
  function initGallery(root) {
    const slides = Array.from(root.querySelectorAll("[data-gallery-slide]"));
    if (slides.length < 2) {
      return;
    }

    const dots = Array.from(root.querySelectorAll("[data-gallery-dot]"));
    const prev = root.querySelector("[data-gallery-prev]");
    const next = root.querySelector("[data-gallery-next]");
    let index = Math.max(
      0,
      slides.findIndex(function (slide) {
        return slide.classList.contains("is-active");
      })
    );
    let timer = null;
    const AUTO_MS = 6500;

    function pauseVideos(exceptIndex) {
      slides.forEach(function (slide, i) {
        const video = slide.querySelector("video");
        if (!video) {
          return;
        }
        if (i !== exceptIndex) {
          video.pause();
        }
      });
    }

    function show(nextIndex) {
      if (!slides.length) {
        return;
      }

      index = (nextIndex + slides.length) % slides.length;

      slides.forEach(function (slide, i) {
        const active = i === index;
        slide.classList.toggle("is-active", active);
        if (active) {
          slide.removeAttribute("hidden");
        } else {
          slide.setAttribute("hidden", "");
        }
      });

      dots.forEach(function (dot, i) {
        const active = i === index;
        dot.classList.toggle("is-active", active);
        dot.setAttribute("aria-selected", active ? "true" : "false");
      });

      pauseVideos(index);
      restartTimer();
    }

    function restartTimer() {
      if (timer) {
        window.clearInterval(timer);
      }

      const activeSlide = slides[index];
      const hasVideo = !!(activeSlide && activeSlide.querySelector("video"));
      if (hasVideo) {
        return;
      }

      timer = window.setInterval(function () {
        show(index + 1);
      }, AUTO_MS);
    }

    if (prev) {
      prev.addEventListener("click", function () {
        show(index - 1);
      });
    }

    if (next) {
      next.addEventListener("click", function () {
        show(index + 1);
      });
    }

    dots.forEach(function (dot) {
      dot.addEventListener("click", function () {
        const target = parseInt(dot.getAttribute("data-gallery-dot") || "0", 10);
        show(target);
      });
    });

    root.addEventListener("mouseenter", function () {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    });

    root.addEventListener("mouseleave", function () {
      restartTimer();
    });

    document.addEventListener("visibilitychange", function () {
      if (document.hidden && timer) {
        window.clearInterval(timer);
        timer = null;
      } else if (!document.hidden) {
        restartTimer();
      }
    });

    show(index);
  }

  document.querySelectorAll("[data-k-gallery]").forEach(initGallery);
})();
