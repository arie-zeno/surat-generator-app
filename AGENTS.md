# AGENTS.md

Laravel 12 app ("Surat Generator"): upload a `.docx` letter template, fill in its `${placeholder}`
macros, download the generated DOCX. Two screens only — Helper (staff records) and Template Surat.

`README.md` is unmodified Laravel boilerplate and says nothing about this app. Ignore it.

## Setup (nothing is installed in a fresh checkout — no `vendor/`, no `node_modules/`, no `.env`)

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite && php artisan migrate
mkdir -p storage/app/public/templates storage/app/public/generated
php artisan storage:link
```

`storage/app/public/generated` **must be created by hand** — `storage/app/public/.gitignore` ignores
everything in it, and PHPWord's `saveAs()` ends in a plain `copy()` that will not create the parent
directory. Without it every "Download Template" request 500s on a fresh clone.

Two setup gotchas on this machine (PHP 8.5, npm 11):

- **`composer install` fails** with "nette/schema is locked to v1.3.2 ... requires php 8.1 - 8.4"
  because the host runs PHP 8.5. `nette/schema <1.3.6` caps at 8.4. Fix without a full update:
  `composer update nette/schema --with-dependencies` (bumps `nette/schema` + `nette/utils` only).
  Already applied to `composer.lock` — don't revert it.
- **`npm install` prints an "install-scripts not yet covered by allowScripts" warning** for
  `esbuild` and `@tailwindcss/oxide`. It's harmless: the Linux binaries arrive as platform-specific
  optional deps, and `npm run build` succeeds without ever running those postinstall scripts.
  The only `npm install` side effect on this repo is `package-lock.json`'s root `"name"` field,
  which changes because the checkout dir is `surat-generator-app` but the lock was written in a dir
  named `surat-generator`. Safe to revert if you don't want it in your diff.

## Commands

- `composer dev` — server + `queue:listen` + `pail` + `npm run dev` concurrently (`--kill-others`).
- `composer test` — `artisan config:clear` then `artisan test`. Single test: `php artisan test --filter=test_name`.
- `vendor/bin/pint` — the only formatter/linter. No `pint.json`, so the stock `laravel` preset applies.
- No PHPStan, no ESLint/Prettier, no CI workflows, no Docker, no deploy config. Don't invent checks.

### `public/build` is committed

`public/build/` is tracked in git and the last three commits are CSS rebuilds. Any change under
`resources/css` or `resources/js` needs `npm run build`, and the regenerated `public/build` files
must be committed alongside the source or the change won't show up for anyone not running Vite.

The committed `app-*.css` **carries ~180 stale selectors** for markup that no longer exists, and the
cause is `@source '../../storage/framework/views/*.php'` in `resources/css/app.css`: Tailwind scans
the compiled-view cache, so the output depends on whatever happens to be sitting in that directory.
A build taken right after a page render picks up classes from old cached views; the same build after
`php artisan view:clear` prunes them (84 KB → 69 KB, ~184 selectors, 0 added). Always
`php artisan view:clear` before `npm run build` or the diff is not reproducible. Blade files are a
Tailwind source too, so a new utility class added to any view needs the same rebuild — verify with
`grep -F '.<class>' public/build/assets/app-*.css`, since a missing class silently loses its styling.

## Architecture

- `routes/web.php` is the whole app; there is no auth middleware anywhere. `route('helper')` resolves
  to `GET /` — the name does **not** imply a `/helper` URL. The sidebar highlight in
  `layouts/app.blade.php` keys off `$title` (`'Helper'` / `'Surat'`), which each controller hardcodes.
- Routes `/surat/create/{file}` and `/surat/generate/{file}` take a **DB primary key**; the
  controllers receive it as `$id`. The `{file}` placeholder name is misleading — don't go looking
  for filenames in the URL.
- Deletion is `Route::delete()` on `/helper/hapus/{id}` and `/surat/hapus/{id}`, invoked from blade
  forms via `@method('DELETE')` + an `onsubmit="return confirm(...)"` guard. The old GET URLs are
  gone (405) — if you add a destructive route, follow that pattern instead of a bare link.
- `app/Livewire/Users.php` + `resources/views/livewire/users.blade.php` are orphaned scaffolding.
  Livewire is installed, but nothing routes to or renders the component and `layouts/app.blade.php`
  has no `@livewireStyles` / `@livewireScripts`. Treat Livewire as unused; wiring it up is a task, not
  a given.
- `Surat` has no `HasFactory` and no factory file — `Surat::factory()` will not work in tests.
  Both domain models use `$guarded = ['id']`, so mass assignment is wide open; adding validation is
  an improvement, not a deviation.

## Storage layout

Templates are written to the **`public`** disk (`storage/app/public/templates/`) and read back with
raw `storage_path('app/public/' . $template->file)` calls. The default disk is `local`, whose Laravel
12 root is `storage/app/private` — code that omits the explicit `'public'` disk will write somewhere
else than the existing read paths expect. Generated files go to `storage/app/public/generated/`.

Template metadata lives in the `surats` table: `nama_surat` (display), `nama_file` (stored name),
`file` (path relative to `storage/app/public`). `SuratController::remove()` deletes the row *and*
unlinks the .docx from the `public` disk; `upload()` unlinks the stored file if the DB insert throws.

The "Lihat" link must be built with `asset('storage/' . $t->file)`, **not**
`Storage::disk('public')->url()`. The public disk's `url` is hardcoded to `env('APP_URL').'/storage'`
in `config/filesystems.php`, and `.env` has `APP_URL=http://localhost` with no port. Under
`php artisan serve` (port 8000) that emits `http://localhost/storage/...`, the browser drops the
port, Apache on :80 answers, and the file 403s. `asset()` derives from `request()->root()`, so it
keeps scheme, host and port. Same trap applies anywhere else a `Storage::url()` value is put in an
`href`. Viewing also needs `php artisan storage:link` to have been run.

