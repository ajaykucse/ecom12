@extends('admin.layout.layout')

@section('content')

<main class="app-main">

    <!-- Header -->
    <div class="app-content-header">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-6">

                    <h3 class="mb-0">
                        Admin Management
                    </h3>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-end">

                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/subadmins') }}">
                                Subadmins
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            {{ $title }}
                        </li>

                    </ol>

                </div>

            </div>

        </div>

    </div>


    <!-- Content -->
    <div class="app-content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-8">

                    <div class="card card-primary">

                        <div class="card-header">

                            <h3 class="card-title">
                                {{ $title }}
                            </h3>

                        </div>


                        <form
                            action="{{ url('admin/add-edit-subadmin/request') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <div class="card-body">


                                <!-- Error Message -->
                                @if(Session::has('error_message'))

                                    <div class="alert alert-danger">

                                        {{ Session::get('error_message') }}

                                    </div>

                                @endif


                                <!-- Success Message -->
                                @if(Session::has('success_message'))

                                    <div class="alert alert-success">

                                        {{ Session::get('success_message') }}

                                    </div>

                                @endif


                                <!-- Validation Errors -->
                                @if($errors->any())

                                    <div class="alert alert-danger">

                                        <strong>Error!</strong>

                                        <ul class="mb-0">

                                            @foreach($errors->all() as $error)

                                                <li>
                                                    {{ $error }}
                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                @endif


                                <!-- Hidden ID -->
                                @if(!empty($subadmindata->id))

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="{{ $subadmindata->id }}"
                                    >

                                @endif


                                <!-- Email -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $subadmindata->email ?? '') }}"
                                        {{ !empty($subadmindata->id) ? 'readonly' : '' }}
                                    >

                                    @error('email')

                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>

                                    @enderror

                                </div>


                                <!-- Password -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        autocomplete="new-password"
                                    >

                                    @if(!empty($subadmindata->id))

                                        <small class="text-muted">
                                            Leave blank if you don't want to change the password.
                                        </small>

                                    @endif

                                    @error('password')

                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>

                                    @enderror

                                </div>


                                <!-- Name -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Name
                                    </label>

                                    <input type="text" name="name" class="form-control" value="{{ old('name', $subadmindata->name ?? '') }}">

                                    @error('name')

                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>

                                    @enderror

                                </div>


                                <!-- Mobile -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Mobile
                                    </label>

                                    <input
                                        type="text"
                                        name="mobile"
                                        class="form-control"
                                        value="{{ old('mobile', $subadmindata->mobile ?? '') }}"
                                    >

                                    @error('mobile')

                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>

                                    @enderror

                                </div>


                                <!-- Image -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Image
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control"
                                    >

                                    @error('image')

                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>

                                    @enderror


                                    @if(!empty($subadmindata->image))

                                        <div class="mt-3">

                                            <img src="{{ url('admin/images/photos/' . $subadmindata->image) }}" width="120" height="120" style="object-fit: cover; border-radius: 5px;" alt="Subadmin Image">

                                            <!-- Keep Existing Image -->
                                            <input type="hidden" name="current_image" value="{{ $subadmindata->image }}">

                                        </div>

                                    @else

                                        <input type="hidden" name="current_image" value="">

                                    @endif

                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="card-footer">

                                <button type="submit" class="btn btn-primary">

                                    {{ !empty($subadmindata->id) ? 'Update' : 'Submit' }}

                                </button>


                                <a href="{{ url('admin/subadmins') }}" class="btn btn-secondary">

                                    Cancel

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection