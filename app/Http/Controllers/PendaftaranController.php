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

        return redirect()->route('pendaftaran.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Terima kasih.');
    }
}
