@extends('layouts.admin')
@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('home') }}">
            <span class="text-muted fw-light">Home /</span>
        </a>
        Add Employee
    </h4>
    <div class="row w-50">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('emp.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">First Name</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    id="basic-icon-default-fullname" placeholder="John" aria-label="John"
                                    aria-describedby="basic-icon-default-fullname2">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Last Name</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    id="basic-icon-default-fullname" placeholder="Doe" aria-label="Doe"
                                    aria-describedby="basic-icon-default-fullname2">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="basic-icon-default-fullname" placeholder="Doe@example.com" aria-label="Doe"
                                    aria-describedby="basic-icon-default-fullname2">
                                @if ($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-user"></i></span>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="basic-icon-default-fullname" placeholder="" aria-label="Doe"
                                    aria-describedby="basic-icon-default-fullname2">
                                @if ($errors->has('password'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Company</label>
                            <select id="defaultSelect" class="form-select  @error('company') is-invalid @enderror" name="company">
                                <option value="">Select</option>
                                @foreach ($company as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
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
