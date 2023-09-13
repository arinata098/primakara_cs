<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ \Carbon\Carbon::parse(date("Y-m-d h:i:sa"))->format('j F Y'); }}</h1>
            <!--end::Title-->
            <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <!--end::Separator-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="/" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">{{ $active }}</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
@if (\Session::has('insertSuccess'))
<script>
    Swal.fire(
    'Berhasil!',
    '{!! \Session::get('insertSuccess') !!}',
    'success'
    )
</script>
@endif
@if (\Session::has('insertFail'))
<script>
    Swal.fire(
    'Gagal!',
    '{!! \Session::get('insertFail') !!}',
    'error'
    )
</script>
@endif
@if (\Session::has('updateSuccess'))
<script>
    Swal.fire(
    'Berhasil!',
    '{!! \Session::get('updateSuccess') !!}',
    'success'
    )
</script>
@endif
@if (\Session::has('deleteSuccess'))
<script>
    Swal.fire(
    'Berhasil!',
    '{!! \Session::get('deleteSuccess') !!}',
    'success'
    )
</script>
@endif
@if (\Session::has('dataNotFound'))
<script>
    Swal.fire(
    'Ups!',
    '{!! \Session::get('dataNotFound') !!}',
    'warning'
    )
</script>
@endif
@if (\Session::has('deleteFail'))
<script>
    Swal.fire(
    'Failed',
    '{!! \Session::get('deleteFail') !!}',
    'error'
    )
</script>
@endif
@if (\Session::has('updateFail'))
<script>
    Swal.fire(
    'Gagal!',
    '{!! \Session::get('updateFail') !!}',
    'error'
    )
</script>
@endif
