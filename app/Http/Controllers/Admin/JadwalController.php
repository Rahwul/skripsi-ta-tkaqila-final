<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JadwalController extends Controller
{
    public function __construct(protected ApiClient $api)
    {
        $this->middleware(function ($request, $next) {
            if (! Session::has('api_token')) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $jadwal = [];
        $error = null;

        try {
            $response = $this->api->get('/api/jadwal');
            if ($response->status() < 200 || $response->status() >= 300) {
                $error = $response->json('message', 'Gagal mengambil jadwal.');
            } else {
                $jadwal = $response->json('data') ?? [];
            }
        } catch (\Throwable $e) {
            $error = 'Tidak dapat menghubungi API.';
        }

        return view('admin.jadwal.index', compact('jadwal', 'error'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:191'],
            'hari' => ['required', 'string', 'max:20'],
            'jam_mulai' => ['required', 'string', 'max:10'],
            'jam_selesai' => ['required', 'string', 'max:10'],
            'keterangan' => ['nullable', 'string'],
        ]);

        try {
            $response = $this->api->post('/api/jadwal', $validated);
        } catch (\Throwable $e) {
            return back()->withErrors(['global' => 'Tidak dapat menghubungi API.']);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return back()->withErrors(['global' => $response->json('message', 'Gagal menambah jadwal.')]);
        }

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:191'],
            'hari' => ['required', 'string', 'max:20'],
            'jam_mulai' => ['required', 'string', 'max:10'],
            'jam_selesai' => ['required', 'string', 'max:10'],
            'keterangan' => ['nullable', 'string'],
        ]);

        try {
            $response = $this->api->put("/api/jadwal/{$id}", $validated);
        } catch (\Throwable $e) {
            return back()->withErrors(['global' => 'Tidak dapat menghubungi API.']);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return back()->withErrors(['global' => $response->json('message', 'Gagal mengupdate jadwal.')]);
        }

        return back()->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy($id)
    {
        try {
            $response = $this->api->delete("/api/jadwal/{$id}");
        } catch (\Throwable $e) {
            return back()->withErrors(['global' => 'Tidak dapat menghubungi API.']);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return back()->withErrors(['global' => $response->json('message', 'Gagal menghapus jadwal.')]);
        }

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required'],
        ]);

        $ids = $validated['ids'];
        $total = count($ids);
        $successCount = 0;

        foreach ($ids as $id) {
            try {
                $response = $this->api->delete("/api/jadwal/{$id}");
            } catch (\Throwable $e) {
                continue;
            }

            if ($response->status() >= 200 && $response->status() < 300) {
                $successCount++;
            }
        }

        if ($successCount !== $total) {
            return back()->with('error', "Aksi massal: {$successCount} dari {$total} jadwal berhasil dihapus.");
        }

        return back()->with('success', "Aksi massal: {$total} jadwal berhasil dihapus.");
    }
}
