@extends('admin.layout.app')

@section('title') {{ $rekening->title }} - Edit Rekening @endsection

@section('css')
<style type="text/css">
    .overflow-visible {
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
                    <h5>Rekening</h5>
                    <span>Edit Rekening, Please fill all field correctly.</span>
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
                        <a href="{{ route('admin.rekening.index') }}">Rekening</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Edit</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $rekening->no_rekening }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">

        <div class="widget overflow-visible">
            <div class="progress progress-sm progress-hi-3 hidden">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                    aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="widget-body">
                <div class="overlay hidden">
                    <i class="ik ik-refresh-ccw loading"></i>
                    <span class="overlay-text">Rekening {{ $rekening->no_rekening }} Updating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="Deduction">
                        <h5 class="text-secondary">Edit {{ $rekening->no_rekening }} Deduction</h5>
                    </div>
                </div>

                <form action="{{ $form_update }}" method="POST" id="editRekening">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="no_rekening">No Rekening</label><small class="text-danger">*</small>
                                <input type="text" name="no_rekening" class="form-control" id="no_rekening"
                                    data-mask="0000-0000-00" placeholder="ex: 1490-7901-11" autocomplete="off" value="{{ $rekening->no_rekening }}">
                                <small class="text-danger err" id="no_rekening-err"></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="nama_pemilik">Nama Pemilik</label><small class="text-danger">*</small>
                                <input type="text" name="nama_pemilik" class="form-control" id="nama_pemilik"
                                    placeholder="ex: Budi Gunawan" autocomplete="off" value="{{ $rekening->nama_pemilik }}">
                                <small class="text-danger err" id="nama_pemilik-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="rekening_name">Nama Rekening </label><small class="text-danger">*</small>
                                <select class="form-control" id="rekening_name" name="rekening_name">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $gol = ['Rekening Utama','Rekening Tabungan', 'Rekening Gaji', 'Rekening Usaha'];
                                    @endphp
                                    @foreach($gol as $rekening_name)
                                    <option @if($rekening_name==$rekening->rekening_name)
                                        selected
                                        @endif
                                        >{{ $rekening_name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="rekening_name-err"></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="type_rekening">Type Rekening</label><small class="text-danger">*</small>
                                <select class="form-control" id="type_rekening" name="type_rekening">
                                    <option selected value disabled>choose</option>
                                    @php
                                    $gol = ['rekening perusahaan','rekening pegawai'];
                                    @endphp
                                    @foreach($gol as $type_rekening)
                                    <option @if($type_rekening==$rekening->type_rekening)
                                        selected
                                        @endif
                                        >{{ $type_rekening }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="type_rekening-err"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="saldo">Saldo Rekening</label><small class="text-danger">*</small>
                                <input type="text" name="saldo" class="form-control" id="saldo"
                                    placeholder="ex: 1490790111" autocomplete="off" value="{{ $rekening->saldo }}">
                                <small class="text-danger err" id="saldo-err"></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="bank_id">Bank</label><small class="text-danger">*</small>
                                <select class="form-control" id="bank_id" name="bank_id">
                                    <option selected value disabled>choose</option>
                                    @foreach($banks as $bankOption)
                                        <option value="{{ $bankOption->bank_id }}"
                                            @if(old('bank_id', $rekening->bank_id) == $bankOption->bank_id)
                                                selected
                                            @endif>
                                            {{ $bankOption->bank_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger err" id="bank_id-err"></small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Update</button>

                    <a href="{{ route('admin.rekening.index') }}" class="btn btn-light"><i
                            class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function($) {
  $("#editRekening").submit(function(event){
    event.preventDefault();
    editForm("#editRekening");
  });
});
</script>
@endsection
