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
use PhpOffice\PhpSpreadsheet\Writer\Csv;


class LaporanToiletController extends Controller
{
    public function laporanToilet(Request $request)
    {
        // Mengambil tanggal awal dan tanggal akhir dari request jika tersedia
        $tanggalAwal = $request->filled('tanggal_awal') ? $request->input('tanggal_awal') : null;
        $tanggalAkhir = $request->filled('tanggal_akhir') ? $request->input('tanggal_akhir') : null;

        // Mengecek apakah filter tanggal telah digunakan
        $filterUsed = $request->filled('tanggal_awal') && $request->filled('tanggal_akhir');

        // Inisialisasi variabel untuk menyimpan data yang sudah dielompokkan
        $groupedData = [];

        $data = $request->all();

        if ($data){

            $results = Validasi::select(
                'validasi_data.id_atribut_checklist',
                'validasi_data.tgl_check',
                'validasi_data.jam',
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
                // hardcode kategori ruangan
                ->where('ruangan.kategori', 4)
                ->orderBy('data_atribut_checklist.id_ruangan')
                ->orderBy('validasi_data.tgl_check')
                ->orderBy('data_atribut_checklist.id_list')
                ->get();


            foreach ($results as $item) {
                $ruangan = $item->nama_ruangan;
                $petugas = $item->user->username;
                $list = $item->nama_list;
                $tgl_check = $item->tgl_check;
                $jam = $item->jam;
                $status = $item->status;

                if (!isset($groupedData[$ruangan])) {
                    $groupedData[$ruangan] = [
                        'petugas' => $petugas,
                        'tugas' => [],
                        'tanggal' => [], // Tambahkan array untuk tanggal
                        'jam' => [], // Tambahkan array untuk tanggal
                    ];
                }

                if (!isset($groupedData[$ruangan]['tugas'][$list])) {
                    $groupedData[$ruangan]['tugas'][$list] = [];
                }

                if (!isset($groupedData[$ruangan]['waktu'][$tgl_check])) {
                    $groupedData[$ruangan]['waktu'][$tgl_check] = [];
                }

                if (!isset($groupedData[$ruangan]['tanggal'][$tgl_check])) {
                    $groupedData[$ruangan]['tanggal'][$tgl_check] = $tgl_check; // Tambahkan tanggal ke array tanggal
                }

                if (!isset($groupedData[$ruangan]['jam'][$jam])) {
                    $groupedData[$ruangan]['jam'][$jam] = $jam; // Tambahkan tanggal ke array tanggal
                }

                // Menambahkan status ke dalam tugas yang sesuai
                if (!isset($groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam])) {
                    $groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam] = 0; // Default value jika tidak ada status
                }

                // $groupedData[$ruangan]['tugas'][$list][$tgl_check] += $status; //untuk menjumlahkan jika ada yang sama di hari yang sama maka status akan di jumlahkan semua
                $groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam] = $status;
                $groupedData[$ruangan]['waktu'][$tgl_check][$jam] = $tgl_check.' / '.$jam;
            }

            // dd($groupedData);


        }

        return view('admin.laporan.toilet', [
            'title' => 'Toilet',
            'section' => 'Laporan',
            'active' => 'Toilet',
            'export' => $groupedData,
            'filterUsed' => $filterUsed, // Mengirimkan status penggunaan filter ke tampilan
        ]);
    }

    public function prepareDataForExportToilet(Request $request)
    {
        // Mengambil tanggal awal dan tanggal akhir dari request jika tersedia
        $tanggalAwal = $request->filled('tanggal_awal') ? $request->input('tanggal_awal') : null;
        $tanggalAkhir = $request->filled('tanggal_akhir') ? $request->input('tanggal_akhir') : null;

        $results = Validasi::select(
            'validasi_data.id_atribut_checklist',
            'validasi_data.tgl_check',
            'validasi_data.jam',
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
            // hardcode kategori ruangan
            ->where('ruangan.kategori', 4)
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
            $jam = $item->jam;
            $status = $item->status;

            if (!isset($groupedData[$ruangan])) {
                $groupedData[$ruangan] = [
                    'petugas' => $petugas,
                    'tugas' => [],
                    'tanggal' => [], // Tambahkan array untuk tanggal
                    'jam' => [], // Tambahkan array untuk tanggal
                ];
            }

            if (!isset($groupedData[$ruangan]['tugas'][$list])) {
                $groupedData[$ruangan]['tugas'][$list] = [];
            }

            if (!isset($groupedData[$ruangan]['waktu'][$tgl_check])) {
                $groupedData[$ruangan]['waktu'][$tgl_check] = [];
            }

            if (!isset($groupedData[$ruangan]['tanggal'][$tgl_check])) {
                $groupedData[$ruangan]['tanggal'][$tgl_check] = $tgl_check; // Tambahkan tanggal ke array tanggal
            }

            if (!isset($groupedData[$ruangan]['jam'][$jam])) {
                $groupedData[$ruangan]['jam'][$jam] = $jam; // Tambahkan tanggal ke array tanggal
            }

            // Menambahkan status ke dalam tugas yang sesuai
            if (!isset($groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam])) {
                $groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam] = 0; // Default value jika tidak ada status
            }

            // $groupedData[$ruangan]['tugas'][$list][$tgl_check] += $status; //untuk menjumlahkan jika ada yang sama di hari yang sama maka status akan di jumlahkan semua
            $groupedData[$ruangan]['tugas'][$list][$tgl_check][$jam] = $status;
            $groupedData[$ruangan]['waktu'][$tgl_check][$jam] = $tgl_check.' / '.$jam;
        }

        // dd($groupedData);

        return collect($groupedData);
    }

    public function exportToExcelToilet(Request $request)
    {
        // Mendapatkan tanggal_awal dan tanggal_akhir dari query string
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Menggunakan tanggal_awal dan tanggal_akhir untuk memfilter data
        $exportData = $this->prepareDataForExportToilet($request, $tanggalAwal, $tanggalAkhir);

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
            $iteration = 0;

            foreach ($ruanganData['waktu'] as $tanggal) {
                foreach ($tanggal as $time) {
                    if ($iteration === 4) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, 'Controller');
                        $colIndex++;
                        $iteration = 0;
                    }

                    $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $time);
                    $colIndex++;
                    $iteration++;
                }
            }
            // Menambahkan "Validation" setelah selesai perulangan
            if ($iteration > 0 && $iteration <= 4) {
                $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, 'Controller');
            }
            $rowIndex++;

            // Isi data
            foreach ($ruanganData['tugas'] as $list => $listData) {
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $list);
                $colIndex = 2;
                $iteration = 0;

                foreach ($ruanganData['waktu'] as $tanggal => $waktu) {
                    foreach ($waktu as $keyTime => $time) {
                        if ($iteration === 4) {
                            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '✓');
                            $colIndex++;
                            $iteration = 0;
                        }

                        if (isset($listData[$tanggal][$keyTime])) {
                            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '✓');
                        } else {
                            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '');
                        }

                        $iteration++;
                        $colIndex++;
                    }
                }

                // Menambahkan "Validation" setelah selesai perulangan
                if ($iteration > 0 && $iteration <= 4) {
                    $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, '✓');
                }
                $rowIndex++;
            }

            $rowIndex++;

            
        }

        // Mengatur header untuk mengunduh file Excel
        $fileName = 'laporan_toilet.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Mengekspor spreadsheet ke response HTTP
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


}
