# U-teal training call · 25 Nov 2026 · 60 min

Run sheet for Saravan. Nadja's questions marked **[Session]** are covered here in order; the **[Email]** ones are already answered in the PDF "U-teal – answers to your training questions". Numbers in brackets = her question numbers.

## Before the call (15 min earlier)

- [ ] Log in to **u-teal.com/wp-admin**, hPanel, Brevo and Porkbun in separate tabs (only what you will show).
- [ ] Make a fresh backup: **hPanel → Backups → Generate new backup** (you will also show this in Q46).
- [ ] Prepare a practice page: **Pages → hover "About me" → Clone** → rename the copy to "Training sandbox", leave it as **Draft**. All live editing happens on this copy, never on a live page.
- [ ] Open both PDFs she has: the manual "U-teal website – how to edit your site" and the answers PDF.
- [ ] Have Matomo open once so it is loaded (Matomo Analytics → Summary).
- [ ] Start screen sharing, close private tabs and the credentials file.

## 0:00 – 0:03 · Start

- Start the **recording** (she asked to record).
- Agenda in one sentence: tour → editing → menus → content → SEO → languages → landing pages → stats, backups, security.
- Ask: "Anything urgent since yesterday?" (also: did the contact-form test from 24 Nov reach your inbox?)

## 0:03 – 0:10 · Tour: where things are (6, 43, 57)

- Dashboard left menu: Pages, Posts, Case studies, Media, Templates, Elementor, Languages, Yoast SEO, Matomo, LiteSpeed Cache, Brevo, Snippets (do not touch).
- Admin bar on the live site: **Edit with Elementor** (page / header / footer) and **LiteSpeed Cache → Purge All**.
- Golden rule: **English and German are separate pages** (manual section 1 table).
- **Header and footer (6):** Templates → Theme Builder → Header / Footer; "Header" + "Header – DE", "Footer" + "Footer – DE".
- **Legal pages (43):** Pages → Legal notice, Privacy policy, Impressum, Datenschutz. Plain WordPress editor, not Elementor. Every footer links its own language's legal pages.
- **Favicon (57):** Settings → General → Site Icon → change image → Save.

## 0:10 – 0:22 · Editing a page (8, 9, 11, 16, 25)

Work in the **Training sandbox** draft.

- Open with Elementor. Show: click a text, edit in the left panel, bold/link; button text + link; Structure panel (layers icon) and layer names.
- **Picture (16):** click image → Media Library → upload → **Alternative text** in the Media Library. Size: JPG/WebP, 1600–2000 px wide, under 500 KB. Alt texts are shared by both languages. No compression plugin active yet (LiteSpeed image optimisation is off).
- **PDF (25):** Media → Add New → upload PDF → copy its URL → use it as a button/text link. The browser opens it; no external viewer.
- **Hide / show (11):**
  - Part of a page: select it → Style → Display **None** (show the hidden "S08 News (HIDDEN)" on the English Home as example).
  - Mobile only / desktop only: our classes `ut-mobile-only` / `ut-desktop-only` (show on the second picture of a service page), or Display None in the **mobile/desktop breakpoint** view.
  - Whole page: WordPress edit screen → Status/Visibility box: **Draft**, **Private** (only logged-in admins), **Password protected**.
- **Global styles (8):** Elementor V4 **Variables** (colours, fonts: teal palette, Manrope) and **Classes** (buttons `ut-btn…`, cards, sections). Change a variable/class once → changes everywhere. Warn: change global classes carefully, they affect all pages in both languages.
- **Reusable parts (9):** Header/footer templates; global classes; Templates → Saved Templates. Clone (Yoast Duplicate Post) for whole pages.
- **Publish / undo:** Publish button; History → Revisions → Apply. Delete the sandbox at the end (or keep it as a draft for practice).

## 0:22 – 0:27 · Menus (7)

- Appearance → Menus → choose **Main menu** (EN) / **Hauptmenü DE**.
- Live: drag an item, rename (Navigation Label), add a page (EN: tick under Pages; DE: Custom Links with `/de/…`), Save Menu. Then undo it.
- Point out the **Languages** item (EN/DE switch) — keep it last.
- Footer service lists = menus "Footer services" / "Footer Angebote DE".

## 0:27 – 0:35 · Content: case studies and blog (10, 19, 20, 21, 27, 28, 30)

