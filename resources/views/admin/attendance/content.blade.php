<!--data here-->
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">
    <!--Live Attendance Data-->
    <div class="card-header">
        <div class="col-md-3 d-block">
            <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left">
                <i class="ik plus-square ik-plus-square"></i> Create New Attendance
            </a>
        </div>
        <!-- Filter Grouping Dropdown -->
        <div class="col-md-3">
            <select id="groupFilter" class="form-control">
                <option value="">Select Grouping</option>
                <option value="date">Date</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
                <option value="ontime">On Time</option>
                <option value="late">Late</option>
            </select>
        </div>

        <!-- Input untuk filter Date -->
        <div class="col-md-2" id="dateInput" style="display: none;">
            <input type="date" id="filterDate" class="form-control" placeholder="Select Date">
        </div>

        <!-- Input untuk filter Month -->
        <div class="col-md-2" id="monthInput" style="display: none;">
            <input type="month" id="filterMonth" class="form-control" placeholder="Select Month">
        </div>

        <!-- Input untuk filter Year -->
        <div class="col-md-2" id="yearInput" style="display: none;">
            <input type="number" id="filterYear" class="form-control" placeholder="Enter Year" min="1900" max="2099">
        </div>

        <div class="action col-md-1 mt-2">
            <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table id="overtime_data_table" class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Employee Details</th>
              <th>Time In</th>
              <th>Time Out</th>
              <th>Working Hour</th>
              <th>Actions</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
    </div>
    <!--End Live Attendance Data-->

  </div>
</div>
<!--End data here-->

<script type="text/javascript">
    // Setup CSRF Token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // Inisialisasi DataTable dengan opsi
        var attendanceDataTable = $("table#overtime_data_table").DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "pageLength": 25,
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "ajax": {
                "url": "{{ $getDataTable }}",
                "type": "POST",
                "data": function(d) {
                    // Kirim nilai filter yang dipilih
                    d.groupBy = $('#groupFilter').val();
                    d.filterDate = $('#filterDate').val();
                    d.filterMonth = $('#filterMonth').val();
                    d.filterYear = $('#filterYear').val();
                },
                "error": function(xhr, error, thrown) {
                    console.log("Error: " + error);
                    console.log("Thrown Error: " + thrown);
                    console.log("Response Text: " + xhr.responseText);
                },
            },
            "columnDefs": [
                {
                'targets': 6,
                'searchable':false,
                'orderable':false,
                'render': function (data, type, full, meta){
                return "<div class='custom-control custom-checkbox pl-1 align-self-center'><label class='custom-control custom-checkbox mb-0'><input type='checkbox' class='custom-control-input sub_chk' data-id='"+$('<div/>').text(data).html()+"'><span class='custom-control-label'></span></label></div>";
                }
            },
            {
                'targets': [0,4,5,6],
                'searchable':false,
                'orderable':false,
                "className": "text-center"
            }
            ],
            "columns": [
                { "data": "date", "className": "text-center" },
                { "data": "employee" },
                { "data": "time_in_details" },
                { "data": "time_out" },
                { "data": "work_hr", "className": "text-center" },
                { "data": "action", "className": "text-center" },
                { "data": "id", "searchable": false, "orderable": false }
            ]
        });

        // Event listener untuk dropdown filter dan setiap input filter
        $('#groupFilter, #filterDate, #filterMonth, #filterYear').on('change', function() {
            attendanceDataTable.ajax.reload(null, false); // Reload data tanpa reset pagination
        });

        // Tampilkan input filter sesuai pilihan
        $('#groupFilter').on('change', function() {
            var selectedFilter = $(this).val();
            $('#dateInput, #monthInput, #yearInput').hide(); // Sembunyikan semua

            // Tampilkan elemen input sesuai pilihan filter
            if (selectedFilter === 'date') {
                $('#dateInput').show();
            } else if (selectedFilter === 'month') {
                $('#monthInput').show();
            } else if (selectedFilter === 'year') {
                $('#yearInput').show();
            }
        });
    });
</script>


