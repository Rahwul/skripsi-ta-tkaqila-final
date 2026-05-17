<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
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
        $stat = [
            'total' => 0,
            'pending' => 0,
            'diproses' => 0,
            'diterima' => 0,
            'ditolak' => 0,
        ];

        $recent = [];

        try {
            $response = $this->api->get('/api/pendaftaran');
            if ($response->status() >= 200 && $response->status() < 300) {
                $list = $response->json('data') ?? [];
                $stat['total'] = count($list);
                foreach ($list as $item) {
                    $status = $item['status_pendaftaran'] ?? 'pending';
                    if (array_key_exists($status, $stat)) {
                        $stat[$status]++;
                    }
                }
                $recent = array_slice($list, 0, 5);
            }
        return view('admin.dashboard', compact('stat', 'recent'));
    }
}
