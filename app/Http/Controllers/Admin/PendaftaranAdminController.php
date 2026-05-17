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

    private function getDemoData(): array
    {
        return [
            ['id' => 'demo-1', 'nama_anak' => 'Aisyah Putri Ramadhani', 'nama_orang_tua' => 'Ahmad Fauzan', 'no_hp' => '08123456789', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '2021-03-15', 'jenis_kelamin' => 'P', 'alamat' => 'Perum IPB Alam Sinarsari Blok A No.12, Dramaga, Bogor', 'status_pendaftaran' => 'diterima', 'catatan' => null, 'created_at' => '2026-05-15'],
            ['id' => 'demo-2', 'nama_anak' => 'Muhammad Rizky Pratama', 'nama_orang_tua' => 'Siti Nurhaliza', 'no_hp' => '08567891234', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '2021-07-22', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Raya Dramaga No.45, Bogor', 'status_pendaftaran' => 'diproses', 'catatan' => null, 'created_at' => '2026-05-14'],
            ['id' => 'demo-3', 'nama_anak' => 'Zahra Aulia Safitri', 'nama_orang_tua' => 'Budi Santoso', 'no_hp' => '08198765432', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '2021-01-08', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Babakan Raya No.7, Dramaga, Bogor', 'status_pendaftaran' => 'pending', 'catatan' => 'Anak berkebutuhan khusus', 'created_at' => '2026-05-14'],
            ['id' => 'demo-4', 'nama_anak' => 'Hafiz Abdullah', 'nama_orang_tua' => 'Dewi Kartika', 'no_hp' => '08213456789', 'tempat_lahir' => 'Depok', 'tanggal_lahir' => '2021-11-30', 'jenis_kelamin' => 'L', 'alamat' => 'Perumahan Taman Dramaga Indah Blok C No.8', 'status_pendaftaran' => 'diterima', 'catatan' => null, 'created_at' => '2026-05-13'],
            ['id' => 'demo-5', 'nama_anak' => 'Naura Salsabila', 'nama_orang_tua' => 'Rahmat Hidayat', 'no_hp' => '08567123456', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '2022-02-14', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Ciherang No.23, Dramaga, Bogor', 'status_pendaftaran' => 'pending', 'catatan' => null, 'created_at' => '2026-05-12'],
            ['id' => 'demo-6', 'nama_anak' => 'Farhan Alif Maulana', 'nama_orang_tua' => 'Irfan Hakim', 'no_hp' => '08129876543', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2021-06-18', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Sinarsari II No.15, Dramaga, Bogor', 'status_pendaftaran' => 'diterima', 'catatan' => null, 'created_at' => '2026-05-11'],
            ['id' => 'demo-7', 'nama_anak' => 'Khadijah Azzahra', 'nama_orang_tua' => 'Yusuf Maulana', 'no_hp' => '08567234567', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '2021-09-05', 'jenis_kelamin' => 'P', 'alamat' => 'Perum IPB Alam Sinarsari Blok D No.3, Dramaga', 'status_pendaftaran' => 'diproses', 'catatan' => null, 'created_at' => '2026-05-10'],
        ];
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
            $error = null;
        }

        // Demo fallback
        if (empty($pendaftar)) {
            $pendaftar = $this->getDemoData();
            $error = null;
        }

        return view('admin.pendaftar.index', compact('pendaftar', 'error'));
    }

    public function show($id)
    {
        // Handle demo data IDs
        if (str_starts_with($id, 'demo-')) {
            $demoData = $this->getDemoData();
            $pendaftar = collect($demoData)->firstWhere('id', $id);
            if (!$pendaftar) {
                return redirect()->route('admin.pendaftar.index')->with('error', 'Data tidak ditemukan.');
            }
            return view('admin.pendaftar.show', compact('pendaftar'));
        }

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
