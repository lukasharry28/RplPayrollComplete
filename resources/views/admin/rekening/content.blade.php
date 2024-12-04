<!--Live Rekening Data-->
<div class="card-header">
  <div class="col-md-3 d-block">
    <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i> Add Rekening</a>
  </div>
  {{-- <div class="col-md-3">
    <select id="groupFilter" class="form-control">
        <option value="">Select Grouping</option>
        <option value="rekening perusahaan">Rekening Perusahaan</option>
        <option value="rekening pegawai">Rekening Pegawai</option>
        <option value="2">BNI</option>
        <option value="1">BCA</option>
        <option value="3">BRI</option>
        <option value="5">Mandiri</option>
        <option value="6">Mayapada</option>
        <option value="4">Danamon</option>
    </select>
</div> --}}

<div class="action col-md-9 mt-2 ">
    <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
</div>
</div>


<div class="card-body table-responsive p-0">
  <table id="state_data_table" class="table mb-0 table-hover">
    <thead>
      <tr>
        <th class="text-center">No.</th>
        <th class="text-center">No Rekening</th>
        <td>Pemilik Rekening</td>
        <th>Nama Rekening</th>
        <th>Type Rekening</th>
        <th class="text-center">Saldo</th>
        <th>Bank</th>
        <th>Actions</th>
        <th>
          <div class="custom-control custom-checkbox pl-1 align-self-center">
            <label class="custom-control custom-checkbox mb-0" title="Select All" data-toggle="tooltip" data-placement="right">
              <input type="checkbox" class="custom-control-input" id="master">
              <span class="custom-control-label"></span>
            </label>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach($rekenings as $rekening)
      <tr>
        <td class="text-center">
          {{ ($loop->index + 1) }}
        </td>
        <td>
          <div class="text-center">
            <span><b>{{ $rekening->no_rekening }}</b></span>
          </div>
        </td>
        <td>
            <div>
              <span><b>{{ $rekening->nama_pemilik }}</b></span>
            </div>
          </td>
        <td>
            <p>{{ $rekening->rekening_name }}</p>
        </td>
        <td>
            <code class="pc">{{ $rekening->type_rekening }}</code>
          {{-- <p>{{ $rekening->type_rekening }}</p> --}}
        </td>
        <td width="180" class="text-right">
            <span><b>Rp {{ number_format($rekening->saldo, 2, ',', '.') }}</b></span>
        </td>
        {{-- <td>
            <p>{{ $rekening->bank->bank_name }}</p>
        </td> --}}
        <td>
            <p>
                <img src="{{ asset('admin_assets/avatars/bank/' . strtolower($rekening->bank->image_name) . '.png') }}"
                     alt="{{ $rekening->bank->bank_name }}"
                     style="width: 50px; object-fit: cover; margin-right: 10px;">
                     {{ $rekening->bank->bank_name }}
            </p>
        </td>
        <td>
            <div class="btn-group btn-sm" role="group" aria-label="Basic example">
              <a href="{{ route('admin.rekening.edit',['rekening'=>$rekening]) }}" type="button" class="btn btn-sm btn-outline-primary">
                <i class="ik edit-2 ik-edit-2"></i>
              </a>
              <a data-href="{{ route('admin.rekening.destroy',['rekening'=>$rekening]) }}" type="button" class="btn btn-sm btn-outline-danger delete">
                <i class="ik trash-2 ik-trash-2"></i>
              </a>
            </div>
        </td>
        <td>
          <div class="custom-control custom-checkbox pl-1 align-self-center">
            <label class="custom-control custom-checkbox mb-0">
              <input type="checkbox" class="custom-control-input sub_chk" data-id="{{$rekening->id_rekening}}">
              <span class="custom-control-label"></span>
            </label>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
    {{-- <tfoot>
      <tr>
        <td colspan="6" class="text-right">
          <h6>Total Rekening : <span class="text-danger">Rp {{ number_format($sum, 2, ',', '.') }}</span> </h6>
        </td>
      </tr>
    </tfoot> --}}
  </table>
</div>
<!--EndLive Rekening Data-->


{{-- <script type="text/javascript">
    // Setup CSRF Token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var rekeningDataTable = $("table#rekening_data_table").DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "pageLength": 25,
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "ajax": {
                "url": "{{ $get_data }}",
                "type": "POST",
                "data": function(d) {
                    d.groupFilter = $('#groupFilter').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error("Error: " + error);
                    console.error("Thrown Error: " + thrown);
                    console.error("Response Text: " + xhr.responseText);
                },
            },
            "columnDefs": [
                {
                    'targets': 6,
                    'searchable': false,
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return "<div class='custom-control custom-checkbox pl-1 align-self-center'>" +
                            "<label class='custom-control custom-checkbox mb-0'>" +
                            "<input type='checkbox' class='custom-control-input sub_chk' data-id='" + $('<div/>').text(data).html() + "'>" +
                            "<span class='custom-control-label'></span></label></div>";
                    }
                },
                {
                    'targets': [0, 4, 5, 6],
                    'searchable': false,
                    'orderable': false,
                    "className": "text-center"
                }
            ],
            "columns": [
                { "data": "rekening_number", "className": "text-center" },
                { "data": "rekening_name" },
                { "data": "bank_name" },
                { "data": "saldo" },
                { "data": "action", "className": "text-center" },
                { "data": "id", "searchable": false, "orderable": false }
            ]
        });

        $('#groupFilter').on('change', function() {
            rekeningDataTable.ajax.reload(null, false);
        });

        function toggleFilterInputs(selectedValue) {
            if (selectedValue === 'rekening perusahaan' || selectedValue === 'rekening pegawai') {
                console.log("Filtering for type rekening: " + selectedValue);
            } else if (['2', '1', '3', '5', '6', '4'].includes(selectedValue)) {
                console.log("Filtering for id bank: " + selectedValue);
            }
        }

        $('#groupFilter').on('change', function() {
            toggleFilterInputs($(this).val());
        });
    });
</script> --}}


