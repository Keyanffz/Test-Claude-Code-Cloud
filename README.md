# Key — Portfolio

Personal portfolio for Muhammad Nafi Anzalulrahman, built as one Laravel app: a public
site and an `/admin` panel where every piece of content is edited without touching code.

- **Stack:** Laravel 12 · PHP 8.3+ · Blade · Tailwind CSS v4 · Alpine.js · GSAP + ScrollTrigger · Lenis · Vite · Pest
- **Design brief:** [`docs/design.md`](docs/design.md) — palette, type, grid, motion rules
- **Decisions & trade-offs:** [`docs/decisions.md`](docs/decisions.md)

## Requirements

- PHP 8.3+ with `gd`, `pdo_sqlite` (or `pdo_mysql`), `fileinfo`, `mbstring`
- Composer 2
- Node 20+ and npm

## Install

```bash
git clone <repo-url> portfolio && cd portfolio

composer install
cp .env.example .env
php artisan key:generate

touch database/database.sqlite          # SQLite is the default
php artisan migrate --seed              # schema + Key's starter content and placeholder images
php artisan storage:link                # exposes uploads at /storage

npm install
npm run build                           # or `npm run dev` while working on the frontend
```

Run it:

```bash
composer run dev     # php artisan serve + queue + logs + vite, all at once
# or just: php artisan serve
```

Open <http://localhost:8000>. Set `APP_URL` in `.env` to the address you actually use,
otherwise uploaded images will point at the wrong host.

## Admin account

There is no registration page. Create accounts from the command line:

```bash
php artisan admin:create
# non-interactive:
php artisan admin:create --name="Key" --email="you@example.com"   # password is prompted
```

Passwords must be at least 12 characters. When `APP_ENV=local`, the seeder also creates
`admin@example.com` / `password` for convenience; it never does in production.

Sign in at `/admin`. Five failed attempts per email + IP lock the form for a minute.

## What you can edit in `/admin`

| Section      | Notes                                                                                   |
| ------------ | --------------------------------------------------------------------------------------- |
| Profile      | Name, nickname (the big hero word), headline, bios (markdown), photo, CV (PDF), "open to work" |
| Projects     | Markdown description, tech-stack tags, thumbnail + gallery, links, publish/feature switches, drag to reorder |
| Experience   | Type, dates (empty end date = "Present"), drag to reorder                                |
| Skills       | Grouped by category; drag to reorder (order also drives the marquee)                    |
| Certificates | Link or PDF, optional image; hidden on the site while empty                             |
| Social links | Shown in the contact section and footer; drag to reorder                                |
| Messages     | From the contact form; opening one marks it read                                        |
| SEO          | Default meta title/description and Open Graph image (cropped to 1200×630)               |

Images are validated (JPG/PNG/WebP, ≤ 5 MB, ≥ 200×200), converted to WebP, resized, and
written with smaller `srcset` variants. Replacing or deleting an image removes the old
files. Size presets live in `config/images.php`.

## Environment

| Key                                                     | Purpose                                                                 |
| ------------------------------------------------------- | ----------------------------------------------------------------------- |
| `APP_URL`                                               | Absolute URLs for images, canonical links, OG tags and the sitemap      |
| `APP_ENV`                                               | `production` enables indexing in `robots.txt` and disables strict-mode model checks |
| `DB_CONNECTION`                                         | `sqlite` by default                                                     |
| `CACHE_STORE`                                           | Public pages are cached; `database` works, `redis` is faster            |

### Switching to MySQL

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=secret
```

Then `php artisan migrate --seed`. Nothing in the code is SQLite-specific.

## Tests

```bash
php artisan test        # or ./vendor/bin/pest
```

Covers admin auth (guests blocked, login throttling, `admin:create`), project CRUD with
real image processing, upload validation, the contact form (validation, honeypot, rate
limit), publish visibility on every public page, caching invalidation, sitemap and robots.

## Deploy

On the server:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize          # caches config, routes, views, events
php artisan admin:create
```

Set `APP_ENV=production`, `APP_DEBUG=false` and the correct `APP_URL`. Only seed if you
want the starter content: `php artisan db:seed --class=PortfolioSeeder --force`.

Point the web root at `public/`. Hashed assets in `public/build` and uploads in
`public/storage` never change once written, so they can be cached for a year. An nginx
example:

```nginx
server {
    server_name example.com;
    root /var/www/portfolio/public;
    index index.php;

    gzip on;
    gzip_types text/css application/javascript application/json image/svg+xml application/xml text/plain;

    location ~* ^/(build|storage)/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

After deploying new code, run `php artisan optimize` again. Content edits in `/admin`
invalidate the page cache on their own; no manual cache clear is needed.

## Project layout

```
app/
  Console/Commands/CreateAdmin.php     admin:create
  Http/Controllers/Admin/              admin resource controllers
  Http/Controllers/Site/               public pages, contact, sitemap, robots
  Http/Requests/                       validation (Form Requests)
  Models/Concerns/                     file cleanup, sortable ordering, cache flushing
  Services/ImageUploadService.php      resize / crop / WebP / srcset variants
  Support/Portfolio.php                cached read model for the public site
resources/
  css/app.css                          design tokens (@theme) and base styles
  js/animations/                       one GSAP module per effect, lazy-loaded
  js/admin/                            Alpine components for the admin
  views/components/                    <x-image>, <x-section-heading>, <x-project-card>, <x-admin.*>
  icons/                               Lucide SVGs used inline via <x-icon>
```
