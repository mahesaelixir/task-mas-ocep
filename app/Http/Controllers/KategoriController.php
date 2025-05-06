<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function view()
    {
        return view('kategori');
    }

    // Untuk mengirim data via AJAX
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kategori::select(['id', 'nama_kategori']); // Hanya ambil kolom yang perlu

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('ke', $row->id);
                    $deleteUrl = route('kdel', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-url="' . $deleteUrl . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    // Fungsi untuk mengirim data kategori yang mau diedit
    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('ek', compact('kategori')); // Menampilkan form edit dengan data kategori
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('kt')->with('success', 'Kategori berhasil diupdate');
    }


    // Fungsi untuk menghapus data kategori
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create()
    {
        return view('ck'); // Form insert kategori
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategori = Kategori::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 500);
        }
    }
}
