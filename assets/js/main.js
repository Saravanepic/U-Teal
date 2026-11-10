/* ========================================================================
   U-TEAL · Page scripts (mockup only — Elementor handles these natively)
   1. Mobile menu toggle
   2. Dropdowns (Services, language)
   3. Header border on scroll
   4. Floating "Let's talk": hide when the contact block is on screen
   5. Links to pages that don't exist yet (data-todo)
   6. Developer notes toggle (+ ?notes=1), remembered per browser
   7. SEO box: copy buttons + character counts (+ 7b heading structure)
   8. Dynamic copyright year
   9. Demo forms: show the success message after submit (data-demo-form)
   ======================================================================== */
(function () {
  var header = document.querySelector(".site-header");

  // 1. Mobile menu toggle (below 1000px)
  var toggle = document.querySelector(".menu-toggle");
  if (header && toggle) {
    toggle.addEventListener("click", function () {
      var open = header.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", String(open));
      toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    });
  }

  // 2. Dropdowns: click to open, click outside / Esc to close
  var dropdownBtns = document.querySelectorAll("[data-dropdown]");
  function closeAll(except) {
    dropdownBtns.forEach(function (b) {
      if (b === except) return;
      b.setAttribute("aria-expanded", "false");
      var m = document.getElementById(b.getAttribute("aria-controls"));
      if (m) m.classList.remove("is-open");
    });
  }
  dropdownBtns.forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.stopPropagation();
      var menu = document.getElementById(btn.getAttribute("aria-controls"));
      var open = btn.getAttribute("aria-expanded") !== "true";
      closeAll(btn);
      btn.setAttribute("aria-expanded", String(open));
      if (menu) menu.classList.toggle("is-open", open);
    });
  });
  document.addEventListener("click", function () { closeAll(); });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeAll();
  });

  // Close the mobile menu after choosing an in-page link
  document.querySelectorAll('.site-nav a[href^="#"]').forEach(function (a) {
    a.addEventListener("click", function () {
      if (a.getAttribute("href") === "#") return;
      header.classList.remove("is-open");
      if (toggle) toggle.setAttribute("aria-expanded", "false");
    });
  });

  // 3. Header border once the page is scrolled
  function onScroll() {
    if (header) header.classList.toggle("is-scrolled", window.scrollY > 8);
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  // 4. Floating "Let's talk": hide while the contact block / footer is visible
  var floatCta = document.querySelector(".float-cta");
  var targets = document.querySelectorAll("#get-started, .site-footer");
  if (floatCta && targets.length && "IntersectionObserver" in window) {
    var visible = new Set();
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) visible.add(en.target);
        else visible.delete(en.target);
      });
      floatCta.classList.toggle("is-hidden", visible.size > 0);
    }, { threshold: 0.15 });
    targets.forEach(function (t) { io.observe(t); });
  }

  // 5. Links to pages that aren't built yet: show the planned URL
  var toast;
  document.querySelectorAll("[data-todo]").forEach(function (a) {
    a.setAttribute("title", "Planned page: " + a.getAttribute("data-todo"));
    a.addEventListener("click", function (e) {
      e.preventDefault();
      if (!toast) {
        toast = document.createElement("div");
        toast.setAttribute("role", "status");
        toast.style.cssText =
          "position:fixed;left:50%;top:96px;z-index:200;transform:translateX(-50%);" +
          "padding:10px 16px;border-radius:8px;background:#02383e;color:#fff;" +
          "font:600 14px/1.4 Manrope,sans-serif;box-shadow:0 8px 24px rgba(0,0,0,.2);" +
          "transition:opacity .2s;max-width:90vw;text-align:center";
        document.body.appendChild(toast);
      }
      toast.textContent = "This page is not part of this draft yet (" + a.getAttribute("data-todo") + ")";
      toast.style.opacity = "1";
      clearTimeout(toast._t);
      toast._t = setTimeout(function () { toast.style.opacity = "0"; }, 2200);
    });
  });

  // 6. Developer notes toggle (only on pages that have notes)
  if (document.querySelector(".dev-note, .dev-only")) {
    var KEY = "uteal-dev-notes";
    var param = new URLSearchParams(location.search).get("notes");
    var saved = null;
    try { saved = localStorage.getItem(KEY); } catch (e) {}
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
      try { localStorage.setItem(KEY, state ? "1" : "0"); } catch (e) {}
    }
    btn.addEventListener("click", function () { on = !on; apply(on); });
    document.body.appendChild(btn);
    apply(on);
  }

  // 7. SEO box: character counts + copy buttons
  document.querySelectorAll(".seo-box dd[data-count]").forEach(function (dd) {
    var n = dd.textContent.trim().length;
    var c = document.createElement("span");
    c.className = "seo-box__count";
    c.textContent = n + " characters";
    dd.appendChild(c);
  });
  document.querySelectorAll(".seo-box .copy-btn").forEach(function (b) {
    b.addEventListener("click", function () {
      var dd = b.parentElement.previousElementSibling;
      var text = dd.firstChild ? dd.firstChild.textContent.trim() : dd.textContent.trim();
      function done() {
        b.textContent = "Copied";
        b.classList.add("is-copied");
        setTimeout(function () { b.textContent = "Copy"; b.classList.remove("is-copied"); }, 1500);
      }
      if (navigator.clipboard) navigator.clipboard.writeText(text).then(done, done);
      else done();
    });
  });

  // 7b. Heading structure: list every real heading in <main> (dev only)
  var outline = document.querySelector("[data-heading-outline]");
  if (outline) {
    document.querySelectorAll("main h1, main h2, main h3, main h4, main h5, main h6").forEach(function (h) {
      var lvl = h.tagName.toLowerCase();
      var li = document.createElement("li");
      li.className = "heading-outline__item heading-outline__item--" + lvl;
      li.innerHTML = '<span class="hl hl--' + lvl + '">' + lvl.toUpperCase() + "</span> ";
      li.appendChild(document.createTextNode(h.textContent.replace(/\s+/g, " ").trim()));
      if (h.hasAttribute("data-extra")) {
        var x = document.createElement("span");
        x.className = "hl-extra";
        x.textContent = "Extra";
        li.appendChild(x);
      }
      outline.appendChild(li);
    });
  }

  // 8. Dynamic copyright year
  document.querySelectorAll(".js-year").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });

  // 9. Demo forms (mockup only): after the browser's required-field check,
  //    hide the form and show its success message (Elementor does this itself)
  document.querySelectorAll("form[data-demo-form]").forEach(function (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var ok = document.getElementById(form.getAttribute("data-demo-form"));
      if (!ok) return;
      form.hidden = true;
      ok.hidden = false;
      ok.focus();
    });
  });
})();
