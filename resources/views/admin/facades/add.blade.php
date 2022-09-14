@extends('layouts.admin')
@push('styles')
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('home') }}">
            <span class="text-muted fw-light">Home /</span>
        </a>
        Create Slug
    </h4>
    <div class="row w-50">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="slugForm" action="{{ route('facades.get-slug') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Crate your slug by text ( using
                                laravel facades )</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="text" id="text" name="text" class="form-control" placeholder="Enter text...">
                                @if ($errors->has('text'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" id="generate-slug" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
            <div id="slug" style="display:none">
                <p><b>Your Slug</b></p>
                <p id="slug-description"></p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#slugForm').validate({
                
                onfocusout: false,
                rules: {
                    text: {
                        required: true,
                        minlength: 1
                    },
                },
                messages: {
                    text: {
                        required: 'Text is required',
                    },
                },
                submitHandler: function(form) {
                    var text = $('#text').val();
                    jQuery.ajax({
                        url: "{{ route('facades.get-slug') }}",
                        method: 'post',
                        data: {
                            text: text,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.success == true) {
                                $('#slug-description').html(data.data);
                                $('#slug').css('display','block');
                            }
                        },
                        error: function(error) {
                            alert("Something went wrong please try again.");
                        }
                    });
                }
            });
        });
    </script>
@endpush
