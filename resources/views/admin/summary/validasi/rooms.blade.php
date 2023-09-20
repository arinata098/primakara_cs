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
                                <h1>Informasi Ruangan</h1>
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card body-->
									<div class="card-body pb-0">
										<!--begin::Heading-->
										<!--begin::Row-->
										<div class="row g-5 g-xl-8">
                                            @foreach($rooms as $item)

											<div class="col-xl-4">
												<!--begin::Statistics Widget 5-->
												<a href="{{ route('detailRuangan', $item->id_ruangan) }}" class="card bg-success hoverable card-xl-stretch mb-xl-8">
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
														<div class="text-white fw-bolder fs-2 mb-2 mt-5">Ruangan {{ $item->nama_ruangan }}</div>
														<div class="fw-bold text-white">Lantai {{ $item->lantai }}</div>
													</div>
													<!--end::Body-->
												</a>
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
