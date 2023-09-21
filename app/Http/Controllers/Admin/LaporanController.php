<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Validasi;
use App\Models\AtributChecklist;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanController extends Controller
{
    public function laporan(Request $request)
    {
        // Mengambil tanggal awal dan tanggal akhir dari request jika tersedia
        $tanggalAwal = $request->filled('tanggal_awal') ? $request->input('tanggal_awal') : null;
        $tanggalAkhir = $request->filled('tanggal_akhir') ? $request->input('tanggal_akhir') : null;

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
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                // Tambahkan kondisi untuk memfilter berdasarkan rentang tanggal
                $query->whereBetween('validasi_data.tgl_check', [$tanggalAwal, $tanggalAkhir]);
            })
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
        
        // Mengecek apakah filter tanggal telah digunakan
        $filterUsed = $request->filled('tanggal_awal') && $request->filled('tanggal_akhir');

        return view('admin.laporan.index', [
            'title' => 'Laporan',
            'section' => 'Aktivitas',
            'active' => 'Laporan',
            'export' => $groupedData,
            'filterUsed' => $filterUsed, // Mengirimkan status penggunaan filter ke tampilan
        ]);
    }

    public function prepareDataForExport(Request $request)
    {
        // Mengambil tanggal awal dan tanggal akhir dari request jika tersedia
        $tanggalAwal = $request->filled('tanggal_awal') ? $request->input('tanggal_awal') : null;
        $tanggalAkhir = $request->filled('tanggal_akhir') ? $request->input('tanggal_akhir') : null;

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
            ->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
                // Tambahkan kondisi untuk memfilter berdasarkan rentang tanggal
                $query->whereBetween('validasi_data.tgl_check', [$tanggalAwal, $tanggalAkhir]);
            })
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

            // $groupedData[$ruangan]['tugas'][$list][$tgl_check] += $status; //untuk menjumlahkan jika ada yang sama di hari yang sama maka status akan dijumlahkan semua
            $groupedData[$ruangan]['tugas'][$list][$tgl_check] = $status;
        }

        return collect($groupedData);
    }

    public function exportToExcel(Request $request)
    {
        // Mendapatkan tanggal_awal dan tanggal_akhir dari query string
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Menggunakan tanggal_awal dan tanggal_akhir untuk memfilter data
        $exportData = $this->prepareDataForExport($request, $tanggalAwal, $tanggalAkhir);

        // Membuat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menyusun data dalam format yang sesuai dengan tampilan yang diinginkan
        $rowIndex = 1;
        foreach ($exportData as $ruangan => $ruanganData) {
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, 'Nama Ruangan: ' . $ruangan);
            $rowIndex++;

            $sheet->setCellValueByColumnAndRow(1, $rowIndex, 'Petugas: ' . $ruanganData['petugas']);
            $rowIndex++;

            // Judul kolom
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, 'List Pekerjaan');
            $colIndex = 2;
            foreach ($ruanganData['tanggal'] as $tanggal) {
                $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $tanggal);
                $colIndex++;
            }
            $rowIndex++;

            // Isi data
            foreach ($ruanganData['tugas'] as $list => $listData) {
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $list);
                $colIndex = 2;
                foreach ($ruanganData['tanggal'] as $tanggal) {
                    if (isset($listData[$tanggal])) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $listData[$tanggal]);
                    } else {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '');
                    }
                    $colIndex++;
                }
                $rowIndex++;
            }

            // Spasi antara setiap ruangan
            $rowIndex++;
        }

        // Mengatur header untuk mengunduh file Excel
        $fileName = 'laporan.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Mengekspor spreadsheet ke response HTTP
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    
}
