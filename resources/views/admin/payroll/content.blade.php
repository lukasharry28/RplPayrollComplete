<!--data here-->
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">

        <!--Live Overtime Data-->
        <div class="card-header">
            <div class="col-md-3 d-block">
                {{-- <button class="btn btn-sm btn-dark float-left" id="pdfBtnPrintpayroll"><i
                        class="ik ik-printer"></i>PAYROLL</button> --}}
                <button class="btn btn-sm btn-dark float-left" id="pdfBtnPrintpayroll" {{-- data-action=" route('admin.payroll.exportPdf') " --}}>
                    <i class="ik ik-printer"></i> PAYROLL
                </button>

            </div>
            {{-- <div class="col-md-9">
                <div class="input-group mb-0">
                    <span class="input-group-prepend">
                        <label class="input-group-text"><i class="ik ik-calendar"></i></label>
                    </span>
                    <input type="text" class="form-control form-control-bold text-center"
                        placeholder="From date - To date" id="date">
                    <span class="input-group-append">
                        <label class="input-group-text"><i class="ik ik-calendar"></i></label>
                    </span>
                </div>
            </div> --}}
            {{-- <div class="col-md-3">
                <button type="submit" class="btn btn-primary mb-2 h-33 float-right" id="pdfBtnPrintpayslilp"><i
                        class="ik ik-printer"></i> PAYSLIP</button>
            </div> --}}
        </div>

        <div class="card-body table-responsive">
            <table id="payroll_data_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width="180">Detail Pegawai</th>
                        <th>Rekening</th>
                        <th>Posisi</th>
                        <th>Tanggal Pay</th>
                        <th width="135">Gaji</th>
                        <th width="340">Tunjangan</th>
                        <th>Pajak</th>
                        <th>Potongan</th>
                        <th>Status Payroll</th>
                        <th width="135">Total Gaji</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td class="text-center">
                            {{ ($loop->index + 1) }}
                        </td>
                        <td>
                            <div>
                                <span>{{ $payroll->employee->employee_id }}</span><br>
                                <b><span>{{ $payroll->employee->first_name }} </span></b>
                                <b><span>{{ $payroll->employee->last_name }}</span></b>
                            </div>
                        </td>
                        {{-- <td>{{ $payroll->employee->first_name. ' ' .$employee->last_name }}</td> --}}
                        <td>
                            <div>
                                <b><span>{{ $payroll->employee->rekening->no_rekening }}</span></b><br>
                                <b>Bank:</b> <span>{{$payroll->employee->rekening->bank->bank_name}}</span><br>
                            </div>
                        </td>
                        {{-- <td>{{ $payroll->employee->position->title }}</td> --}}
                        <td> <code class="pc">{{ $payroll->employee->position->title }}</code></td>
                        <td>{{ $payroll->date }}</td>
                        <td><code class="main">{{ number_format($payroll->employee->salary, 2) }}</code></td>
                        <td>
                            <div>
                                <b>Jenis:</b> <span>{{ $payroll->employee->tunjangan->title }}</span><br>
                                <b>Nominal:</b> <span><code class="main">{{ number_format($payroll->employee->tunjangan->rate_amount, 2)
                                    }}</code></span><br>
                            </div>
                        </td>
                        <td>
                            <div>
                                <b>Jenis:</b> <span>{{ $payroll->employee->pajak->title }}</span><br>
                                <b>Nominal:</b> <span><code class="pc">{{ number_format($payroll->employee->pajak->tax_amount, 2)
                                    }}</code></span><br>
                            </div>
                        </td>
                        <td>
                            <div>
                                <b>Jenis:</b> <span>{{ $payroll->employee->deduction->name }}</span><br>
                                <b>Nominal:</b> <span><code class="pc">{{ number_format($payroll->employee->deduction->amount, 2)
                                    }}</code></span><br>
                            </div>
                        </td>
                        <td>{{ $payroll->payroll_status }}</td>
                        <td><code class="main">{{ $payroll->total_amount }}</code></td>
                        <td>
                            <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                {{-- <a href="{{ route('admin.payroll.edit',['payroll'=>$payroll]) }}" type="button"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="ik edit-2 ik-edit-2"></i>
                                </a> --}}
                                <a data-href="{{ route('admin.payroll.destroy',['payroll'=>$payroll]) }}" type="button"
                                    class="btn btn-sm btn-outline-danger delete">
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
    {{-- <form data-action="{{ $payroll_url }}" method="post" id="payrollForm">
        @method("POST")
        @csrf
        <input type="text" name="date" id="payroll_date_input">
    </form> --}}
    <form data-action="{{ $payroll_url }}" method="post" id="payrollForm">
        @method("POST")
        @csrf
        <input type="text" name="date" id="payroll_date_input">
    </form>
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

  var table = $("table#payroll_data_table").DataTable({
    // "processing": true,
    // "serverSide": true,
    // "pagingType": "full_numbers",
    // "pageLength": 25,
    // "autoWidth": false,
    // "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

    // "ajax": {
    //     "url": "{{ $getDataTable }}", // Make sure this route is correct
    //     "type": "POST",
    //     "data": function(d) {
    //         d.date = $("#date").val();
    //         d._token = "{{ csrf_token() }}"; // Add CSRF token
    //     },
    //     "error": function(xhr, error, thrown) {
    //         console.log("DataTables Ajax error:");
    //         console.log(xhr.responseText);
    //         console.log(error);
    //         console.log(thrown);
    //     }
    // },
    // "columnDefs": [
    //     {
    //         'targets': [5],
    //         'searchable': false,
    //         'orderable': false,
    //         "className": "text-left"
    //     }
    // ],
    // "columns": [
    //     { "data": "DT_RowIndex", "name": "no.", "searchable": false },
    //     { "data": "detail_pegawai", "name": "detail pegawai" },
    //     { "data": "rekening", "name": "rekening" },
    //     { "data": "posisi", "name": "posisi" },
    //     { "data": "tanggal_pay", "name": "tanggal pay" },
    //     { "data": "gaji", "name": "gaji" },
    //     { "data": "tunjangan", "name": "tunjangan" },
    //     { "data": "pajak", "name": "pajak" },
    //     { "data": "potongan", "name": "potongan" },
    //     { "data": "status_payroll", "name": "status payroll" },
    //     { "data": "total_gaji", "name": "total gaji" },
    //     { "data": "action", "name": "action", "searchable": false, "orderable": false }
    // ]
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
