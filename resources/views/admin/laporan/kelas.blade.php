@extends('layouts.main')

@section('content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
                        @include('partials.toolbar')
                        <!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pb-5">
                                        <!--begin::Heading-->
                                        <div class="card-px pt-10 d-flex justify-content-between">
                                            <!--begin::Title-->
                                            <div class="d-inline">
                                                <button class="btn btn-secondary" onclick="history.back()">Back</button>
                                                <a href="{{ route('exportToExcelKelas') }}?tanggal_awal={{ request()->input('tanggal_awal') }}&tanggal_akhir={{ request()->input('tanggal_akhir') }}" class="btn btn-success fs-6">Export to Excel</a>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Filter Form-->
                                            <form method="get" action="{{ route('laporanKelas') }}" class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                                                </div>
                                                <div class="me-2">
                                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-8">Filter</button>
                                            </form>
                                            <!--end::Filter Form-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Table-->
                                        @if ($filterUsed)
                                        <div class="table-responsive my-10 mx-8">
                                            <table class="table table-striped gy-7 gs-7" style="overflow-x: auto;">
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
                                                            @foreach ($ruanganData['waktu'] as $tgl)
                                                                @foreach ($tgl as $jam)
                                                                <td>{{ $jam }}</td>
                                                                @endforeach
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
                                                                @foreach ($dataCheck as $tgl => $date)
                                                                    @foreach ($date as $status)
                                                                    <!-- Tampilkan status di sini -->
                                                                    <!-- <td>{{ $status }}</td> -->
                                                                    <td>
                                                                        @if ($status == 1)
                                                                            <i class="fa fa-check" style="color: green;"></i>
                                                                        @elseif ($status == 0)
                                                                            <i class="fa fa-times" style="color: red;"></i>
                                                                        @else
                                                                            {{ $status }}
                                                                        @endif
                                                                    </td>
                                                                    @endforeach
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        @else
                                        <div class="my-10 mx-15">
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
                                                        <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-3 mb-md-0 fw-bold">
                                                        <h4 class="text-gray-900 fw-bolder">Belum ada data</h4>
                                                        <div class="fs-6 text-gray-700 pe-7">Silahkan Filter data terlebih dahulu</div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        @endif
                                        <!-- Pagination Links -->

                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
@endsection
