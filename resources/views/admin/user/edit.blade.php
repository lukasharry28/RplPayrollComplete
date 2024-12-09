@extends('admin.layout.app')

@section('title') {{ $admin->username }} - Edit User Admin @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
     <div class="col-lg-8">
        <div class="page-header-title">
           <i class="ik ik-file-minus bg-blue"></i>
           <div class="d-inline">
              <h5>User Admin</h5>
              <span>Edit User Admin, Please fill all field correctly.</span>
          </div>
      </div>
  </div>
  <div class="col-lg-4">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{{ route('admin.dashboard') }}"><i class="ik ik-home"></i></a>
         </li>
         <li class="breadcrumb-item">
             <a href="{{ route('admin.user.index') }}">User Admin</a>
         </li>
         <li class="breadcrumb-item">
             <a href="#">Edit</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">{{ $admin->username }}</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">

        <div class="widget overflow-visible">
            <div class="progress progress-sm progress-hi-3 hidden">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="widget-body">
                <div class="overlay hidden">
                    <i class="ik ik-refresh-ccw loading"></i>
                    <span class="overlay-text">User Admin {{ $admin->username }} Updating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="UserAdmin">
                        <h5 class="text-secondary">Edit {{ $admin->username }} User Admin</h5>
                    </div>
                </div>

                <form action="{{ $form_update }}" method="POST" id="editAdmin">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label><small class="text-danger">*</small>
                        <input type="text" name="email" class="form-control" id="email" placeholder="ex: miaw@example.com" autocomplete="off" value="{{ $admin->email }}">
                        <small class="text-danger err" id="email-err"></small>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label><small class="text-danger">*</small>
                        <input type="text" name="username" class="form-control" id="username" placeholder="ex: super_Admin" autocomplete="off" value="{{ $admin->username }}">
                        <small class="text-danger err" id="username-err"></small>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label><small class="text-danger">*</small>
                        <input type="text" name="role" class="form-control" id="role" placeholder="ex: SuperAdmin" autocomplete="off" value="{{ $admin->role }}">
                        <small class="text-danger err" id="role-err"></small>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Update</button>

                    <a href="{{ route('admin.user.index') }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function($) {
  $("#editAdmin").submit(function(event){
    event.preventDefault();
    editForm("#editAdmin");
  });
});
</script>
@endsection
