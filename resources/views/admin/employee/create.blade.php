@extends('admin.layout.app')

@section('title') Create Employee @endsection

@section('css')

<style type="text/css">
    .overflow-visible {
        overflow: visible !important;
    }

    .modal-sm {
        width: auto;
        max-width: 356px !important;
    }

    .select2-container--default {
        display: block;
        width: auto !important;
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
                    <h5>Employees</h5>
                    <span>Create Employee, Please fill all field correctly.</span>
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
                        <a href="{{ route('admin.employee.index') }}">Employees</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                    <span class="overlay-text">New Employee Creating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h5 class="text-secondary">Create Employee</h5>
                    </div>
                </div>

                <form action="{{ $form_store }}" method="POST" enctype="multipart/form-data" id="createEmployee">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="nik">NIK </label><small class="text-danger">*</small>
                                <input type="text" name="nik" class="form-control" id="nik" placeholder="71710727060240004"
                                    autocomplete="off">
                                <small class="text-danger err" id="nik-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="first_name">First Name </label><small class="text-danger">*</small>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                    placeholder="John" autocomplete="off">
                                <small class="text-danger err" id="first_name-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Last Name </label><small class="text-danger">*</small>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                    placeholder="Duo" autocomplete="off">
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
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                                <small class="text-danger err" id="agama-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                              <label for="gender">Gender </label><small class="text-danger">*</small>
                              <select class="form-control" id="gender" name="gender">
                                <option selected value disabled>choose</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                              </select>
                              <small class="text-danger err" id="gender-err"></small>
                            </div>
                          </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="gol_darah">Golongan Darah </label><small class="text-danger">*</small>
                                <select class="form-control" id="gol_darah" name="gol_darah">
                                    <option selected value disabled>choose</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
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
                                    autocomplete="off">
                                <small class="text-danger err" id="tgl_lahir-err"></small>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label><small class="text-danger">*</small>
                                <input type="text" name="tmp_lahir" class="form-control" id="tmp_lahir"
                                    placeholder="Jakarta" autocomplete="off">
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
                                    placeholder="XXXX-XXXX-XXXX" autocomplete="off" data-mask="0000-0000-0000">
                                <small class="text-danger err" id="phone-err"></small>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label><small class="text-danger">*</small>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="john@example.com" autocomplete="off">
                                <input type="hidden" name="username">
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
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Magang">Magang</option>
                                </select>
                                <small class="text-danger err" id="status_kerja-err"></small>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="form-group">
                                <label for="position_id">Position</label><small class="text-danger">*</small>
                                <select class="form-control" name="position_id" id="position_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="position_id-err"></small>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="form-group">
                                <label for="schedule_id">Schedule</label><small class="text-danger">*</small>
                                <select class="form-control" name="schedule_id" id="schedule_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">{{ $schedule->time_in.' - '.$schedule->time_out
                                        }}
                                    </option>
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
                                    <option selected value disabled>choose</option>
                                    @foreach($rekenings as $rekening)
                                    <option value="{{ $rekening->id_rekening }}">{{ $rekening->no_rekening. ' - ' .$rekening->nama_pemilik}}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="no_rekening" class="form-control" id="no_rekening"
                                    placeholder="xxxx-xxxx-xxxx-xxxx" autocomplete="off"> --}}
                                <small class="text-danger err" id="id_rekening-err">It's important for Payscal.</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="salary">Gaji</label><small class="text-danger">*</small>
                                <input type="text" name="salary" class="form-control" id="salary" placeholder="4500000.00"
                                    autocomplete="off">
                                <small class="text-danger err" id="salary-err">It's just informaton purpose. it will not
                                    reflect on payslip.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="pajak_id">Pajak </label><small class="text-danger">*</small>
                                <select class="form-control" name="pajak_id" id="pajak_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($pajaks as $pajak)
                                    <option value="{{ $pajak->pajak_id }}">{{ $pajak->title }}
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
                                    <option value="{{ $tunjangan->tunjangan_id }}">{{ $tunjangan->title }}
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
                                    <option value="{{ $deduction->deduction_id }}">{{ $deduction->name }}
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
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="remark">Remark</label> <small class="text-secondary">(Optional)</small>
                                <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="is_active">Status Aktif </label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Submit</button>
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-light"><i
                                    class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12" id="add-avatar-div">
                            <div class="form-group">
                                <label for="avatar">Upload Profile Picture</label><small
                                    class="text-secondary">(Optional)</small>
                                <label for="avatar" class="btn btn-outline-danger d-block btn-block mb-0"><i
                                        class="ik ik-image"></i> Attach Document</label>
                                <input type="file" name="avatar" class="image hidden" id="avatar">
                                <small class="text-danger err" id="media-err">*Please add pixel perfect avatar of
                                    Employee.</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 hidden" id="show-avatar-div">
                            <div class="form-group my-auto">
                                <a href="#" class="text-danger float-right" data-remove="" id="remove-avatar-profile"><i
                                        class="ik ik-x-circle"></i></a>
                                <img src="{{ asset('admin_assets/avatars/merchant/thumb/male.png') }}"
                                    class="circle-temp" id="avatar-profile">
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
  $("#schedule_id,#position_id,#tungjangan_id,#pajak_id, #id_rekening, #deduction_id").select2();

  $('#tgl_lahir').datetimepicker({
    format: 'LL'
  });

  $("#createEmployee").submit(function(event){
    event.preventDefault();
    createForm("#createEmployee");
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
          $('form#createEmployee').append('<input type="hidden" name="media" value="' + response.name + '">');
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
