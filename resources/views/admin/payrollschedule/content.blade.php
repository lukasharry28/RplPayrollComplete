<!--data here-->
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">

        <!--Live Overtime Data-->
        <div class="card-header">
            <div class="col-md-3 d-block">
                {{-- <button class="btn btn-sm btn-dark float-left" id="pdfBtnPrintpayroll"><i
                        class="ik ik-printer"></i>PAYROLL</button> --}}
            </div>
        </div>

        <div class="card-body table-responsive">
            <table id="payrollschedule_data_table" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Company Id</th>
                        <th>Tanggal Payroll</th>
                        <th>Waktu Payroll</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrollschdedules as $payrollschedule)
                    <tr>
                    <td class="text-center">
                        {{ ($loop->index + 1) }}
                    </td>
                    <td class="text-center">{{ $payrollschedule->company->company_name }}</td>
                    <td >{{ \Carbon\Carbon::parse($payrollschedule->payroll_date)->format('d M Y') }}</td>
                    <td>{{ $payrollschedule->payroll_time}}</td>
                    <td>{{ $payrollschedule->payroll_status }}</td>
                    <td>
                        <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                          {{-- <a href="{{ route('admin.payrollschedule.edit',['payrollschedule'=>$payrollschedule]) }}" type="button" class="btn btn-sm btn-outline-primary">
                            <i class="ik edit-2 ik-edit-2"></i>
                          </a> --}}
                          <a data-href="{{ route('admin.payrollschedule.destroy',['payrollschedule'=>$payrollschedule]) }}" type="button" class="btn btn-sm btn-outline-danger delete">
                            <i class="ik trash-2 ik-trash-2"></i>
                          </a>
                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">No Payroll Data Available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--End Live Overtime Data-->

    </div>
</div>
<!--End data here-->

<div class="divHide">
    {{-- <form data-action="{{ $payslip_url }}" method="post" id="payslipForm">
        @method("POST")
        @csrf
        <input type="text" name="date" id="payslip_date_input">
    </form> --}}
    {{-- <form data-action="{{ $payroll_url }}" method="post" id="payrollscheduleForm">
        @method("POST")
        @csrf
        <input type="text" name="date" id="payrollschedule_date_input">
    </form> --}}
</div>
<script type="text/javascript">
    // get data from serve ajax
$(document).ready(function() {
  var table = $("#payrollschedule_data_table").DataTable({
  });
});

</script>
