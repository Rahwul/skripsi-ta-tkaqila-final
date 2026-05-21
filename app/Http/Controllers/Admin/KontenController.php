<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KontenController extends Controller
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
        $content = [];
        $error = null;

        try {
            $response = $this->api->get('/api/site-content');
            if ($response->status() < 200 || $response->status() >= 300) {
                $error = $response->json('message', 'Gagal mengambil konten website.');
            } else {
                $content = $response->json('data') ?? [];
            }
        } catch (\Throwable $e) {
            $error = 'Tidak dapat menghubungi API.';
        }

        $fields = [
            ['key' => 'landing.hero_badge', 'label' => 'Hero Badge'],
            ['key' => 'landing.hero_title_line1', 'label' => 'Hero Judul Baris 1'],
            ['key' => 'landing.hero_title_highlight', 'label' => 'Hero Judul Highlight'],
            ['key' => 'landing.hero_description', 'label' => 'Hero Deskripsi'],
            ['key' => 'landing.feature_1', 'label' => 'Keunggulan 1'],
            ['key' => 'landing.feature_2', 'label' => 'Keunggulan 2'],
            ['key' => 'landing.stats_alumni', 'label' => 'Stat Alumni'],
            ['key' => 'landing.stats_pengalaman', 'label' => 'Stat Pengalaman'],
            ['key' => 'landing.stats_guru', 'label' => 'Stat Guru'],
            ['key' => 'landing.stats_kepuasan', 'label' => 'Stat Kepuasan'],
            ['key' => 'landing.about_heading', 'label' => 'Tentang Kami Judul'],
            ['key' => 'landing.about_heading_highlight', 'label' => 'Tentang Kami Judul Highlight'],
            ['key' => 'landing.about_description', 'label' => 'Tentang Kami Deskripsi'],
        ];

        return view('admin.konten.index', compact('content', 'fields', 'error'));
    }

    public function update(Request $request)
    {
        $payload = $request->input('content', []);

        if (! is_array($payload)) {
            return back()->with('error', 'Konten tidak valid.');
        }

        try {
            $response = $this->api->put('/api/site-content', $payload);
        } catch (\Throwable $e) {
            return back()->with('error', 'Tidak dapat menghubungi API.');
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            return back()->with('error', $response->json('message', 'Gagal menyimpan konten website.'));
        }

        return back()->with('success', 'Konten website berhasil disimpan.');
    }
}
