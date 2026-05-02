# TK Aqila MCP Server

Server [Model Context Protocol](https://modelcontextprotocol.io/) (stdio) yang memanggil **REST API Go Fiber** proyek ini. Cocok untuk:

- **Development**: agen di Cursor membaca data pendaftaran/jadwal/laporan tanpa copy-paste manual.
- **Skripsi / demo**: lapisan akses terstruktur untuk LLM di atas API yang sama dengan Laravel.

Logika bisnis tetap di backend Go; MCP hanya **proxy HTTP** (read-oriented).

## Pemetaan tool → endpoint

| Tool MCP | HTTP | Auth JWT |
|----------|------|----------|
| `api_health` | `GET /` | Tidak |
| `site_content_list` | `GET /api/site-content` | Tidak |
| `pendaftaran_list` | `GET /api/pendaftaran` | Ya |
| `pendaftaran_get` | `GET /api/pendaftaran/:id` | Ya |
| `laporan_periode` | `GET /api/laporan?start_date=&end_date=` (YYYY-MM-DD) | Ya |
| `jadwal_list` | `GET /api/jadwal` | Ya |

Lihat juga [`backend/routes/api_routes.go`](../backend/routes/api_routes.go) untuk definisi resmi route.

## Environment

Salin `.env.example` ke `.env` (opsional) atau set variabel di konfigurasi MCP host:

| Variabel | Default | Keterangan |
|----------|---------|------------|
| `TK_AQILA_API_BASE_URL` | `http://127.0.0.1:3000` | Base URL API tanpa trailing slash |
| `TK_AQILA_API_JWT` | (kosong) | Token dari `POST /api/admin/login` (`data.token`) untuk tool yang dilindungi JWT |

## Build & jalankan lokal

```bash
cd mcp-server
npm install
npm run build
node dist/index.js
```

Server berkomunikasi lewat **stdin/stdout** (protokol MCP); jangan jalankan interaktif di terminal biasa untuk uji fungsional—gunakan klien MCP (Cursor).

Pengembangan cepat tanpa build:

```bash
npm run dev
```

## Cursor: tambahkan MCP server

1. Pastikan API Go jalan (`go run ./backend/cmd/api`).
2. Build MCP: `cd mcp-server && npm install && npm run build`.
3. Di **Cursor Settings → MCP**, tambahkan server baru (contoh path Windows sesuaikan mesin kamu):

**Menggunakan `node` + artefak ter-build:**

```json
{
  "mcpServers": {
    "tkaqila-api": {
      "command": "node",
      "args": ["C:/laragon/www/web-pendaftaran-tkaqila/mcp-server/dist/index.js"],
      "env": {
        "TK_AQILA_API_BASE_URL": "http://127.0.0.1:3000",
        "TK_AQILA_API_JWT": "GANTI_DENGAN_TOKEN_LOGIN_ADMIN"
      }
    }
  }
}
```

**Menggunakan `npx tsx` (tanpa `npm run build`):**

```json
{
  "mcpServers": {
    "tkaqila-api": {
      "command": "npx",
      "args": ["tsx", "C:/laragon/www/web-pendaftaran-tkaqila/mcp-server/src/index.ts"],
      "env": {
        "TK_AQILA_API_BASE_URL": "http://127.0.0.1:3000",
        "TK_AQILA_API_JWT": ""
      }
    }
  }
}
```

Uji cepat: minta agen memanggil tool `api_health` lalu `site_content_list`. Setelah login admin via API, isi `TK_AQILA_API_JWT` dan coba `pendaftaran_list`.

## Keamanan

- Jangan commit `.env` berisi JWT.
- Untuk demo publik, batasi tool ke `api_health` + `site_content_list` saja atau gunakan token dengan masa hidup pendek.
