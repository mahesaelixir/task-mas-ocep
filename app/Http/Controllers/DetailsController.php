<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\ProdukDetails;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailsController extends Controller
{
    public function index(Request $request)
    {
        return view("details");
    }

    public function create()
    {
        $produk = Produk::all();
        return view("cd", compact("produk"));
    }
    public function getData()
    {
        $data = ProdukDetails::with('produk')->select('produk_details.*');

        return datatables()->of($data)
            ->addColumn('produk_nama', function ($row) {
                return $row->produk->nama_produk ?? '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('details.edit', $row->id);
                $deleteUrl = route('details.delete', $row->id);
            
                return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">Edit</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-url="' . $deleteUrl . '">Hapus</button>
                ';
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        try {
            ProdukDetails::create($data);
            return response()->json(['message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data'], 500);
        }
    }
    public function produk()
    {
        $produk = Produk::all();
        return view("cd", compact("produk"));
    }
    // Menampilkan form edit
    public function edit($id)
    {
        $produk = Produk::all();
        $detail = ProdukDetails::findOrFail($id);
        return view('ed', compact('detail', 'produk'));
    }

    // Menyimpan perubahan
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        try {
            $detail = ProdukDetails::findOrFail($id);
            $detail->update($data);
            return redirect()->route('dp')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data');
        }
    }

    // Menghapus data
    public function destroy($id)
    {
        try {
            ProdukDetails::destroy($id);
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}
