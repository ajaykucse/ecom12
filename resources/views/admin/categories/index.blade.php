@extends('admin.layout.layout')
@section('content')

<main class="app-main" id="main" tabindex="-1">
        <!--begin::App Content Header-->
    <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-sm-6">
            <h1 class="mb-0 fs-3">Categories Management</h1>
          </div>
          <div class="col-sm-6">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
              </ol>
            </nav>
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
                @if($categoriesModule['edit_access']==1 || $categoriesModule['full_access']==1)
                <a style="max-width: 150px; float:right; display: inline-block;"
                    href="{{ url('admin/categories/create') }}"
                    class="btn btn-block btn-primary">
                    Add Category
                </a>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                  <strong>Success:</strong> {{ Session::get('success_message') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Parent Category</th>
                      <th>URL</th>
                      <th>Created On</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($categories as $category)
                    <tr>
                      <td>{{ $category->id }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->parentcategory->name ?? "" }}</td>
                      <td>{{ $category->url }}</td>
                      <td>{{ $category->created_at->format('F j, Y, g:i a') }}</td>
                    <td>
                      @if($categoriesModule['edit_access']==1 || $categoriesModule['full_access']==1)
                      <!-- Actions (Enable/Disable, Edit, Delete) will be added here -->
                      @if($category->status == 1)
                        <a class="updateCategoryStatus" data-category-id="{{ $category->id }}" style='color:#3f6ed3;' href="javascript:void(0)">
                          <i class="fas fa-toggle-on" data-status="Active"></i>
                        </a>
                      @else
                      <a class="updateCategoryStatus" data-category-id="{{ $category->id }}" style='color:#3f6ed3;' href="javascript:void(0)">
                          <i class="fas fa-toggle-off" data-status="Inactive"></i>
                        </a>
                      @endif
                      &nbsp;
                      <a href="{{ url('admin/categories/'.$category->id.'/edit') }}">
                        <i class="fas fa-edit"></i></a>
                      @if($categoriesModule['full_access']==1)
                      <form action="{{ route('categories.destroy', $category->id) }}"
                        method="POST"
                        style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                        <button class="confirmDelete"
                              name="Category"
                              title="Delete Category"
                              type="button"
                              style="border:none; background:none; color:#3f6ed3;"
                              href="javascript:void(0)"
                              data-module="category"
                              data-id="{{ $category->id }}">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    @endif
                    @endif
                    </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection