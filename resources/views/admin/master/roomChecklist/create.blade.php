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
						<div class="card-px pt-10">
							<!--begin::Title-->
							<div class="row">
								<div class="col">
									<h2 class="fs-2x fw-bolder mb-0">Tambah {{ $title }}</h2>
								</div>
							</div>
							<!--end::Title-->
						</div>
						<!--end::Heading-->
						<!--begin::Table-->
                        <div class="mt-15">
                            <!--begin::Form-->
                            <form id="roomChecklistForm" action="{{ route('insert.roomChecklist') }}" method="POST">
                                @csrf
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required">Ruangan</span>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-select form-select-solid" required data-dropdown-parent="#roomChecklistForm" data-control="select2" data-hide-search="false" data-placeholder="Ruangan" name="id_ruangan">
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($rooms as $item)
                                            <option value="{{ $item->id_ruangan }}">{{ $item->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required">Check List</span>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-select form-select-solid" required data-dropdown-parent="#roomChecklistForm" data-control="select2" data-hide-search="false" data-allow-clear="true" multiple="multiple" data-placeholder="Check List" name="id_list[]">
                                        <option value="">Pilih Check List</option>
                                        @foreach ($checkList as $item)
                                            <option value="{{ $item->id_list }}">{{ $item->nama_list }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancle</a>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
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