- **Case study (19, 20):** Case studies → Add New → walk the fields (manual section 5 table): Intro, Approach heading, main text, quote, Service page link, Excerpt, Featured image, Case group, **Order** (lower = first). Do not publish. German version: **+** in the DE column.
- Showing a case on a service page (19): edit the service page in Elementor → card button link `/case-studies/<slug>/`.
- **Publications (21):** Case studies page (`/case-studies/`) in Elementor → "S05 Publications" → duplicate one item (P1…P12) → change topic/title/meta; link to an external URL or to an uploaded PDF.
- **Blog post (27):** Posts → Add New → title, text blocks, Featured image, Excerpt, category **Insights**, tags optional. Translation: the blog is English only today; a German post would be created with **+** in the DE column.
- **Order / pin / date (28):** list is newest first by date → change the **publish date** in the post's Status box to reorder. "Stick to the top" exists but our blog grid sorts by date, so the date is the reliable way.
- **Home page posts (10):** the hidden News section shows the 3 newest posts automatically; to bring the blog back: manual section 5 "Bring the blog back".
- **Blog → Brevo newsletter (30):** copy the post's text and image into a Brevo campaign and link "Read more" to the post. (Brevo can also build from an RSS feed if she later wants automation — check in Brevo before promising.)

## 0:35 – 0:41 · SEO (12, 13, 17)

- **Titles and descriptions (12):** open a page in the WordPress edit screen → Yoast box → SEO title + meta description; German page in German. Site title/tagline: Settings → General (English); German tagline is set in a snippet → ask Saravan.
- **Slugs (13):** page sidebar → URL/Slug. Old page addresses are **not** redirected automatically → only change slugs of live pages together with a redirect (install "Redirection" when needed; offer to do it).
- **LinkedIn preview (17):** Yoast box → **Social** tab → image (1200 × 630 px) + title + description. Test by pasting the URL in LinkedIn's Post Inspector.

## 0:41 – 0:48 · Languages (33, and 23)

- Explain with manual section 7 "How Polylang works": one page per language, language columns (tick / pencil / **+**), `/de/` addresses, header/footer/menus per language, Languages → Translations for small texts.
- Walk the 7 steps for a new language on screen (**Languages → Languages**) but **do not add Spanish/Italian live** unless she wants it now — adding a language changes the admin columns everywhere.
- **Stand-alone page in a new language (23):** every page needs a Polylang language → add Italian/Catalan as a language, create just that one page, do not translate the rest; the switcher hides languages without a translation. If it is a campaign page: Yoast → Advanced → "Allow search engines to show this page?" → **No** (noindex).

## 0:48 – 0:53 · Landing pages (22, 24, 26)

- **New landing page (22):** Clone a page (Pages → hover → **Clone**) → rename, new slug, edit in Elementor, set language, publish, add to a menu only if wanted.
- **Reduced header/footer (24):** page settings (gear icon in Elementor) → Page Layout **Elementor Canvas** = no header/footer; or a separate simple header template with display conditions (Saravan can build).
- **Brevo forms (26):** Brevo → Contacts → Forms → build form → switch on the **consent checkbox** and **double opt-in** yourself (not automatic) → embed code in an Elementor HTML widget. Note: an embedded Brevo form loads from Brevo's servers (EU, France) → add a line to the privacy policy before using it. The footer newsletter already uses Brevo without loading anything.

## 0:53 – 0:58 · Stats, backups, cache (40, 41, 46, 49)

- **Matomo (40):** Matomo Analytics → Summary / Reporting. It runs on her own hosting, not Matomo Cloud. Visitors → Visits Log.
- **Data retention (41):** raw data deleted after **180 days**; IP shortened by 2 bytes; Do Not Track respected; no cookies. Where to change: Matomo Analytics → Reporting → Administration (gear) → Privacy → **Anonymize data** / **Delete old raw data**.
- **Backups (46):** hPanel → Backups → show the list, **Generate new backup**, and where **Restore** is (do not restore live). UpdraftPlus exists as an extra.
- **Cache (49):** LiteSpeed Cache → Purge All after changes that do not show; Elementor → Tools → Clear Files & Data after Elementor updates.

## 0:58 – 1:00 · Security and wrap-up

- If time allows, live (otherwise offer a 15-min follow-up):
  1. Users → Add New → her own user name, role **Administrator** → log in with it → delete "admin" and attribute content to the new user.
  2. Plugins → Add New → **Two Factor** → set up with an authenticator app.
- Recap what she can now do alone; point to the manual and the answers PDF.
- Free bug-fix support until **8 Dec 2026**; Saravan keeps access unless she prefers to remove it.
- Stop the recording, send her the recording link.

## After the call

- [ ] Send the recording.
- [ ] Remove test contacts from Brevo lists "Newsletter EN" / "Newsletter DE" (Saravan's test addresses).
- [ ] Remove this Mac's IPs from Brevo → Security → Authorised IPs (keep the server's 82.198.229.121 and the Hostinger IPv6).
- [ ] Add Nadja's Google account as owner in Google Search Console.
- [ ] Optional: switch off unused plugins (AI Provider for Anthropic, Child Theme Configurator); install Redirection if she plans slug changes.
- [ ] Note anything she asked that is not in the manual and add it to the manual.
