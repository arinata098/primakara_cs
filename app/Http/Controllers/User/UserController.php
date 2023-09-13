<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Ruangan;
use App\Models\RoomChecklist;


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
        $roomList = Ruangan::where('lantai', $lantai)->get();

        $idRuangan = $roomList->pluck('id_ruangan'); // Ambil semua id_ruangan dari $rooms

        $rooms = RoomChecklist::with('roomInRCL', 'checklistInRCL')
        ->whereIn('id_ruangan', $idRuangan)
        ->select('*')
        ->groupBy('id_ruangan')
        ->get();

        if (count($rooms) === 0) {
            return redirect('/userDashboard')->with('dataNotFound', 'Data not found');
        }

            return view('user.ruangan', [
                'title' => 'Pilih Lantai',
                'secction' => 'Dashboard',
                'rooms' => $rooms,
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


}