## Template mechanics (PHPWord `TemplateProcessor`)

- Macros in the .docx are `${nama}`; `getVariables()` returns the bare names, and `setValue()` re-adds
  the `${}` wrapper. Form field names in `templates/create.blade.php` are generated straight from
  those names, so renaming a placeholder changes the posted key automatically.
- The form is built by substring-matching field names (`alamat`, `keterangan` → textarea). Adding a
  field type means editing that heuristic in the blade file.
- `templates/create.blade.php` also renders a fixed right-hand sidebar of `Helper::all()`. Each of
  the three lines per helper (Nama / NIP / Keterangan) carries a copy button that writes its
  `data-paste-value` into whichever form field was last focused. The sidebar also has a search box
  that filters those cards **client-side** off each card's `data-search` attribute. Keep it that way:
  this page holds a half-filled form, so a server-side search (reload) would throw away everything
  the user already typed. The tracking is a plain inline `<script>` at the end of the section — no
  Livewire, no Alpine. Two things to know if you touch it: the layout has a *second* form
  (`action="#"`, the sidebar search box), so the script scopes with `form[action*="/surat/generate/"]`
  rather than a bare `form`; and the field highlight is applied by the script
  (`ring-2 ring-blue-500 border-blue-500`) instead of a `:focus` variant, because focus leaves the
  input while you click the button and the marker must survive that.
- The dashboard helper list has a **server-side** search (`?cari=`, `LIKE` over `nama`/`nip`/`ket` in
  `DashboardController::index()`), trimmed and case-insensitive by MySQL collation. Reloading is fine
  there, but on `templates/create.blade.php` the same feature has to stay client-side — see above.
- **PDF export is dead code.** `SuratController::generate()`'s `type === 'pdf'` branch never registers
  a renderer, so PHPWord throws `PDF rendering library or library path has not been defined.` The
  submit button is commented out in `templates/create.blade.php`. mPDF is installed and the working
  `Settings::setPdfRendererName()` / `setPdfRendererPath()` pair survives only in the commented-out
  `generate()` above it — restore both lines if you re-enable PDF.

## Known-broken behavior (don't assume a regression is yours)

- Validation messages render Laravel's **English** defaults while the whole UI is Indonesian. No
  `lang/` directory is published yet.
- `Surat::all()->sortByDesc('created_at')` loads every row; there is no pagination, and only the
  helper list has a search (`?cari=`, filtered on `nama`/`nip`/`ket`). The template list still has
  no search.
- Both modal forms in `dashboard.blade.php` / `templates/index.blade.php` have malformed nesting —
  `<form>` opens inside the modal body and `</form>` closes inside the footer, so a `<div>` is left
  unclosed. Browsers repair it and submits work; don't "fix" it without checking the markup after.
- The "Edit" button on the helper list is `<a href="#">` and does nothing.

## Tests

`phpunit.xml` uses sqlite `:memory:`. `tests/Feature/ExampleTest.php` requests `/`, which runs
`Helper::all()`, but the test does not use `RefreshDatabase` — so the suite **fails on a clean
checkout** with "no such table: helpers". Add `RefreshDatabase` (or run migrations) before treating
any test failure as a real regression.

## Frontend

Tailwind v4 via `@tailwindcss/vite`, configured CSS-first in `resources/css/app.css` (`@theme`,
`@source` for blade + `flowbite` + Laravel pagination views) — there is no `tailwind.config.js`, so
don't create one. Flowbite's JS is imported in `resources/js/app.js` and drives every modal,
dropdown, and drawer through `data-modal-*` / `data-dropdown-toggle` / `data-drawer-*` attributes;
those only work once Flowbite JS has loaded.

## Conventions

Domain vocabulary, table/column/model names, route names, and code comments are Indonesian
(`surats`, `nama_surat`, `nama_file`, `nip`, `ket`). Match that when extending the schema; UI strings
are Indonesian too while `APP_LOCALE` stays `en`.
