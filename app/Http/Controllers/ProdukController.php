<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProdukImport;
use App\Exports\ProdukExport;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Produk::with('kategori')->select('produk.*');

            if ($request->has('nama_produk') && !empty($request->nama_produk)) {
                $data->where('nama_produk', 'like', '%' . $request->nama_produk . '%');
            }
            return DataTables::of($data)
                ->addColumn('gambar', function ($row) {
                    return '<img src="' . asset('storage/' . $row->gambar) . '" width="100" height="100">';
                })
                ->addColumn('action', function ($row) {
                    $edit = route('edit', $row->id);
                    $delete = route('delete', $row->id);

                    return '
                        <a href="' . $edit . '" class="btn btn-info btn-sm btn-edit">Edit</a>
                        <form action="' . $delete . '" method="POST" style="display:inline;" class="form-delete">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        return view('produk');
    }

    public function kategori()
    {
        $kategoris = Kategori::all();
        return view("create", compact("kategoris"));
    }

    public function create()
    {
        return view("create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_produk' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_produk', 'public');
            $data['gambar'] = $gambarPath;
        }
        try {
            DB::beginTransaction();
            Produk::create($data);
            DB::commit();
            return redirect('produk')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
        }
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('edit', ['pr' => $produk, 'kategoris' => $kategoris]);
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama_produk' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        try {
            DB::beginTransaction();
            if ($request->hasFile('gambar')) {
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('gambar_produk', 'public');
            }


            $produk->update($data);
            DB::commit();
            return redirect(route("index"))->with('success', 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Produk $produk)
    {
        try {
            DB::beginTransaction();
            $produk->delete();
            DB::commit();
            return redirect(route("index"))->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ProdukImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data produk berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
    public function export()
    {
        return Excel::download(new ProdukExport, 'produk.xlsx');
    }
}
