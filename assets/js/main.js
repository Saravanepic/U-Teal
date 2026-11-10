/* ========================================================================
   Page scripts (mockup only — Elementor handles these natively)
   1. Mobile menu toggle
   2. Developer notes: floating toggle (+ ?notes=1), remembered per browser
   3. Dynamic copyright year
   ======================================================================== */
(function () {
  // 1. Mobile menu toggle (below 1000px)
  var header = document.querySelector(".site-header");
  var toggle = document.querySelector(".menu-toggle");
  if (header && toggle) {
    toggle.addEventListener("click", function () {
      var open = header.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", String(open));
      toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    });
  }

  // 2. Developer notes toggle (only on pages that have .dev-note blocks)
  if (document.querySelector(".dev-note")) {
    var KEY = "uteal-dev-notes";
    var param = new URLSearchParams(location.search).get("notes");
    var saved = null;
    try {
      saved = localStorage.getItem(KEY);
    } catch (e) {}

    var on = param === "1" || (param !== "0" && saved === "1");

    var btn = document.createElement("button");
    btn.type = "button";
    btn.className = "dev-toggle";
    btn.innerHTML =
      '<span class="dev-toggle__switch" aria-hidden="true"></span>' +
      "<span>Developer notes</span>";

    function apply(state) {
      document.body.classList.toggle("show-notes", state);
      btn.setAttribute("aria-pressed", String(state));
      try {
        localStorage.setItem(KEY, state ? "1" : "0");
      } catch (e) {}
    }

    btn.addEventListener("click", function () {
      on = !on;
      apply(on);
    });

    document.body.appendChild(btn);
    apply(on);
  }

  // 3. Dynamic copyright year
  document.querySelectorAll(".js-year").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
})();
