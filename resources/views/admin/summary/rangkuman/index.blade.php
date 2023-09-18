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
                                            <!--begin::Filter Form-->
                                            <form method="get" action="{{ route('rangkuman') }}" class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <label for="tanggal_awal" class="form-label">Tanggal Awal:</label>
                                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                                                </div>
                                                <div class="me-2">
                                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-8">Filter</button>
                                            </form>
                                            <!--end::Filter Form-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Table-->
                                        @if ($detailData )
                                        <div class="table-responsive my-10 mx-8">
                                            <table class="table table-striped gy-7 gs-7">
                                                <thead>
                                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th class="min-w-100px">No</th>
														<th class="min-w-100px">Tgl Check</th>
                                                        <th class="min-w-100px">Ruangan</th>
														<th class="min-w-100px">Petugas</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <th class="min-w-100px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1; // Inisialisasi no
                                                    @endphp
                                                    @foreach ($detailData as $item)
                                                    <tr>
														<td>{{ $no}}</td>
                                                        <td>{{ $item->tgl_check }}</td>
                                                        <td>{{ $item->nama_ruangan }}</td>
														<td>{{ $item->user->username }}</td>
														<!-- <td>{{ $item->validasi }}</td> -->
														<td>
                                                            @if ($item->validasi == 1)
                                                                Tervalidasi
                                                            @elseif ($item->validasi == 0)
                                                                Belum Divalidasi
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- <a href="{{ route('listDetail', $item->id_atribut_checklist) }}" class="btn btn-sm btn-primary btn-action" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a> --}}
                                                            <a href="#" class="btn btn-sm btn-primary btn-action" title="View" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_atribut_checklist }}"><i class="fas fa-eye"></i></a>
                                                            {{-- modal here --}}
                                                                <!--begin::Modal - New Card-->
                                                                <div class="modal fade" id="detailModal{{ $item->id_atribut_checklist }}" tabindex="-1" aria-hidden="true">
                                                                    <!--begin::Modal dialog-->
                                                                    <div class="modal-dialog modal-dialog-centered mw-850px">
                                                                        <!--begin::Modal content-->
                                                                        <div class="modal-content">
                                                                            <!--begin::Modal header-->
                                                                            <div class="modal-header">
                                                                                <!--begin::Modal title-->
                                                                                <h2>Checklist Kebersihan</h2>
                                                                                <!--end::Modal title-->
                                                                                <!--begin::Close-->
                                                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                                    <span class="svg-icon svg-icon-1">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                                        </svg>
                                                                                    </span>
                                                                                    <!--end::Svg Icon-->
                                                                                </div>
                                                                                <!--end::Close-->
                                                                            </div>
                                                                            <!--end::Modal header-->
                                                                            <!--begin::Modal body-->
                                                                            <div class="modal-body scroll-y mx-xl-8">
                                                                                <!--begin::content modal body-->
                                                                                <div class="table-responsive">
                                                                                    <table id="kt_datatable_detail_checklist_clean" class="table table-row-bordered gy-5">
                                                                                        <thead>
                                                                                            <tr class="fw-bold fs-4 text-muted">
                                                                                                <th>List</th>
                                                                                                <th>Checklist</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach($detailLists as $validation)
                                                                                                @if($item->id_atribut_checklist == $validation->id_atribut_checklist)
                                                                                                @foreach ($validation->atributDetails as $nameLists)
                                                                                                <tr>
                                                                                                    <td>{{ $nameLists->list->nama_list }}</td>
                                                                                                    <td>
                                                                                                        @if ($nameLists->status == 1)
                                                                                                        <i class="fa fa-check" style="color: green;"></i> Dichecklist
                                                                                                        @elseif ($nameLists->status == 0)
                                                                                                        <i class="fa fa-times" style="color: red;"></i> Belum Dichecklist
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <!--end::content modal body-->
                                                                            </div>
                                                                            <!--end::Modal body-->
                                                                        </div>
                                                                        <!--end::Modal content-->
                                                                    </div>
                                                                    <!--end::Modal dialog-->
                                                                </div>
                                                                <!--end::Modal - New Card-->
                                                            {{-- end modal --}}
                                                            <a href="{{ route('validasiData', $item->id_atribut_checklist) }}" class="btn btn-sm {{ $item->validasi == 1 ? 'btn-success' : 'btn-warning' }} btn-action" data-toggle="tooltip" title="{{ $item->validasi == 1 ? 'Tervalidasi' : 'Validasi' }}"><i class="fas fa-check"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $no++; // Tambahkan no setiap kali iterasi
                                                    @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
                                                        <div class="fs-6 text-gray-700 pe-7">Belum ada data yang diinputkan</div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        @endif
                                        <!--end::Table-->
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
