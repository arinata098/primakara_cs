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
                    <div class="card-body pb-0">
                        <!--begin::Heading-->
                        <!--begin::Row-->
                        <div class="row g-5 g-xl-8">
                            @foreach($rooms as $room)

                            <div class="col-xl-4">
                                <!--begin::Statistics Widget 5-->

                                <a href="#" data-bs-toggle="modal" data-bs-target="#detailModal{{ $room->roomInRCL->nama_ruangan  }}" class="card bg-success hoverable card-xl-stretch mb-xl-8">
                                {{-- <a href="{{ route('formRuangan', $room->uuid) }}" class="card bg-success hoverable card-xl-stretch mb-xl-8"> --}}
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Shopping/Wallet.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                                <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                        <!--end::Svg Icon-->
                                        <div class="text-white fw-bolder fs-2 mb-2 mt-5">{{ $room->roomInRCL->nama_ruangan }}</div>
                                        <div class="fw-bold text-white">lantai {{ $room->roomInRCL->lantai }}</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--begin::Modal - New Card-->
                                <div class="modal fade" id="detailModal{{ $room->roomInRCL->nama_ruangan  }}" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog modal-dialog-centered mw-850px">
                                        <!--begin::Modal content-->
                                        <div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header">
                                                <!--begin::Modal title-->
                                                <h2>Checklist Kebersihan Ruang {{ $room->roomInRCL->nama_ruangan  }}</h2>
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
                                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                                    <!--begin::Body-->
                                                    <div class="card-body pt-2">
                                                        <!--begin::Item-->
                                                        <!--begin::Form-->
                                                        <form action="{{ route('storeForm') }}" method="POST">
                                                            @csrf
                                                            <!--begin::Input group-->
                                                            <div class="d-flex flex-column mb-7 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                                    <span class="required">Tanggal</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <input class="form-control form-control-solid" type="date" onfocus="this.showPicker()" name="tgl_check" required value=""/>
                                                            </div>
                                                            <!--end::Input group-->

                                                            {{-- begin list --}}
                                                            @foreach($roomChecklists as $roomChecklist)
                                                                @if($room->id_ruangan == $roomChecklist->id_ruangan)
                                                                <div class="d-flex align-items-center mb-8">
                                                                    <!--begin::Description-->
                                                                    <div class="flex-grow-1">
                                                                        <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{ $roomChecklist->checklistInRCL->nama_list }}</a>
                                                                    </div>
                                                                    <!--end::Description-->
                                                                    <!--begin::Bullet-->
                                                                    <span class="bullet bullet-vertical h-40px bg-success"></span>
                                                                    <!--end::Bullet-->
                                                                    <input type="hidden" name="id_list[]" value="{{ $roomChecklist->checklistInRCL->id_list }}">
                                                                    <!--begin::Checkbox-->
                                                                    <div class="form-check form-check-custom form-check-solid mx-5">
                                                                        <input class="form-check-input" name="status[]" required type="checkbox" {{ 'checked' === 'checked' ? 'value=1' : "value=0" }} />
                                                                    </div>
                                                                    <!--end::Checkbox-->
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                            {{-- end list --}}

                                                            <!--begin::Input group-->
                                                            <div class="d-flex flex-column mx-5 mt-5 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                                    <span class="required">Keterangan</span>
                                                                </label>
                                                                <!--end::Label-->
										                        <textarea class="form-control form-control-solid" required rows="3" name="keterangan" placeholder="Keterangan"></textarea>

                                                            </div>
                                                            <!--end::Input group-->

                                                            {{-- hidden input --}}
                                                            <input type="hidden" name="id_cs" value="{{ auth()->user()->id }}">

                                                            <!--begin::Actions-->
                                                            <div class="text-center pt-15">
                                                                <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancle</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <span class="indicator-label">Submit</span>
                                                                </button>
                                                            </div>
                                                            <!--end::Actions-->
                                                        </form>
                                                        <!--end::Form-->
                                                        <!--end:Item-->
                                                    </div>
                                                    <!--end::Body-->
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
                                <!--end::Statistics Widget 5-->
                            </div>
                            @endforeach
                        </div>
                        <!--end::Row-->
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
