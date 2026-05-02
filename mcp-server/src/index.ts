#!/usr/bin/env node
/**
 * TK Aqila MCP server (stdio): exposes read-oriented tools that call the GoFiber REST API.
 * Env: TK_AQILA_API_BASE_URL (default http://127.0.0.1:3000), TK_AQILA_API_JWT (Bearer for protected routes).
 */
import { Server } from "@modelcontextprotocol/sdk/server/index.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} from "@modelcontextprotocol/sdk/types.js";

const BASE =
  process.env.TK_AQILA_API_BASE_URL?.replace(/\/$/, "") ||
  "http://127.0.0.1:3000";
const JWT = process.env.TK_AQILA_API_JWT?.trim() || "";

async function apiFetch(
  path: string,
  options: { method?: string; query?: Record<string, string> } = {}
): Promise<{ ok: boolean; status: number; body: string }> {
  const url = new URL(path.startsWith("http") ? path : `${BASE}${path}`);
  if (options.query) {
    for (const [k, v] of Object.entries(options.query)) {
      if (v !== undefined && v !== "") url.searchParams.set(k, v);
    }
  }
  const headers: Record<string, string> = {
    Accept: "application/json",
  };
  if (JWT) headers.Authorization = `Bearer ${JWT}`;

  const res = await fetch(url.toString(), {
    method: options.method || "GET",
    headers,
  });
  const text = await res.text();
  return { ok: res.ok, status: res.status, body: text };
}

const TOOLS = [
  {
    name: "api_health",
    description:
      "Cek kesehatan API Go Fiber (GET /). Tidak memerlukan JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {},
    },
  },
  {
    name: "site_content_list",
    description:
      "Ambil konten website publik (GET /api/site-content). Tidak memerlukan JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {},
    },
  },
  {
    name: "pendaftaran_list",
    description:
      "Daftar semua pendaftaran (GET /api/pendaftaran). Memerlukan TK_AQILA_API_JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {},
    },
  },
  {
    name: "pendaftaran_get",
    description:
      "Detail satu pendaftaran by ID (GET /api/pendaftaran/:id). Memerlukan JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {
        id: {
          type: "string",
          description: "ID pendaftaran (angka sebagai string)",
        },
      },
      required: ["id"],
    },
  },
  {
    name: "laporan_periode",
    description:
      "Laporan pendaftaran per rentang tanggal (GET /api/laporan). Format tanggal YYYY-MM-DD. Memerlukan JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {
        start_date: { type: "string", description: "YYYY-MM-DD" },
        end_date: { type: "string", description: "YYYY-MM-DD" },
      },
      required: ["start_date", "end_date"],
    },
  },
  {
    name: "jadwal_list",
    description:
      "Daftar jadwal (GET /api/jadwal). Memerlukan TK_AQILA_API_JWT.",
    inputSchema: {
      type: "object" as const,
      properties: {},
    },
  },
];

const server = new Server(
  {
    name: "tkaqila-mcp",
    version: "1.0.0",
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

server.setRequestHandler(ListToolsRequestSchema, async () => ({
  tools: TOOLS,
}));

server.setRequestHandler(CallToolRequestSchema, async (request) => {
  const { name, arguments: args } = request.params;

  try {
    let result: { ok: boolean; status: number; body: string };

    switch (name) {
      case "api_health": {
        result = await apiFetch("/");
        break;
      }
      case "site_content_list": {
        result = await apiFetch("/api/site-content");
        break;
      }
      case "pendaftaran_list": {
        if (!JWT) {
          return {
            content: [
              {
                type: "text",
                text: JSON.stringify({
                  error:
                    "TK_AQILA_API_JWT tidak diset. Login admin lalu set token di environment MCP.",
                }),
              },
            ],
            isError: true,
          };
        }
        result = await apiFetch("/api/pendaftaran");
        break;
      }
      case "pendaftaran_get": {
        if (!JWT) {
          return {
            content: [
              {
                type: "text",
                text: JSON.stringify({
                  error: "TK_AQILA_API_JWT tidak diset.",
                }),
              },
            ],
            isError: true,
          };
        }
        const id = String((args as { id?: string })?.id ?? "").trim();
        if (!id) {
          return {
            content: [
              { type: "text", text: JSON.stringify({ error: "id wajib" }) },
            ],
            isError: true,
          };
        }
        result = await apiFetch(`/api/pendaftaran/${encodeURIComponent(id)}`);
        break;
      }
      case "laporan_periode": {
        if (!JWT) {
          return {
            content: [
              {
                type: "text",
                text: JSON.stringify({ error: "TK_AQILA_API_JWT tidak diset." }),
              },
            ],
            isError: true,
          };
        }
        const a = args as { start_date?: string; end_date?: string };
        result = await apiFetch("/api/laporan", {
          query: {
            start_date: a.start_date ?? "",
            end_date: a.end_date ?? "",
          },
        });
        break;
      }
      case "jadwal_list": {
        if (!JWT) {
          return {
            content: [
              {
                type: "text",
                text: JSON.stringify({ error: "TK_AQILA_API_JWT tidak diset." }),
              },
            ],
            isError: true,
          };
        }
        result = await apiFetch("/api/jadwal");
        break;
      }
      default:
        return {
          content: [
            {
              type: "text",
              text: JSON.stringify({ error: `Unknown tool: ${name}` }),
            },
          ],
          isError: true,
        };
    }

    let pretty = result.body;
    try {
      pretty = JSON.stringify(JSON.parse(result.body), null, 2);
    } catch {
      // keep raw
    }

    return {
      content: [
        {
          type: "text",
          text: `HTTP ${result.status} ${result.ok ? "OK" : "ERROR"}\n${pretty}`,
        },
      ],
      isError: !result.ok,
    };
  } catch (e) {
    const msg = e instanceof Error ? e.message : String(e);
    return {
      content: [
        {
          type: "text",
          text: JSON.stringify({ error: msg, base: BASE }),
        },
      ],
      isError: true,
    };
  }
});

async function main() {
  const transport = new StdioServerTransport();
  await server.connect(transport);
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
