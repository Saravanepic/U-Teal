/* ========================================================================
   Page scripts (mockup only — Elementor handles these natively)
   ======================================================================== */
(function () {
  // 1. Mobile menu toggle (below 1000px)
  var header = document.querySelector(".site-header");
  var toggle = document.querySelector(".menu-toggle");
  toggle.addEventListener("click", function () {
    var open = header.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", String(open));
    toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
  });

  // 2. Elementor notes overlay: add ?notes=1 to the URL
  if (new URLSearchParams(location.search).get("notes") === "1") {
    document.body.classList.add("show-notes");
  }

  // 3. Dynamic copyright year
  document.querySelectorAll(".js-year").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
})();
