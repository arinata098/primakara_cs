<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Validasi;
use App\Models\AtributChecklist;

class LaporanController extends Controller
{
    public function laporan()
    {
        $results = Validasi::select(
            'validasi_data.id_atribut_checklist',
            'validasi_data.tgl_check',
            'validasi_data.id_cs',
            'data_atribut_checklist.id_ruangan',
            'ruangan.nama_ruangan',
            'data_atribut_checklist.id_list',
            'check_list.nama_list',
            'data_atribut_checklist.status',
            'validasi_data.validasi'
        )
            ->join('data_atribut_checklist', 'validasi_data.id_atribut_checklist', '=', 'data_atribut_checklist.id_atribut')
            ->join('ruangan', 'data_atribut_checklist.id_ruangan', '=', 'ruangan.id_ruangan')
            ->join('check_list', 'data_atribut_checklist.id_list', '=', 'check_list.id_list')
            ->orderBy('data_atribut_checklist.id_ruangan')
            ->orderBy('validasi_data.tgl_check')
            ->orderBy('data_atribut_checklist.id_list')
            ->get();

        // Inisialisasi variabel untuk menyimpan data yang sudah dielompokkan
        $groupedData = [];

        foreach ($results as $item) {
            $ruangan = $item->nama_ruangan;
            $petugas = $item->user->username;
            $list = $item->nama_list;
            $tgl_check = $item->tgl_check;
            $status = $item->status;
        
            if (!isset($groupedData[$ruangan])) {
                $groupedData[$ruangan] = [
                    'petugas' => $petugas,
                    'tugas' => [],
                    'tanggal' => [], // Tambahkan array untuk tanggal
                ];
            }
        
            if (!isset($groupedData[$ruangan]['tugas'][$list])) {
                $groupedData[$ruangan]['tugas'][$list] = [];
            }
        
            if (!isset($groupedData[$ruangan]['tanggal'][$tgl_check])) {
                $groupedData[$ruangan]['tanggal'][$tgl_check] = $tgl_check; // Tambahkan tanggal ke array tanggal
            }
        
            // Menambahkan status ke dalam tugas yang sesuai
            if (!isset($groupedData[$ruangan]['tugas'][$list][$tgl_check])) {
                $groupedData[$ruangan]['tugas'][$list][$tgl_check] = 0; // Default value jika tidak ada status
            }
        
            // $groupedData[$ruangan]['tugas'][$list][$tgl_check] += $status; //untuk menjumlahkan jika ada yang sama di hari yang sama maka status akan di jumlahkan semua
            $groupedData[$ruangan]['tugas'][$list][$tgl_check] = $status;
        }
        

        return view('admin.laporan.index', [
            'title' => 'Laporan',
            'section' => 'Aktivitas',
            'active' => 'Laporan',
            'export' => $groupedData,
        ]);
    }

    
}
