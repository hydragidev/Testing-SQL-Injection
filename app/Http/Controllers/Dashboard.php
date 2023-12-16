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

    // feature add name project
    public function add_name_project(Request $request)
    {
        $request->validate([
            'name_project' => 'required'
        ]);

        $name_project = session()->get('name_project');

        session()->put('name_project', $request->name_project);

        return redirect()->back();
    }

    // feature process import & input url
    public function process_add_project(Request $request) 
    {
        // Mendapatkan tipe operasi (add atau import) dari request
        $type = $request->get('type');

        // Jika tipe adalah "import", proses import dari file Postman
        if ($type == "import"){
            // Validasi bahwa file Postman telah diunggah
            $request->validate([
                'file_postman' => 'required|mimes:json|max:2048', // Sesuaikan dengan kebutuhan Anda
            ]);

            // Mendapatkan file Postman yang diunggah
            $file = $request->file('file_postman');

            // Membaca isi file Postman sebagai teks
            $postmanJson = file_get_contents($file->getPathname());

            // Mendekode file JSON Postman menjadi array
            $postmanArray = json_decode($postmanJson, true);
            // Mendapatkan data dari sesi info_url
            $endpoint = session()->get('info_url', []);

            // Proses import jika ada item dalam file Postman
            if (isset($postmanArray["item"]) && is_array($postmanArray["item"])) {
                $id = count($endpoint);

                // Iterasi melalui setiap item dalam file Postman
                foreach ($postmanArray["item"] as $item) {
                    $headers = '';

                    // Iterasi melalui setiap header dalam item
                    foreach ($item['request']['header'] as $header) {
                        $headers .= "{$header['key']}:{$header['value']}\n";
                    }

                    $filterPostdata = str_replace("\n", "", $item["request"]["body"]["raw"] ?? "");
                    $filterPostdata = str_replace("    ", "", $filterPostdata ?? '');
                    $filterPostdata = str_replace(" ", "", $filterPostdata ?? '');

                    $endpoint[$id] = [
                        "id" => $id,
                        "name_url" => $item["name"],
                        "method" => $item["request"]["method"],
                        "url" => $item["request"]["url"]["raw"],
                        "post_data" => $filterPostdata ?? "",
                        "headers" => $headers
                    ];
                    $id++;
                }

                // Menyimpan kembali array ke dalam sesi info_url
                session()->put('info_url', $endpoint);

                // Redirect kembali ke route dengan nama 'dashboard.add_project' dengan pesan berhasil
                return redirect()->route('dashboard.add_project')->with('success', 'Import berhasil');
            } else {
                // Menangani jika tidak ada item dalam file Postman
                return redirect()->route('dashboard.add_project')->with('error', 'File Postman tidak berisi item yang valid.');
            }
        } else {
            // Validasi input untuk operasi "add"
            $request->validate([
                'name_url' => 'required',
                'url' => 'required',
                'method' => 'required' 
            ]);

            $headers = str_replace("\r", "", $request->header);
            
            // Mendapatkan data dari sesi info_url
            $endpoint = session()->get('info_url', []);

            if(!$endpoint) {
                // Jika info_url kosong, berikan ID awal
                $id = 0;

                // Menambahkan data baru ke array dengan ID sebagai kunci
                $endpoint[$id] = [
                    "id" => $id,
                    "name_url" => $request->name_url ?? "-",
                    "method" => $request->method,
                    "url" => $request->url,
                    "post_data" => $request->post_data ?? "",
                    "headers" => $headers ?? ""
                ];

                // Menyimpan kembali array ke dalam sesi info_url
                session()->put('info_url', $endpoint);

                // Redirect kembali dengan pesan sukses
                return redirect()->back()->with('success', 'Successfully');
            } else {
                // Jika info_url tidak kosong, tambahkan data baru dengan ID sesuai jumlah data yang sudah ada
                $id = count($endpoint);

                // Menambahkan data baru ke array dengan ID sebagai kunci
                $endpoint[(int)$id] = [
                    "id" => $id,
                    "name_url" => $request->name_url,
                    "method" => $request->method,
                    "url" => $request->url,
                    "post_data" => $request->post_data ?? "",
                    "headers" => $headers ?? ""
                ];

                // Menyimpan kembali array ke dalam sesi info_url
                session()->put('info_url', $endpoint);

                // Redirect kembali dengan pesan sukses
                return redirect()->back()->with('success', 'Successfully');
            }
        }
    }

    // feature delete url
    public function delete_project($id) 
    {
        $endpoint = session()->get('info_url');

        if(isset($endpoint[$id]))
        {
            unset($endpoint[$id]);
            session()->put('info_url', $endpoint);
        }

        return redirect()->back()->with('success', 'Hapus Endpoint/URL berhasil!');
    }

    // feature reset list url
    public function reset_project()
    {
        // Menghapus sesi
        session()->forget('name_project');
        session()->forget('info_url');

        // Redirect kembali ke route dengan nama 'dashboard.add_project' dengan pesan berhasil
        return redirect()->route('dashboard.add_project')->with('success', 'Sesi berhasil dihapus');
    }

    // feature project detail
    public function project_detail()
    {
        $infoUrl = session()->get('info_url');
        $infoNameProject = session()->get('name_project');

        if($infoUrl == null && $infoNameProject == null) {
            return redirect()->back()->with('failed', "Name Project / Endpoint URL empty!");
        }

        // dd($infoUrl, $infoNameProject);

        return view('dashboard.project_detail', compact('infoUrl', 'infoNameProject'));

    }

    // feature project launch scan
    public function project_launch()
    {

        return view('dashboard.project_launch');
    }
}
