/**
 * Homepage gallery slideshow — auto-advances every 3 seconds.
 */
(function () {
  var AUTO_MS = 3000;

  function initGallery(root) {
    var slides = Array.prototype.slice.call(
      root.querySelectorAll("[data-gallery-slide]")
    );
    if (slides.length < 2) {
      return;
    }

    var dots = Array.prototype.slice.call(
      root.querySelectorAll("[data-gallery-dot]")
    );
    var prev = root.querySelector("[data-gallery-prev]");
    var next = root.querySelector("[data-gallery-next]");
    var index = 0;
    var timer = null;
    var started = slides.findIndex(function (slide) {
      return slide.classList.contains("is-active");
    });
    if (started > 0) {
      index = started;
    }

    function pauseAllVideos() {
      slides.forEach(function (slide) {
        var video = slide.querySelector("video");
        if (video) {
          try {
            video.pause();
          } catch (e) {
            /* ignore */
          }
        }
      });
    }

    function goTo(nextIndex) {
      index = ((nextIndex % slides.length) + slides.length) % slides.length;

      slides.forEach(function (slide, i) {
        var active = i === index;
        slide.classList.toggle("is-active", active);
        if (active) {
          slide.removeAttribute("hidden");
          slide.setAttribute("aria-hidden", "false");
        } else {
          slide.setAttribute("hidden", "");
          slide.setAttribute("aria-hidden", "true");
        }
      });

      dots.forEach(function (dot, i) {
        var active = i === index;
        dot.classList.toggle("is-active", active);
        dot.setAttribute("aria-selected", active ? "true" : "false");
      });

      pauseAllVideos();
    }

    function stopAutoplay() {
      if (timer !== null) {
        window.clearTimeout(timer);
        timer = null;
      }
    }

    function scheduleNext() {
      stopAutoplay();
      timer = window.setTimeout(function () {
        goTo(index + 1);
        scheduleNext();
      }, AUTO_MS);
    }

    function startAutoplay() {
      scheduleNext();
    }

    if (prev) {
      prev.addEventListener("click", function (event) {
        event.preventDefault();
        goTo(index - 1);
        startAutoplay();
      });
    }

    if (next) {
      next.addEventListener("click", function (event) {
        event.preventDefault();
        goTo(index + 1);
        startAutoplay();
      });
    }

    dots.forEach(function (dot) {
      dot.addEventListener("click", function (event) {
        event.preventDefault();
        var target = parseInt(dot.getAttribute("data-gallery-dot") || "0", 10);
        if (!isNaN(target)) {
          goTo(target);
          startAutoplay();
        }
      });
    });

    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        stopAutoplay();
      } else {
        startAutoplay();
      }
    });

    goTo(index);
    startAutoplay();
  }

  function boot() {
    var galleries = document.querySelectorAll("[data-k-gallery]");
    for (var i = 0; i < galleries.length; i++) {
      initGallery(galleries[i]);
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
