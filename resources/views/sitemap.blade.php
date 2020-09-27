{!! '<?xml version="1.0" encoding="utf-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>{{ route('home') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/home.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.00</priority>
  </url>
  <url>
    <loc>{{ route('queue.find') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/queue/find.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('queue.create') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/queue/create.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('donate.index') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/donate/index.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('terms.index') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/terms/index.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('login') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/auth/login.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('register') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/auth/register.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
  <url>
    <loc>{{ route('password.request') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/auth/passwords/reset.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.50</priority>
  </url>
</urlset>