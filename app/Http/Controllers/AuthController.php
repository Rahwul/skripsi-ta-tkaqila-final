<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        try {
            $response = $this->api->post('/api/admin/login', $validated);
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['email' => 'Tidak dapat menghubungi API']);
        }

        if ($response->status() < 200 || $response->status() >= 300) {
            $message = $response->json('message', 'Login gagal');

            return back()->withInput()->withErrors(['email' => $message]);
        }

        $json = $response->json();
        $token = data_get($json, 'data.token');
        $admin = data_get($json, 'data.admin');

        if (! $token) {
            return back()->withInput()->withErrors(['email' => 'Token tidak ditemukan pada respon API']);
        }

        Session::put('api_token', $token);
        Session::put('admin_name', data_get($admin, 'name'));
        Session::put('admin_email', data_get($admin, 'email'));

        return redirect('/dashboard');
    }
}
