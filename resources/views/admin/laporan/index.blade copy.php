@extends('layouts.main')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- ... Bagian lain dari tampilan Anda ... -->
    
    <!--begin::Table-->
    <div class="table-responsive my-10 mx-8">
        <table class="table table-striped gy-7 gs-7">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <th class="min-w-100px">Nama Ruangan</th>
                    <th class="min-w-100px">Petugas</th>
                    <th class="min-w-100px">List Pekerjaan</th>
                    <th class="min-w-100px">Checklist</th> <!-- Tambahkan kolom Tanggal -->
                </tr>
            </thead>
            <tbody>
                @foreach ($export as $ruangan => $ruanganData)
                    @php
                        $first = true;
                    @endphp
                    <tr>
                        <td colspan="2"></td>
                        <td></td>
                        @foreach ($ruanganData['tanggal'] as $tgl)
                            <td>{{ $tgl }}</td>
                        @endforeach
                    </tr>
                    @foreach ($ruanganData['tugas'] as $list => $dataCheck)
                        <tr>
                            @if ($first)
                                <td rowspan="{{ count($ruanganData['tugas']) }}">{{ $ruangan }}</td>
                                <td rowspan="{{ count($ruanganData['tugas']) }}">{{ $ruanganData['petugas'] }}</td>
                                @php
                                    $first = false;
                                @endphp
                            @endif
                            <td>{{ $list }}</td>
                            @foreach ($dataCheck as $tgl => $status)
                                <!-- Tampilkan status di sini -->
                                <td>{{ $status }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <!--end::Table-->
</div>
@endsection
