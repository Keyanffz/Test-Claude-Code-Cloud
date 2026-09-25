# Design Brief

A personal portfolio should read like a well-set magazine spread, not a landing page.
The direction is **editorial / Swiss-inspired**: a strict grid, type doing the heavy
lifting, a restrained palette, and motion that behaves like a page turning, never like
confetti.

## Palette

Three roles only. Everything else is a tint of these via opacity or a derived line color.

| Token            | Light      | Dark       | Use                                               |
| ---------------- | ---------- | ---------- | ------------------------------------------------- |
| `--color-paper`  | `#F2F0EB`  | `#111110`  | Page background. Warm off-white / warm near-black. |
| `--color-ink`    | `#111110`  | `#ECEAE4`  | Body text, headlines, primary buttons.            |
| `--color-muted`  | `#6B6862`  | `#9A968E`  | Secondary text, labels. ≥ 4.5:1 on paper.          |
| `--color-line`   | `#D8D4CB`  | `#2A2926`  | 1px dividers, table rules, input borders.          |
| `--color-signal` | `#C2410C`  | `#FF6A3D`  | The accent. Used sparingly (see below).            |

The accent is an international-orange: it is a nod to Swiss signage and it has no
association with the purple/blue gradient that marks generic AI output. It shifts
lighter in dark mode so it keeps ≥ 4.5:1 contrast on both backgrounds.

**Accent budget** — the signal color appears only on:
the "open to work" status dot, the active filter, link underlines on hover, the
focus ring, and one italic word in the hero. If a screen has more than three orange
things on it, one of them is wrong.

No gradients, no glass, no blur, no drop shadows on cards. Depth comes from rules
(1px lines) and whitespace, not elevation.

## Typography

| Role     | Family              | Why                                                                                                                                                     |
| -------- | ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Display  | **Instrument Serif** | A condensed, high-contrast serif with a real italic. At 10–14vw it has the tension of a newspaper masthead; it gives the page a voice without novelty. |
| Text/UI  | **Geist** (variable) | Neutral grotesk with tight default spacing and good tabular figures; it stays out of the serif's way.                                                    |
| Labels   | **Geist Mono**       | Index numbers (01, 02…), years, section tags. Mono at small sizes signals "metadata" instantly.                                                         |

Why not Inter Tight: it is the default choice of every template in 2025, and it is
wider than Geist at the same size. Geist + Geist Mono share metrics, so labels and
body text align on the baseline without nudging.

All fonts are self-hosted through `@fontsource` (no third-party request, no layout
shift from late font swaps beyond `font-display: swap`).

Rules:
- Display headlines: `letter-spacing: -0.02em`, `line-height: 0.9`, never bold (the serif has one weight — that's the point).
- Body: 16–18px, `line-height: 1.55`, max 64ch.
- Labels: Geist Mono 11–12px, uppercase, `letter-spacing: 0.08em`.
- `font-feature-settings`: `"ss01", "cv11"` on Geist (single-storey a is off, straight-sided alternates on), `"tnum"` wherever numbers stack (years, counters, table columns).
- Italic Instrument Serif is the only emphasis device in headlines.

## Grid

- 12 columns, `max-width: 1440px`, outer margin `clamp(16px, 4vw, 56px)`, gutter 24px (16px under 768px).
- Mobile (375px): single column, labels sit above content.
- Section pattern: a mono label + index occupies columns 1–3, content occupies 4–12. This left "rail" is the signature of the layout and it is what makes it asymmetric.
- Horizontal 1px rules separate sections and list rows. No boxed cards on the public site.
- Nothing is centered by default. Text is ragged-right, aligned to the grid.

## Components

- **Section heading**: `(02)` mono index · uppercase mono label on the rail, large serif title in the content columns.
- **Project row**: index · title (serif, large) · role · year, a rule between rows. On desktop, hovering a row shows its thumbnail following the cursor.
- **Buttons**: rectangular with 2px radius, ink fill or 1px outline. Arrow icon slides 2px on hover.
- **Icons**: Lucide only, inline SVG, 1.5px stroke, 16/20px.
- **Focus**: 2px signal-colored outline with 3px offset on every interactive element.
- **Cursor**: `pointer` only on real links/buttons; the preview image uses `cursor: none` nowhere — we never hide the cursor.

## Motion

Motion should explain structure (things enter in reading order) and reward attention
(hover details), never demand it.

- Durations 0.4–0.9s. Default ease `power3.out`; hero and page wipe use `expo.out` / `expo.inOut`.
- Only `transform` and `opacity` are animated. No width/height/top/left.
- Hero headline: word-level mask reveal (`yPercent: 110 → 0`), 0.06s stagger.
- Scroll reveal: 24px rise + fade, triggered once at 85% viewport.
- Project hover preview: follows cursor with `quickTo` (0.5s lag), desktop + fine pointer only.
- Magnetic CTA: max 12px pull.
- Parallax: images move ≤ 8% of their height inside a clipping frame.
- Marquee: ~40s per loop, eases to a stop on hover (timeScale tween, not an abrupt pause).
- Page transitions: View Transitions API (cross-document) where supported; a 0.5s ink overlay wipe otherwise.
- `prefers-reduced-motion: reduce` → Lenis off, no split/parallax/magnetic/marquee movement, reveals become a plain 0.3s fade, page transitions off.

## Admin

The admin uses the same tokens and fonts but denser: a fixed left sidebar, 14px base
size, tables with 1px rules and mono metadata columns, forms in a single 720px column
with labels above inputs. It should feel like a tool, not a second marketing site.
