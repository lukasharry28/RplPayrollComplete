@extends('admin.layout.app')

@section('title') Edit Schedule Payroll @endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-file-minus bg-blue"></i>
                <div class="d-inline">
                    <h5>Edit Schedule Payroll</h5>
                    <span>Edit Schedule Payroll, Please fill all field correctly.</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">
        <div class="widget overflow-visible">
            <div class="widget-body">
                <form action="{{ $form_update }}" method="POST" id="updatePayrollSchedule">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="payroll_date">Payroll Date</label><small class="text-danger">*</small>
                        <input type="date" name="payroll_date" id="payroll_date" class="form-control" required
                            value="{{ $payrollschedule->payroll_date }}" onchange="validateDate(this)">
                    </div>
                    <div class="form-group mb-3">
                        <label for="payroll_time">Time In</label><small class="text-danger">*</small>
                        <input type="text" class="form-control datetimepicker-input" id="payroll_time"
                            data-toggle="datetimepicker" data-target="#payroll_time" name="payroll_time"
                            value="{{ $payrollschedule->payroll_time }}">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Update</button>
                    <a href="{{ route('admin.payrollschedule.index') }}" class="btn btn-light">
                        <i class="ik arrow-left ik-arrow-left"></i> Go Back
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function($) {
        $('#payroll_time').datetimepicker({
            format: 'HH:mm'
        });

        $("#updatePayrollSchedule").submit(function(event) {
            event.preventDefault();
            createForm("#updatePayrollSchedule");
        });
    });

    function validateDate(input) {
        const selectedDate = input.value;
        const today = new Date().toISOString().split('T')[0];
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
