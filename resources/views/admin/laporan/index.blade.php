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
                                                    <!-- <a href="#" class="btn btn-sm btn-success fs-6" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ruangan">Validasi </a> -->
                                                </div>
                                            <!--end::Title-->
                                            
                                        </div>
                                        <!--end::Heading-->
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
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
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
