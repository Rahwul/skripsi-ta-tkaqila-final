<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
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

    public function index(Request $request)
    {
        $filters = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $laporan = null;
        $error = null;

        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            try {
                $response = $this->api->get('/api/laporan', $filters);
                if ($response->status() < 200 || $response->status() >= 300) {
                    $error = $response->json('message', 'Gagal mengambil laporan.');
                } else {
                    $laporan = $response->json('data');
                }
            } catch (\Throwable $e) {
                $error = 'Tidak dapat menghubungi API.';
            }
        }

        return view('admin.laporan.index', compact('filters', 'laporan', 'error'));
    }
}
