@extends('admin.layout.app')

@section('title') {{ $employee->employee_id }} - Edit Profile @endsection

@section('css')
<style type="text/css">
    .overflow-visible {
        overflow: visible !important;
    }

    .modal-sm {
        width: auto;
        max-width: 356px !important;
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-users bg-blue"></i>
                <div class="d-inline">
                    <h5>Staff</h5>
                    <span>Edit Staff, Please fill all field correctly.</span>
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
                        <a href="{{ route('admin.employee.index') }}">Staff</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Edit</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $employee->employee_id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-12 col-xl-8 offset-md-2 offset-xl-2">

        <div class="widget overflow-visible">
            <div class="progress progress-sm progress-hi-3 hidden">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                    aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="widget-body">
                <div class="overlay hidden">
                    <i class="ik ik-refresh-ccw loading"></i>
                    <span class="overlay-text">Staff {{ $employee->employee_id }} Updating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h5 class="text-secondary"><i class="ik ik-at-sign"></i>{!! $employee->employee_id !!} Edit</h5>
                    </div>
                </div>

                <form action="{{ $form_update }}" method="POST" enctype="multipart/form-data" id="editEmployee">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="nik">NIK </label><small class="text-danger">*</small>
                                <input type="text" name="nik" class="form-control" id="nik"
                                    placeholder="71710727060240004" autocomplete="off" value="{{ $employee->nik }}">
                                <small class="text-danger err" id="nik-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="first_name">First Name </label><small class="text-danger">*</small>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="John" autocomplete="off" value="{{ $employee->first_name }}">
                                <small class="text-danger err" id="first_name-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Last Name </label><small class="text-danger">*</small>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Duo" autocomplete="off" value="{{ $employee->last_name }}">
                                <small class="text-danger err" id="last_name-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="agama">Agama </label><small class="text-danger">*</small>
                                <select class="form-control" id="agama" name="agama">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $agamas = ['Kristen','Katolik','Islam', 'Hindu','Konghucu','Budha'];
                                    @endphp
                                    @foreach($agamas as $agama)
                                    <option @if($agama==$employee->agama)
                                        selected
                                        @endif
                                        >{{ $agama }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="agama-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="gender">Gender </label><small class="text-danger">*</small>
                                <select class="form-control" id="gender" name="gender">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $genders = ['Male','Female','Other'];
                                    @endphp
                                    @foreach($genders as $gender)
                                    <option @if($gender==$employee->gender)
                                        selected
                                        @endif
                                        >{{ $gender }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="gender-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="gol_darah">Golongan Darah </label><small class="text-danger">*</small>
                                <select class="form-control" id="gol_darah" name="gol_darah">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $gol = ['A','B','O', 'AB'];
                                    @endphp
                                    @foreach($gol as $gol_darah)
                                    <option @if($gol_darah==$employee->gol_darah)
                                        selected
                                        @endif
                                        >{{ $gol_darah }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="gol_darah-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label><small class="text-danger">*</small>
                                <input type="text" class="form-control datetimepicker-input" name="tgl_lahir"
                                    id="tgl_lahir" data-toggle="datetimepicker" data-target="#tgl_lahir"
                                    autocomplete="off" value="{{ $employee->tgl_lahir }}">
                                <small class="text-danger err" id="tgl_lahir-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label><small class="text-danger">*</small>
                                <input type="text" name="tmp_lahir" class="form-control" id="tmp_lahir"
                                    placeholder="Jakarta" autocomplete="off" value="{{ $employee->tmp_lahir }}">
                                <small class="text-danger err" id="tmp_lahir-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="status_nikah">Status Nikah </label><small class="text-danger">*</small>
                                <div>
                                    <input type="radio" id="status_nikah" name="status_nikah" value="Menikah">
                                    <label for="status_nikah">Menikah</label>
                                    <input type="radio" id="status_nikah" name="status_nikah" value="Belum Menikah">
                                    <label for="status_nikah">Belum Menikah</label>
                                </div>
                                <small class="text-danger err" id="status_nikah-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="phone">Phone</label><small class="text-danger">*</small>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="XXXX-XXXX-XXXX" autocomplete="off" data-mask="0000-0000-0000" value="{{ $employee->phone }}>
                                <small class=" text-danger err" id="phone-err"></small>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label><small class="text-danger">*</small>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="john@example.com" autocomplete="off" value="{{ $employee->email }}">
                                <small class="text-danger err" id="email-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12">
                            <div class="form-group">
                                <label for="status_kerja">Status Kerja </label><small class="text-danger">*</small>
                                <select class="form-control" id="status_kerja" name="status_kerja">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $gol = ['Tetap','Kontrak','Magang'];
                                    @endphp
                                    @foreach($gol as $status_kerja)
                                    <option @if($status_kerja==$employee->status_kerja)
                                        selected
                                        @endif
                                        >{{ $status_kerja }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="status_kerja-err"></small>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="form-group">
                                <label for="position_id">Position</label><small class="text-danger">*</small>
                                <select class="form-control" name="position_id" id="position_id">
                                    @foreach($positions as $position)
                                    <option value="{{ $position->id }}" @if($position->id==$employee->position_id)
                                        selected
                                        @endif
                                        >{{ $position->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="position_id-err"></small>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="form-group">
                                <label for="schedule_id">Schedule</label><small class="text-danger">*</small>
                                <select class="form-control" name="schedule_id" id="schedule_id">
                                    @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" @if($schedule->id==$employee->schedule_id)
                                        selected
                                        @endif
                                        >{{ $schedule->time_in.'-'.$schedule->time_out }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="schedule_id-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="id_rekening">Nomor Rekening</label><small class="text-danger">*</small>
                                <select class="form-control" name="id_rekening" id="id_rekening">
                                    @foreach($rekenings as $rekening)
                                        <option value="{{ $rekening->id_rekening }}"
                                            @if($rekening->id_rekening == $employee->id_rekening) selected @endif>
                                            {{ $rekening->no_rekening . ' - ' . $rekening->nama_pemilik }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="id_rekening-err">It's important for Payscal.</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="salary">Gaji</label><small class="text-danger">*</small>
                                <input type="text" name="salary" class="form-control" id="salary"
                                    placeholder="4500000.00" autocomplete="off" value="{{ $employee->salary }}">
                                <small class="text-danger err" id="salary-err">It's just informaton purpose. it will not
                                    reflect on payslip.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="pajak_id">Pajak</label><small class="text-danger">*</small>
                                <select class="form-control" name="pajak_id" id="pajak_id">
                                    <option selected disabled value="">Choose</option>
                                    @foreach($pajaks as $pajak)
                                    <option value="{{ $pajak->pajak_id }}"
                                        @if($pajak->pajak_id == $employee->pajak_id) selected @endif>
                                        {{ $pajak->title }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="pajak_id-err">It's important for Payscal Calculate.</small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="tunjangan_id">Tunjangan </label><small class="text-danger">*</small>
                                <select class="form-control" name="tunjangan_id" id="tunjangan_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($tunjangans as $tunjangan)
                                    <option value="{{ $tunjangan->tunjangan_id }}"
                                        @if($tunjangan->tunjangan_id == $employee->tunjangan_id) selected @endif>
                                        {{ $tunjangan->title }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="tunjangan_id-err">It's important for Payscal Calculate.</small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="deduction_id">Potongan </label><small class="text-danger">*</small>
                                <select class="form-control" name="deduction_id" id="deduction_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($deductions as $deduction)
                                    <option value="{{ $deduction->deduction_id }}"
                                        @if($deduction->deduction_id == $employee->deduction_id) selected @endif>
                                        {{ $deduction->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="deduction_id-err">It's important for Payscal Calculate.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="address">Address</label> <small class="text-secondary">(Optional)</small>
                                <textarea class="form-control" id="address" name="address"
                                    rows="3">{{ $employee->address }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="remark">Remark</label> <small class="text-secondary">(Optional)</small>
                                <textarea class="form-control" id="remark" name="remark"
                                    rows="3">{{ $employee->remark }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="is_active">Status Aktif </label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" @if($employee->is_active)
                                        selected
                                        @endif
                                        >Aktif</option>
                                    <option value="0" @if(!$employee->is_active)
                                        selected
                                        @endif
                                        >Non Aktif</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Update</button>

                            <a href="{{ route('admin.employee.index') }}" class="btn btn-light"><i
                                    class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 {{ ($employee->media_id) ? 'hidden' : '' }}"
                            id="add-avatar-div">
                            <div class="form-group">
                                <label for="avatar">Upload Profile Picture</label><small
                                    class="text-secondary">(Optional)</small>
                                <label for="avatar" class="btn btn-outline-danger d-block btn-block mb-0"><i
                                        class="ik ik-image"></i> Attach Document</label>
                                <input type="file" name="avatar" class="image hidden" id="avatar">
                                <small class="text-danger err" id="media-err">*Please add pixel perfect avatar of
                                    Staff.</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 {{ (!$employee->media_id) ? 'hidden' : '' }}"
                            id="show-avatar-div">
                            <div class="form-group my-auto">
                                <a href="{{ $removeAvatar }}" class="text-danger float-right"
                                    id="remove-avatar-profile"><i class="ik ik-x-circle"></i></a>
                                <img src="{{ $employee->media_url['thumb'] }}" class="circle-temp" id="avatar-profile">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!--Avatar model-->
<div class="modal" id="AvatarModel">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12" id="avatar-preview">

                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <button type="button" class="btn btn-block btn-outline-secondary" data-dismiss="modal"><i
                                    class="ik x-circle ik-x-circle"></i> Close</button>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <button type="button" class="btn btn-block btn-dark" id="crop-nd-save"><i
                                    class="ik ik-crop"></i> Crop & Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    $uploadCrop = $('#avatar-preview').croppie({
    enableExif: true,
    viewport: {
        width: 312,
        height: 312,
        type: 'circle'
    },
    boundary: {
        width: 320,
        height: 320
    },
});

$model = $("#AvatarModel");

$(document).ready(function($) {
  $("#schedule_id,#position_id").select2();

  let birthdate = $("#birthdate").data("value");
  $('#birthdate').datetimepicker({
    defaultDate: birthdate,
    format: 'LL',
  });

  $("#editEmployee").submit(function(event){
    event.preventDefault();
    editForm("#editEmployee");
  });

  $('#avatar').on('change', function () {
    var reader = new FileReader();
    reader.onload = function (e) {
      $uploadCrop.croppie('bind', {
        url: e.target.result
      })
    }
    reader.readAsDataURL(this.files[0]);
    $model.modal('show');
  });

  //crop and save image
  $('#crop-nd-save').on('click', function (ev) {
    $uploadCrop.croppie('result', {
      type: 'canvas',
      size: 'viewport',
      circle:false
    }).then(function (resp) {
      $.ajax({
        url: "{{ route('admin.storeMediaBase64') }}",
        type: "POST",
        data: {"file":resp},
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend:function(){
          $("button").prop('disabled',true);
        },
        success: function (response) {
          $('form#editEmployee').append('<input type="hidden" name="media" value="' + response.name + '">');
          $("#avatar-profile").prop('src', response.profileUrl); // avatar profile show
          $("#remove-avatar-profile").prop('href', response.removeProfileUrl);//remove button
          $("#add-avatar-div").addClass('hidden');
          $("#show-avatar-div").removeClass('hidden');
          $model.modal('hide'); // model close
        },
        complete:function(){
          $("button").prop('disabled',false);
        }
      });
    });
  });

  //remove current saved image
  $("#remove-avatar-profile").on('click',function(e){
    e.preventDefault();
    var fireUrl = $(this).prop('href');
    $.ajax({
        url: fireUrl,
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend:function(){
          $("button").prop('disabled',true);
        },
        success: function (response) {
          $('<input type="hidden" name="media">').remove();
          $("#show-avatar-div").addClass('hidden');
          $("#add-avatar-div").removeClass('hidden');
        },
        complete:function(){
          $("button").prop('disabled',false);
        }
      });
  });
});
</script>
@endsection
