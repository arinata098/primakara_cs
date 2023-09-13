<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\RoomChecklist;
use App\Models\Ruangan;
use App\Models\CheckList;
use Ramsey\Uuid\Uuid;


class RoomChecklistController extends Controller
{
    public function index()
    {
        $roomChecklists = RoomChecklist::with('roomInRCL')->select('*')->groupBy('id_ruangan')->get();
        $roomChecklistsDetails = RoomChecklist::with('roomInRCL', 'checklistInRCL')->select('*')->get();

            return view('admin.master.roomChecklist.index', [
                'title' => 'Checklist Ruangan',
                'secction' => 'Master',
                'active' => 'Checklist Ruangan',
                'table' => 1,
                'roomChecklists' => $roomChecklists,
                'roomChecklistsDetails' => $roomChecklistsDetails,
            ]);
    }

    public function create()
    {
        $rooms = Ruangan::all();
        $checkList = CheckList::all();

            return view('admin.master.roomChecklist.create', [
                'title' => 'Checklist Ruangan',
                'secction' => 'Master',
                'active' => 'Checklist Ruangan',
                'rooms' => $rooms,
                'checkList' => $checkList,
            ]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'id_ruangan' => 'required|integer',
            'id_list' => 'required|array',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            // Mengakses pesan error validasi
            $errors = $validator->errors();
            // Lakukan sesuatu dengan $errors, seperti menampilkannya atau mengirimkannya ke tampilan

            // Kembali ke halaman sebelumnya
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Simpan data ke dalam basis data
        try {
            DB::beginTransaction();
            // set uniq id
            $uuid = Uuid::uuid4()->toString(); // Membuat UUID versi 4 (random)

            // Jika validasi berhasil, lanjutkan dengan menyimpan data
            $ruanganId = $request->input('id_ruangan');
            $listIds = $request->input('id_list');

            // Simpan data ke dalam tabel yang sesuai dengan model
            foreach ($listIds as $listId) {
                RoomChecklist::create([
                    'id_ruangan' => $ruanganId,
                    'uuid' => $uuid,
                    'id_list' => $listId,
                ]);
            }

            DB::commit();

            return redirect('/roomChecklist')->with('insertSuccess', 'Data created successfully.');

        } catch(Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('insertFail', $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $roomChecklist = RoomChecklist::with('roomInRCL')->where('uuid', $uuid)->first();

        if (!$roomChecklist) {
            return redirect()->back()->with('dataNotFound', 'Data not found');
        }

        $checkList = CheckList::all();

        return view('admin.master.roomChecklist.edit', [
            'title' => 'Checklist Ruangan',
            'secction' => 'Master',
            'active' => 'Checklist Ruangan',
            'roomChecklist' => $roomChecklist,
            'checkList' => $checkList,

        ]);
    }

    public function update(Request $request, $id)
    {
        $RoomChecklist = RoomChecklist::where('uuid', $id)->first();

        if (!$RoomChecklist) {
            return redirect()->back()->with('dataNotFound', 'Data not found');
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'id_ruangan' => 'required|integer',
            'id_list' => 'required|array',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            // Mengakses pesan error validasi
            $errors = $validator->errors();
            // Lakukan sesuatu dengan $errors, seperti menampilkannya atau mengirimkannya ke tampilan

            // Kembali ke halaman sebelumnya
            return redirect()->back()->withErrors($errors)->withInput();
        }

        try{
            DB::beginTransaction();
            // set uniq id
            $uuid = Uuid::uuid4()->toString(); // Membuat UUID versi 4 (random)

            // Jika validasi berhasil, lanjutkan dengan menyimpan data
            $ruanganId = $request->input('id_ruangan');
            $listIds = $request->input('id_list');

            // Hapus semua data yang terkait dengan $id terlebih dahulu
            RoomChecklist::where('uuid', $id)->delete();

            // Simpan data ke dalam tabel yang sesuai dengan model
            foreach ($listIds as $listId) {
                RoomChecklist::create([
                    'id_ruangan' => $ruanganId,
                    'uuid' => $uuid,
                    'id_list' => $listId,
                ]);
            }

            DB::commit();

            return redirect('/roomChecklist')->with('updateSuccess', 'Data updated successfully.');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Updated failed');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $roomChecklist = RoomChecklist::where('uuid', $id)->get();

        try {
            // Hapus semua data yang terkait dengan $id terlebih dahulu
            RoomChecklist::where('uuid', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }
}
