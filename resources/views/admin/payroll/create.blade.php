@extends('admin.layout.app')

@section('title') Create Schedule Payroll @endsection

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
                    <h5>Create Schedule Payroll</h5>
                    <span>Create Schedule Payroll, Please fill all field correctly.</span>
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
                        <a href="{{ route('admin.payrollschedule.index') }}">Schedule Payroll</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Schedule Create</li>
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
                    <span class="overlay-text">New Schedule Payroll Creating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="Rekening">
                        <h5 class="text-secondary">Create Schedule Payroll</h5>
                    </div>
                </div>

                <form action="{{ $form_store }}" method="POST" id="createPayrollSchedule">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="employee_id">Pilih Pegawai </label><small class="text-danger">*</small>
                        <select name="employee_id" id="employee_id" class="form-control" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{$employee->employee_id.' - ' .$employee->first_name.'
                                '.$employee->last_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger err" id="employee_id-err">Pilih pegawai yang akan menerima
                            payroll.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="company_id">Pilih Perusahaan </label><small class="text-danger">*</small>
                        <select name="company_id" id="company_id" class="form-control" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger err" id="company_id-err">Pilih perusahaan yang terkait dengan payroll
                            ini.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="date">Tanggal Payroll </label><small class="text-danger">*</small>
                        <input type="date" name="date" id="date" class="form-control" required
                            onchange="validateDate(this)">
                        <small class="text-danger err" id="date-err">Masukkan tanggal pembayaran payroll.</small>

                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="payschedule_id">Jadwal Pembayaran</label>
                        <select name="payschedule_id" id="payschedule_id" class="form-control" required>
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach ($payschedules as $schedule)
                            <option value="{{ $schedule->payschedule_id }}">{{ $schedule->description }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih jadwal pembayaran yang berlaku.</small>
                    </div> --}}


                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Submit</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <a href="{{ route('admin.payroll.index') }}" class="btn btn-light"><i
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
        $("#createPayroll").submit(function(event) {
            event.preventDefault();
            createForm("#createPayroll");
        });
    });

    document.getElementById('date').addEventListener('change', function () {
        const dateValue = this.value; // Format sudah dalam yyyy-mm-dd
        console.log('Tanggal yang dipilih:', dateValue); // Log format tanggal
    });


    function validateDate(input) {
        const selectedDate = input.value; // Format sudah yyyy-mm-dd
        const today = new Date().toISOString().split('T')[0]; // Format yyyy-mm-dd

        if (!selectedDate) {
            alert('Harap masukkan tanggal yang valid.');
            input.value = '';
            return;
        }

        if (selectedDate < today) {
            alert('Tanggal payroll tidak boleh merupakan tanggal kemarin. Harap pilih hari ini atau hari berikutnya.');
            input.value = '';
        }
    }
</script>
@endsection
