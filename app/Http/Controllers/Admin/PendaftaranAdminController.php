<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendaftaranAdminController extends Controller
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
        $pendaftar = [];
        $error = null;

        try {
            $response = $this->api->get('/api/pendaftaran');
            if ($response->status() < 200 || $response->status() >= 300) {
                $error = $response->json('message', 'Gagal mengambil data pendaftar.');
            } else {
                $pendaftar = $response->json('data') ?? [];
            }
        } catch (\Throwable $e) {
            $error = 'Tidak dapat menghubungi API.';
        }

        return view('admin.pendaftar.index', compact('pendaftar', 'error'));
    }

    public function show($id)
    {
        try {
            $response = $this->api->get("/api/pendaftaran/{$id}");
            if ($response->status() < 200 || $response->status() >= 300) {
                return redirect()->route('admin.pendaftar.index')
                    ->with('error', $response->json('message', 'Data pendaftar tidak ditemukan.'));
            }

            $pendaftar = $response->json('data') ?? [];
        } catch (\Throwable $e) {
            return redirect()->route('admin.pendaftar.index')
                ->with('error', 'Tidak dapat menghubungi API.');
        }

        return view('admin.pendaftar.show', compact('pendaftar'));
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status_pendaftaran' => ['required', 'in:pending,diproses,diterima,ditolak'],
            'catatan' => ['nullable', 'string'],
        ]);

        try {
            $response = $this->api->patch("/api/pendaftaran/{$id}/status", $validated);
        } catch (\Throwable $e) {
            return back()->withErrors(['global' => 'Tidak dapat menghubungi API.']);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return back()->withErrors(['global' => $response->json('message', 'Gagal mengubah status.')]);
        }

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $response = $this->api->delete("/api/pendaftaran/{$id}");
        } catch (\Throwable $e) {
            return redirect()->route('admin.pendaftar.index')->with('error', 'Tidak dapat menghubungi API.');
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return redirect()->route('admin.pendaftar.index')
                ->with('error', $response->json('message', 'Gagal menghapus data pendaftar.'));
        }

        return redirect()->route('admin.pendaftar.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required'],
            'action' => ['required', 'in:update_status,delete'],
            'status_pendaftaran' => ['required_if:action,update_status', 'in:pending,diproses,diterima,ditolak'],
        ]);

        $ids = $validated['ids'];
        $action = $validated['action'];

        $total = count($ids);
        $successCount = 0;

        foreach ($ids as $id) {
            try {
                if ($action === 'delete') {
                    $response = $this->api->delete("/api/pendaftaran/{$id}");
                } else {
                    $response = $this->api->patch("/api/pendaftaran/{$id}/status", [
                        'status_pendaftaran' => $validated['status_pendaftaran'],
                        'catatan' => null,
                    ]);
                }
            } catch (\Throwable $e) {
                continue;
            }

            if ($response->status() >= 200 && $response->status() < 300) {
                $successCount++;
            }
        }

        if ($successCount !== $total) {
            if ($action === 'delete') {
                return back()->with('error', "Aksi massal: {$successCount} dari {$total} data berhasil dihapus.");
            }

            return back()->with('error', "Aksi massal: {$successCount} dari {$total} data berhasil diubah statusnya.");
        }

        if ($action === 'delete') {
            return back()->with('success', "Aksi massal: {$total} data berhasil dihapus.");
        }

        return back()->with('success', "Aksi massal: {$total} data berhasil diubah statusnya.");
    }
}
