<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Validasi;
use App\Models\AtributChecklist;

class SummaryController extends Controller
{
    public function index()
    {
        return view('admin.summary.validasi.index', [
            'title' => 'Validasi',
            'section' => 'Aktivitas',
            'active' => 'Validasi'
        ]);
    }

    public function rooms($lantai)
    {
        $roomList = Ruangan::where('lantai', $lantai)->get();

        if (count($roomList) === 0) {
            return redirect('/lantai')->with('dataNotFound', 'Data not found');
        }

        return view('admin.summary.validasi.rooms', [
            'title' => 'Validasi',
            'section' => 'Aktivitas',
            'active' => 'Validasi',
            'rooms' => $roomList,
        ]);
    }

    public function detail_ruangan($id_ruangan)
    {
        $ruangan = Ruangan::find($id_ruangan); // Mengambil data nama ruangan berdasarkan id_ruangan
        $dataList = Validasi::whereHas('atributDetails', function ($query) use ($id_ruangan) {
            $query->where('id_ruangan', $id_ruangan);
        })->with('user')
        ->orderBy('tgl_check', 'desc')
        ->get();

        $detailLists = Validasi::with('atributDetails.list')->get();

        return view('admin.summary.validasi.detailRuangan', [
            'title' => 'Validasi',
            'section' => 'Aktivitas',
            'active' => 'Validasi',
            'detailRuangan' => $dataList,
            'detailLists' => $detailLists,
            'namaRuangan' => $ruangan->nama_ruangan,
        ]);
    }

    // public function list_detail($id_atribut_checklist)
    // {
    //     $listDetail = AtributChecklist::with('list') // load the list relationship
    //     ->where('id_atribut', $id_atribut_checklist)
    //     ->get();

    //     return view('admin.summary.data.listDetail', [
    //         'title' => 'Summary',
    //         'section' => 'Aktivitas',
    //         'active' => 'Summary',
    //         'listDetail' => $listDetail,
    //         'id_atribut_checklist' => $id_atribut_checklist, // Mengirimkan $id_atribut_checklist ke tampilan
    //     ]);
    // }

    public function rangkuman(Request $request)
    {
        $query = Validasi::select('validasi_data.id_atribut_checklist', 'validasi_data.tgl_check', 'validasi_data.jam', 'validasi_data.id_cs', 'validasi_data.validasi', 'data_atribut_checklist.id_ruangan', 'ruangan.nama_ruangan')
            ->join('data_atribut_checklist', 'validasi_data.id_atribut_checklist', '=', 'data_atribut_checklist.id_atribut')
            ->join('ruangan', 'data_atribut_checklist.id_ruangan', '=', 'ruangan.id_ruangan')
            ->groupBy('validasi_data.id_atribut_checklist')
            ->with('user')
            ->orderBy('tgl_check', 'desc');
    
        // Filter berdasarkan tanggal awal dan tanggal akhir
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');

            $query->whereBetween('validasi_data.tgl_check', [$tanggal_awal, $tanggal_akhir]);
        }
    
        $dataList = $query->get();
    
        $detailLists = Validasi::with('atributDetails.list')->get();
    
        return view('admin.summary.rangkuman.index', [
            'title' => 'All Data',
            'section' => 'Aktivitas',
            'active' => 'All Data',
            'detailData' => $dataList,
            'detailLists' => $detailLists,
        ]);
    }

    // Function untuk melakukan validasi oleh Bagian SDM
    public function validasi_data($id_atribut_checklist)
    {
    try {
        Validasi::where('id_atribut_checklist', $id_atribut_checklist)->update(['validasi' => 1]);
            return redirect()->back()->with('success', 'Status validasi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status validasi');
        }
    }


}
