<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Ruangan;
use App\Models\RoomChecklist;
use App\Models\AtributChecklist;
use App\Models\Validasi;
use Ramsey\Uuid\Uuid;



class UserController extends Controller
{

    public function index()
    {
            return view('user.lantai', [
                'title' => 'Pilih Lantai',
                'secction' => 'Dashboard',
                'active' => 'Dashboard'
            ]);
    }

    public function ruangan($lantai)
    {
        $room = Ruangan::where('lantai', $lantai)->get();

        $idRuangan = $room->pluck('id_ruangan'); // Ambil semua id_ruangan dari $room

        // ambil data untuk looping card
        $rooms = RoomChecklist::with('roomInRCL')
        ->whereIn('id_ruangan', $idRuangan)
        ->select('*')
        ->groupBy('id_ruangan')
        ->get();

        $availableRoomId = $rooms->pluck('id_ruangan'); // Ambil semua id_ruangan dari $rooms

        // ambil data checklist untuk ditampilkan di modal
        $roomChecklists = RoomChecklist::with('roomInRCL', 'checklistInRCL')
        ->whereIn('id_ruangan', $availableRoomId)
        ->select('*')
        ->get();

        if (count($rooms) === 0) {
            return redirect('/userDashboard')->with('dataNotFound', 'Data not found');
        }

            return view('user.ruangan', [
                'title' => 'Pilih Lantai',
                'secction' => 'Dashboard',
                'table' => 1,
                'rooms' => $rooms,
                'roomChecklists' => $roomChecklists,
                'active' => 'Dashboard'
            ]);
    }

    public function formRuangan($uuid)
    {
        $formRooms = RoomChecklist::with('roomInRCL', 'checklistInRCL')
        ->where('uuid', $uuid)
        ->select('*')
        ->get();

        dd($formRooms);

        if (count($formRooms) === 0) {
            return redirect()->back()->with('dataNotFound', 'Data not found');
        }

            return view('user.ruangan', [
                'title' => 'Pilih Ruangan',
                'secction' => 'Dashboard',
                'formRooms' => $formRooms,
                'active' => 'Dashboard'
            ]);
    }

    public function storeForm(Request $request) {

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tgl_check' => 'required|date',
            'id_list' => 'required|array',
            'status' => 'required|array',
            'keterangan' => 'required|string',
            'id_cs' => 'required',
            'id_ruangan' => 'required',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            // Mengakses pesan error validasi
            $errors = $validator->errors();
            // Lakukan sesuatu dengan $errors, seperti menampilkannya atau mengirimkannya ke tampilan

            // Kembali ke halaman sebelumnya
            return redirect()->back()->withErrors($errors)->withInput();
        }

        try {
            DB::beginTransaction();

            $uuid = Uuid::uuid4()->toString(); // Membuat UUID versi 4 (random)
            // Data yang akan dimasukkan ke tabel validasi_data
            $validasiData = [
                'id_atribut_checklist' => $uuid,
                'tgl_check' => $request->tgl_check,
                'id_cs' => $request->id_cs,
                'keterangan' => $request->tgl_check,
                'validasi' => 0,
                // Tambahkan kolom lain sesuai kebutuhan Anda
            ];

            // Masukkan data ke tabel validasi_data dan ambil ID yang baru dibuat
            $validasiDataModel = Validasi::create($validasiData);

            // Data yang akan dimasukkan ke tabel data_atribut_checklist
            $dataAtributChecklist = [];

            $idListArray = $request->id_list;
            $statusArray = $request->status;


            // Loop untuk menyiapkan data untuk tabel data_atribut_checklist
            for ($i = 0; $i < count($idListArray); $i++) {
                $dataAtributChecklist[] = [
                    'id_atribut' => $uuid,
                    'id_list' => $idListArray[$i],
                    'id_ruangan' => $request->id_ruangan,
                    'status' => $statusArray[$i],
                ];
            }

            // Masukkan data ke tabel data_atribut_checklist dengan menggunakan createMany
            $validasiDataModel->atributDetails()->createMany($dataAtributChecklist);

            DB::commit();

            return redirect()->back()->with('insertSuccess', 'Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('insertFail', $e->getMessage());
        }

    }


}
