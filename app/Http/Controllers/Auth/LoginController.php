<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     * 
     * Method ini akan me-return halaman login menggunakan Inertia.js
     */
    public function index() {
        // Mengmbalikan tampilan 'Auth/Login' melalui Inertia.js
        return inertia('Auth/Login'); 
    }

    /**
     * Memproses permintaan login
     * 
     * Method ini bertugas untuk:
     * - Memvalidasi input (email & password)
     * - Mencoba melakukan autentikasi user
     * - Mengarahkan user ke dashboard jika berhasil, atau menampilkan error jika gagal. 
     */
    public function store(Request $request) {
        // Validasi input form login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil data email dan password dari request
        $credentials = $request->only('email', 'password');
    }
}