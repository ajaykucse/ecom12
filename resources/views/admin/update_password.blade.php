@extends('admin.layout.layout')
@section('content')

<main class="app-main">
	<div class="app-content-header">
	  <div class="container-fluid">
	    <div class="row">
	      <div class="col-sm-6">
	        <h1 class="mb-0 fs-3">Admin Management</h1>
	      </div>
	      <div class="col-sm-6">
	        <nav aria-label="breadcrumb">
	          <ol class="breadcrumb float-sm-end">
	            <li class="breadcrumb-item"><a href="#">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Update Password</li>
	          </ol>
	        </nav>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="app-content">
	  <div class="container-fluid">
	    <div class="row g-4">
	      <!-- Quick Example -->
	      <div class="col-md-6">
	        <div class="card card-primary card-outline mb-4">
	          <div class="card-header">
	            <div class="card-title">Update Password</div>
	          </div>

				@if(Session::has('error_message'))
				<div class='alert alert-danger alert-dismissible fade show m-3' role='alert'>
				    <strong>Error: </strong> {{ Session::get('error_message') }}
				    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endif

				@if(Session::has('success_message'))
				<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
				    <strong>Success: </strong>{{ Session::get('success_message') }}
				    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endif

				@foreach($errors->all() as $Error)
				<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
				    <strong>Error ! </strong> !! {{ $Error }}
				    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endforeach

	          <form method="post" action="{{ route('admin.update-password.request') }}">
    			@csrf
	            <div class="card-body">
	              <div class="mb-3">
	                <label for="exampleInputEmail1" class="form-label">Email address</label>
	                <input
	                  type="email"
	                  class="form-control"
	                  id="exampleInputEmail1"
	                  aria-describedby="emailHelp"
	                  value="{{ Auth::guard('admin')->user()->email }}" readonly style="background-color: #ccc;"
	                />
	                <div id="emailHelp" class="form-text">
	                  We'll never share your email with anyone else.
	                </div>
	              </div>
	              <div class="mb-3">
	                <label for="current_pwd" class="form-label">Current Password</label>
	                <input type="password" class="form-control" id="current_pwd" name="current_pwd" />
	                <span id="verifyPwd"></span>
	              </div>
	              <div class="mb-3">
	                <label for="new_pwd" class="form-label">New Password</label>
	                <input type="password" class="form-control" id="new_pwd" name="new_pwd" />
	              </div>
	              <div class="mb-3">
	                <label for="confirm_pwd" class="form-label">Confirm Password</label>
	                <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" />
	              </div>
	            </div>
	            <div class="card-footer">
	              <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</main>
@endsection