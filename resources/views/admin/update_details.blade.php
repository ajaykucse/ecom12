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
	            <li class="breadcrumb-item active" aria-current="page">Update Details</li>
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
	            <div class="card-title">Update Details</div>
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

	          <form method="post" action="{{ route('admin.update-details.request') }}" enctype="multipart/form-data">
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

	              </div>
	              <div class="mb-3">
	                <label for="name" class="form-label">Name</label>
	                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::guard('admin')->user()->name }}" />
	              </div>
	              <div class="mb-3">
	                <label for="mobile" class="form-label">Mobile</label>
	                <input type="text" class="form-control" id="mobile" name="mobile" name="name" value="{{ Auth::guard('admin')->user()->mobile }}"/>
	              </div>
	              <div class="mb-3">
  					<label for="image" class="form-label">Image</label>
  					<input type="file" class="form-control" id="image" name="image" accept="image/*">
				  	@if(!empty(Auth::guard('admin')->user()->image))
				    <div id="profileImageBlock">
				      <a target="_blank" href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">View</a> |
				      <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">

				      <a href="javascript:void(0);" id="deleteProfileImage"
				         data-admin-id="{{ Auth::guard('admin')->user()->id }}"
				         class="text-danger">Delete</a>
				    </div>
				  	@endif
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