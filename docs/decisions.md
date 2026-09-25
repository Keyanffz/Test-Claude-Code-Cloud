# Decisions

Choices that were ambiguous in the brief, and why they went the way they did.

## Content & language

- **UI labels are English; seeded copy is English except the headline.** The headline
  ("Frontend Developer & Mahasiswa Teknik Informatika") was given verbatim, so it is
  seeded verbatim. Everything is editable in `/admin`.
- **No certificates are seeded.** Inventing credentials for a real person is worse than
  an empty section. The Certificates section hides itself until one exists, and section
  numbers (01, 02…) are computed at render time so hiding a section leaves no gap.
- **Seed email is `key@example.com`** and the LinkedIn/Instagram URLs are the platform
  home pages — placeholders to replace in `/admin`, not guesses at real accounts.
- **Experience dates are plausible placeholders.** The brief listed roles but not dates.

## Auth

- **Every user is an admin.** There is no public registration, and accounts only come
  from `php artisan admin:create`, so a role column would guard nothing. If a second
  kind of user ever appears, add a role then.
- **`admin:create` requires a 12+ character password** and prompts for it when
  `--password` is omitted, so it stays out of shell history.
- **The seeded `admin@example.com / password` account exists only in `local`.**

## Data model

- **Tech stack is a JSON column, not a tags table.** It is only ever read as a whole
  list and filtered in memory from the cached project list (a personal portfolio has
  tens of projects, not thousands). A pivot table would add two tables and a sync step
  for no query we actually run.
- **Profile and SEO settings are single-row tables** with a `current()` accessor and
  singleton routes (`/admin/profile/edit`), rather than a key/value settings table,
  so fields get real types, validation and casts.
- **Certificates are ordered by date, not drag-and-drop.** The brief lists drag ordering
  for projects, experience and skills; social links got it too because the generic
  reorder endpoint made it free. Certificates read naturally newest-first.
- **Admin project URLs use the slug** (same route key as the public site) so a link
  copied from either side is recognisable.

## Images & files

- **Every upload becomes WebP with fixed srcset widths** (`config/images.php`). Presets
  with a fixed aspect (thumbnails 4:3, photo 4:5, OG 1200×630) are cropped so templates
  can reserve exact space; gallery images keep their aspect and store their dimensions.
- **File cleanup lives on the models** (`HasStoredFiles`): changing or deleting a row
  removes the old file and its variants. Controllers never delete files, so no code
  path can forget to.
- **Image validation reads real dimensions** (min 200×200). Besides rejecting tiny
  images, this is what catches a non-image renamed to `.jpg`, which would otherwise
  pass the MIME check and crash the decoder.
- **Placeholders are generated, not downloaded.** The seeder draws neutral grid
  compositions with GD and pushes them through the real upload pipeline.

## Caching

- **Versioned cache keys instead of tags.** Tags need Redis/Memcached; the default
  store here is the database. All public reads are keyed `portfolio:v{n}:…` and any
  model save/delete bumps `n`. Bulk reorders bypass model events, so `saveOrder()`
  flushes explicitly.
- **`Portfolio` memoizes per request** because the layout and several partials read the
  same data. The flush also drops that memo, and controllers receive `Portfolio` via
  method injection (Laravel reuses controller instances across requests in tests and
  long-running workers, which would otherwise hold a stale memo).

## Frontend

- **The projects filter is server-side (`?stack=Laravel`).** Filter links are real,
  shareable URLs that work without JS; the canonical URL drops the query string.
- **Markdown is rendered on the server** for both the site and the admin preview tab
  (one renderer, raw HTML stripped) instead of shipping a JS markdown library.
- **Hero and page-title reveals are CSS, not GSAP.** The first version used GSAP
  SplitText, which meant the headline — the LCP element — stayed hidden until the JS
  chunk loaded (LCP 3.6s, Lighthouse perf 89). Words are now split in Blade
  (`<x-split-text>`) and revealed with CSS keyframes (same mask + translateY, same
  stagger), so they paint on the first frame. It also avoided SplitText putting
  `aria-label` on a `<p>`, which is an ARIA violation. Everything that happens on
  scroll or pointer input (reveals, parallax, marquee, counters, cursor preview,
  magnetic buttons) is still GSAP, one module per feature under
  `resources/js/animations/`, each loaded only when its targets exist.
- **Page transitions** use cross-document View Transitions where supported (CSS only)
  and an ink overlay wipe elsewhere. Both are disabled under reduced motion.
- **Fonts are self-hosted** via `@fontsource`, and the two faces above the fold are
  preloaded; before preloading, the Instrument Serif swap under the 30vw hero word
  caused a 0.2 CLS.
- **Skill "levels" do not exist.** Per the brief, skills are grouped by category only.

## Measured (local, `php artisan serve`, Lighthouse mobile)

| Page                  | Performance | Accessibility | Best practices |
| --------------------- | ----------- | ------------- | -------------- |
| `/`                   | 96          | 100           | 100            |
| `/projects`           | 93          | 100           | 100            |
| `/projects/pivactive` | 98          | 100           | 100            |

SEO scores locally are held down only by `robots.txt`, which deliberately disallows
everything outside `APP_ENV=production`. The remaining performance flags (text
compression, cache TTLs) are web-server settings; see the README's deploy section.
