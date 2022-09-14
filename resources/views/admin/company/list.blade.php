@extends('layouts.admin')
@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('home') }}">
            <span class="text-muted fw-light">@lang('company.home') /</span>
        </a>
        @lang('company.company')
        <a href="{{ route('company.create') }}">
            <button type="button" class="btn rounded-pill btn-primary right">@lang('company.add_company')</button>
        </a>
    </h4>

    @include('layouts.errors-and-messages') 

    <div class="card">
        <h5 class="card-header">@lang('company.company_details')
        </h5>
        <div class="table-responsive text-nowrap">
            @include('admin.company.table')
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("body").on('click', '.delete-confirm', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var $this = $(this);
                Swal.fire({
                    text: "Are you sure you want to delete?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'No',
                    confirmButtonColor: '#FC6527',
                    cancelButtonColor: '##FC6527',
                    confirmButtonText: 'Yes',
                    allowOutsideClick: false
                }).then((result) => {
                    console.log('result', result);
                    if (result.value) {
                        console.log($this.submit());
                        $this.closest('form').submit();
                    }
                })
            });
        });
    </script>
@endpush
