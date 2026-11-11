<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Docs (Swagger UI) — Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
    <script>
        if (localStorage.getItem('pkl_theme') === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
    </script>
    <style>
        :root { color-scheme: dark; }
        html.light { color-scheme: light; }
        body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background: #0f172a; color: #e2e8f0; }
        html.light body { background: #f8fafc; color: #0f172a; }
        .topbar { padding: 14px 20px; border-bottom: 1px solid #334155; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; background: #111827; }
        html.light .topbar { background: #ffffff; border-bottom-color: #e2e8f0; }
        .brand { font-weight: 700; font-size: 16px; }
        .sub { font-size: 12px; opacity: .8; }
        .tabs { display: flex; flex-wrap: wrap; gap: 8px; }
        .tab { padding: 8px 12px; border-radius: 8px; border: 1px solid #334155; color: inherit; text-decoration: none; font-size: 13px; background: #0b1220; }
        .tab.active { background: #FF7A00; border-color: #FF7A00; color: #fff; }
        html.light .tab { background: #fff; border-color: #cbd5e1; }
        .actions a { color: #93c5fd; text-decoration: none; font-size: 13px; margin-left: 12px; }
        html.light .actions a { color: #2563eb; }
        .notice { padding: 10px 20px; font-size: 12px; border-bottom: 1px solid #334155; background: #0b1220; }
        html.light .notice { background: #fff7ed; border-bottom-color: #fed7aa; }
        #swagger-ui { background: #fff; }
        html.dark #swagger-ui { filter: invert(0.88) hue-rotate(180deg); }
        html.dark #swagger-ui img, html.dark #swagger-ui svg { filter: invert(1) hue-rotate(180deg); }
    </style>
</head>
<body>
    <div class="topbar">
        <div>
            <div class="brand">Dokumentasi API (Swagger UI)</div>
            <div class="sub">Khusus Admin &mdash; Spesifikasi OpenAPI dari microservices FastAPI (di-proxy melalui Laravel, aman untuk deployment)</div>
        </div>
        <div class="tabs">
            @foreach($services as $key => $svc)
                <a class="tab {{ $active === $key ? 'active' : '' }}" href="{{ route('admin.api-docs', ['service' => $key]) }}">
                    {{ $svc['name'] }} <span style="opacity:.7">(Port {{ $svc['port'] }})</span>
                </a>
            @endforeach
        </div>
        <div class="actions">
            <a href="{{ route('tugas.index') }}">← Kembali ke Tugas</a>
            <a href="{{ route('admin.pengguna') }}">Manajemen Pengguna</a>
        </div>
    </div>
    <div class="notice">
        Spesifikasi dimuat via proxy server: <code>{{ route('admin.api-docs.spec', $active) }}</code>.
        Jika "Try it out" digunakan di server produksi, pastikan URL service pada <code>servers</code> dapat dijangkau dari browser (atur <code>API_*_URL</code> di <code>.env</code> ke URL publik/internal yang sesuai), dan endpoint yang butuh autentikasi memerlukan header <code>Authorization: Bearer &lt;API_KEY&gt;</code>.
    </div>
    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function () {
            SwaggerUIBundle({
                url: @json(route('admin.api-docs.spec', $active)),
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: 'BaseLayout',
                persistAuthorization: true,
                tryItOutEnabled: true
            });
        };
    </script>
</body>
</html>
