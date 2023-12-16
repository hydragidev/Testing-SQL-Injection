<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    // feature page dashboard
    public function dashboard()
    {
        return view('dashboard.index');
    }

    // feature dashboard page add project
    public function add_project() 
    {
        return view('dashboard.add_project');
    }

    // feature process import project postman
    public function process_import_project(Request $request) 
    {
        // Validasi bahwa file telah diunggah
        $request->validate([
            'file_postman' => 'required|mimes:json|max:2048', // Sesuaikan dengan kebutuhan Anda
            'name_project' => 'required'
        ]);

        // Mendapatkan file yang diunggah
        $file = $request->file('file_postman');

        // Membaca isi file sebagai teks
        $postmanJson = file_get_contents($file->getPathname());

        // Mendekode file JSON menjadi array
        $postmanArray = json_decode($postmanJson, true);

        // Menyimpan array ke sesi dengan nama "endpoint"
        session(['info_endpoint' => [
            'postman' => $postmanArray

        ]]);

        $endpoint = session('info_endpoint');

        // Redirect kembali ke route dengan nama 'dashboard.add_project' dengan pesan berhasil
        return redirect()->route('dashboard.add_project')->with('success', 'Import berhasil');
    }

    // feature reset import project postman
    public function reset_project()
    {
        // Menghapus sesi 'info_endpoint'
        session()->forget('info_endpoint');

        // Redirect kembali ke route dengan nama 'dashboard.add_project' dengan pesan berhasil
        return redirect()->route('dashboard.add_project')->with('success', 'Sesi berhasil dihapus');
    }
}
