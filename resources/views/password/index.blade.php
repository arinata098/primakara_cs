<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../">
    	<title>SISKA Primakara</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<link rel="shortcut icon" href="assets/media/logos/smallprimakara.png" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<div class="d-flex flex-column min-vh-100" style="background-image: url(/assets/media/bg/bg_primakara.jpg); background-size: cover; ">
		<!--begin::Main-->
		@include('partials.navbar')
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Password reset -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" >
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<!--begin::Heading-->
						@if (session('success'))
						<div class="alert alert-success" role="alert">
						{{ session('success') }}
						</div>
						@endif
						@if (session('error'))
						<div class="alert alert-danger" role="alert">
						{{ session('error') }}
						</div>
						@endif
						{{-- beggin form --}}
						{{-- <form action="{{ route('password.edit') }}" method="post">
							@csrf
							@method("PATCH")
							<div class="form-grup">
							  <label for="old_password">Old Password</label>
							  <input type="password" name="old_password" id="old_password" class="form-control">
							  @error('old_password')
								  <div class="text-danger mt-2">{{ $message }}</div>
							  @enderror
							</div>
							<div class="form-grup">
							  <label for="password">New Password</label>
							  <input type="password" name="password" id="password" class="form-control">
							  @error('password')
								<div class="text-danger mt-2">{{ $message }}</div>
							  @enderror
							</div>
							<div class="form-grup">
							  <label for="password_confirmation">Confirm Password</label>
							  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
							</div>
							<button type="submit" class="btn btn-primary">Change Password</button>
						  </form> --}}
						<form class="form w-100" action="{{ route('password.edit') }}"  method="POST">
							<!--begin::Heading-->
								@csrf
             					@method("PATCH")
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Reset Password</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Enter your old password first.</div>
								<!--end::Link-->
							</div>
							
								<!--begin::Input group-->
								<div class="fv-row mb-7">
									<div class="mb-3">
										<label for="old_password" class="form-label fw-bolder text-gray-900 fs-6">Old Password</label>
										<input class="form-control form-control-solid" type="password" name="old_password" id="old_password" required />
										@error('old_password')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
									<div class="mb-3">
										<label for="password" class="form-label fw-bolder text-gray-900 fs-6">New Password</label>
										<input class="form-control form-control-solid" type="password" name="password" id="password" required />
										@error('password')
											<div class="text-danger mt-2">{{ $message }}</div>
										@enderror
									</div>
									<div class="mb-3">
										<label for="password_confirmation" class="form-label fw-bolder text-gray-900 fs-6">Confirm Password</label>
										<input class="form-control form-control-solid" type="password" name="password_confirmation" id="password_confirmation" required/>
									</div>
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="d-flex flex-wrap justify-content-center pb-lg-0">
									<button type="submit" id="" style="background-color: #003764" class="btn btn-lg text-light fw-bolder me-4">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
									<a href="/kelas" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
								</div>
								<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center mt-auto flex-column-auto pb-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<div class="simple-footer text-center text-light" style="user-select: auto;">
							Made with <i class="fas fa-heart text-danger" style="user-select: auto;"></i> by PPTI Primakara
						</div>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Password reset-->
		</div>
		<!--end::Main-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/authentication/password-reset/password-reset.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</div>
	<!--end::Body-->
</html>