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
        return view('admin.summary.data.index', [
            'title' => 'Summary',
            'section' => 'Aktivitas',
            'active' => 'Summary'
        ]);
    }

    public function rooms($lantai)
    {
        $roomList = Ruangan::where('lantai', $lantai)->get();

        if (count($roomList) === 0) {
            return redirect('/lantai')->with('dataNotFound', 'Data not found');
        }

        return view('admin.summary.data.rooms', [
            'title' => 'Summary',
            'section' => 'Aktivitas',
            'active' => 'Summary',
            'rooms' => $roomList,
        ]);
    }
    
    public function detail_ruangan($id_ruangan)
    {
        $dataList = Validasi::whereHas('atributDetails', function ($query) use ($id_ruangan) {
            $query->where('id_ruangan', $id_ruangan);
        })->with('user')->get();
    
        return view('admin.summary.data.detailRuangan', [
            'title' => 'Summary',
            'section' => 'Aktivitas',
            'active' => 'Summary',
            'detailRuangan' => $dataList,
        ]);
    }

    public function list_detail($id_atribut_checklist)
    {
        $listDetail = AtributChecklist::with('list') // load the list relationship
        ->where('id_atribut', $id_atribut_checklist)
        ->get();
    
        return view('admin.summary.data.listDetail', [
            'title' => 'Summary',
            'section' => 'Aktivitas',
            'active' => 'Summary',
            'listDetail' => $listDetail,
        ]);
    }
}
