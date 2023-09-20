<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
            return view('admin.master.ruangan.index', [
                'title' => 'Ruangan',
                'section' => 'Master',
                'active' => 'ruangan',
                'ruangans' => $ruangans,
            ]);
    }

    public function store(Request $request)
    {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => 'required|string|max:255',
            'lantai' => 'required|string|max:255',
            'kategori' => 'required|integer|between:1,2'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // simpan data ke database
        try {
            DB::beginTransaction();

            // insert ke tabel positions
            Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
                'lantai' => $request->lantai,
                'kategori' => $request->kategori
            ]);

            DB::commit();

            return redirect()->back()->with('insertSuccess', 'Data berhasil di Inputkan.');

        } catch(Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        return view('admin.master.ruangan.edit', [
            'title' => 'Ruangan',
            'secction' => 'Master',
            'active' => 'ruangan',
            'ruangan' => $ruangan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => 'required|string|max:255',
            'lantai' => 'required|string|max:255',
            'kategori' => 'required|integer|between:1,2'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $ruangan->nama_ruangan = $request->nama_ruangan;
            $ruangan->lantai = $request->lantai;
            $ruangan->kategori = $request->kategori;

            $ruangan->save();

            return redirect('/ruangan')->with('updateSuccess', 'Data berhasil di Update');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Data gagal di Update');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $ruangan = Ruangan::find($id);

        try {
            // Hapus data pengguna
            $ruangan->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }

}
