<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CheckList;

class ChecklistController extends Controller
{
    public function index()
    {
        $checkLists = CheckList::all();
            return view('admin.master.checkList.index', [
                'title' => 'Check List',
                'secction' => 'Master',
                'active' => 'Check List',
                'checkLists' => $checkLists,
            ]);
    }

    public function store(Request $request)
    {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_list' => 'required|string|max:255'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // simpan data ke database
        try {
            DB::beginTransaction();

            // insert ke tabel positions
            CheckList::create([
                'nama_list' => $request->nama_list
            ]);

            DB::commit();

            return redirect()->back()->with('insertSuccess', 'Data created successfully.');

        } catch(Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $checkList = CheckList::find($id);

        if (!$checkList) {
            return redirect()->back()->with('dataNotFound', 'Data not found');
        }

        return view('admin.master.checkList.edit', [
            'title' => 'Check List',
            'secction' => 'Master',
            'active' => 'Check List',
            'checkList' => $checkList,
        ]);
    }

    public function update(Request $request, $id)
    {
        $CheckList = CheckList::find($id);

        if (!$CheckList) {
            return redirect()->back()->with('dataNotFound', 'Data not found');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_list' => 'required|string|max:255'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $CheckList->nama_list = $request->nama_list;

            $CheckList->save();

            return redirect('/checklist')->with('updateSuccess', 'Updated successfully');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Updated failed');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $position = CheckList::find($id);

        try {
            // Hapus data pengguna
            $position->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }
}
