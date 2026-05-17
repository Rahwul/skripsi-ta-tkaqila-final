<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    protected ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function create()
    {
        return view('pendaftaran.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_anak' => ['required', 'string', 'max:191'],
            'tempat_lahir' => ['required', 'string', 'max:191'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'nama_orang_tua' => ['required', 'string', 'max:191'],
            'no_hp' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string'],
            'catatan' => ['nullable', 'string'],
        ]);

        try {
            $response = $this->api->post('/api/pendaftaran', $validated);
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors([
                'global' => 'Gagal menghubungi API pendaftaran.',
            ]);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            $message = $response->json('message', 'Pendaftaran gagal dikirim.');

            return back()->withInput()->withErrors([
                'global' => $message,
            ]);
        }

        // Format nomor telepon admin (gunakan 62)
        $adminPhone = '6281234567890'; 
        
        // Buat pesan WhatsApp
        $jk = $validated['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan';
        $pesan = "Halo Admin TK Aqila, Assalamualaikum.\n\n";
        $pesan .= "Saya ingin mengonfirmasi pendaftaran peserta didik baru dengan detail berikut:\n\n";
        $pesan .= "👦/👧 *Data Anak*\n";
        $pesan .= "Nama: {$validated['nama_anak']}\n";
        $pesan .= "Jenis Kelamin: {$jk}\n";
        $pesan .= "TTL: {$validated['tempat_lahir']}, {$validated['tanggal_lahir']}\n\n";
        $pesan .= "👨‍👩‍👧 *Data Orang Tua*\n";
        $pesan .= "Nama: {$validated['nama_orang_tua']}\n";
        $pesan .= "No. HP: {$validated['no_hp']}\n";
        $pesan .= "Alamat: {$validated['alamat']}\n";
        
        if (!empty($validated['catatan'])) {
            $pesan .= "\n📝 *Catatan Tambahan*\n{$validated['catatan']}\n";
        }

        $pesan .= "\nMohon informasi lebih lanjut mengenai proses pendaftaran ini. Terima kasih.";

        // URL Encode pesan
        $waUrl = "https://wa.me/{$adminPhone}?text=" . urlencode($pesan);

        // Flash message for successful API save
        session()->flash('success', 'Pendaftaran berhasil dikirim. Anda sedang dialihkan ke WhatsApp...');

        // Redirect langsung ke WhatsApp
        return redirect()->away($waUrl);
    }
}
