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
                    <td>{{ $payrollschedule->payroll_date}}</td>
                    <td>{{ $payrollschedule->payroll_status }}</td>
                    <td>
                        <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                          <a href="{{ route('admin.payrollschedule.edit',['payrollschedule'=>$payrollschedule]) }}" type="button" class="btn btn-sm btn-outline-primary">
                            <i class="ik edit-2 ik-edit-2"></i>
                          </a>
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

function printForm(formId,btn){

  $.ajax({
    url: $(formId).data('action'),
    type: 'POST',
    data : new FormData($(formId)[0]),
    processData: false,
    contentType: false,
    xhrFields: {
        'responseType': 'blob'
    },
    beforeSend:function() {
      btn.prop('disabled',true);
    },
    complete : function() {
      btn.prop('disabled',false);
    },
    success: function (blob, status, xhr) {
        let filename = '';
        const disposition = xhr.getResponseHeader('Content-Disposition');

        if (disposition && disposition.indexOf('attachment') !== -1) {
            const filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
            const matches = filenameRegex.exec(disposition);

            if (matches != null && matches[1]) {
                filename = matches[1].replace(/['"]/g, '');
            }
        }

        let a = document.createElement('a');
        a.href = window.URL.createObjectURL(blob, status, xhr);
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(a.href);
    }
  });
}

$(document).ready(function() {

  var crntDate = moment().format('MMMM DD, YYYY');
  var lastDate = moment().subtract(30, 'days').format('MMMM DD, YYYY');
  var datePickerPlug = $('#date').daterangepicker({
    "startDate": lastDate,
    "endDate": crntDate,
    locale: {format: 'MMMM DD, YYYY'},
  });

  var table = $("#payrollschedule_data_table").DataTable({
    "processing": true,
    "serverSide": true,
    "pagingType":"full_numbers",
    "pageLength":25,
    "autoWidth": false,
    "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50,100, "All"] ],
    "ajax": {
      "url": "{{ $getDataTable }}",
      "type": "POST",
      "data":function( d ) {
        d.date = $("#date").val();
      }
    },
    "columnDefs": [
    {
      'targets': [5],
      'searchable':false,
      'orderable':false,
      "className": "text-left"
    }
    // ],
    //     "columns": [
    //         { data: 'no', name: 'no' },
    //         { data: 'employee_id', name: 'employee_id' },
    //         { data: 'nama_pegawai', name: 'nama_pegawai' },
    //         { data: 'no_rekening', name: 'no_rekening' },
    //         { data: 'position', name: 'position' },
    //         { data: 'pay_date', name: 'pay_date' },
    //         { data: 'salary', name: 'salary' },
    //         { data: 'tunjangan', name: 'tunjangan' },
    //         { data: 'pajak', name: 'pajak' },
    //         { data: 'potongan', name: 'potongan' },
    //         { data: 'payroll_status', name: 'payroll_status' },
    //         { data: 'total_salary', name: 'total_salary' }
    //     ]

  });

  var inputDate = $("#date").val();
  $("#payroll_date_input,#payslip_date_input").val(inputDate);

  datePickerPlug.on('apply.daterangepicker', function(ev, picker) {
      var date = picker.startDate.format("MMMM DD, YYYY")+" - "+picker.endDate.format("MMMM DD, YYYY");
      $("#payroll_date_input,#payslip_date_input").val(date);
      table.ajax.reload();
  });

  $("#pdfBtnPrintpayslilp,#pdfBtnPrintpayroll").on("click",function(e){
    var formId = ($(this).attr("id") == "pdfBtnPrintpayslilp") ? "#payslipForm" : "#payrollForm";
    printForm(formId,$(this));
  });
});

</script>
