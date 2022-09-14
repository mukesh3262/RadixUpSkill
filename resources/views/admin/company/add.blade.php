@extends('layouts.admin')
@section('content')
<h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('home') }}">
        <span class="text-muted fw-light">Home /</span>
    </a>
    Add Company
</h4>
<div class="row w-50">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                    class="bx bx-user"></i></span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="basic-icon-default-fullname"
                                placeholder="John Doe" aria-label="John Doe"
                                aria-describedby="basic-icon-default-fullname2">
                            @if ($errors->has('name'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif

                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-icon-default-email">Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input type="text" name="email" id="basic-icon-default-email" class="form-control @error('email') is-invalid @enderror "
                                placeholder="john.doe@example.com" aria-label="john.doe"
                                aria-describedby="basic-icon-default-email2">
                            @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-icon-default-company">Website</label>
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"><i
                                    class="bx bx-buildings"></i></span>
                            <input type="text" name="website" id="basic-icon-default-company" class="form-control  @error('website') is-invalid @enderror "
                                placeholder="ACME Inc." aria-label="ACME Inc."
                                aria-describedby="basic-icon-default-company2">
                            @if ($errors->has('website'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('website') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Logo</label>
                        <input class="form-control" type="file" name="image" id="formFileMultiple">
                        @if ($errors->has('image'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection