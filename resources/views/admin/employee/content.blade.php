<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">

      <!-- Header Section -->
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <a href="{{ $add_new }}" class="btn btn-sm btn-dark">
              <i class="ik ik-user-plus"></i> Create New Employee
            </a>
          </div>
          <div class="col-md-6 text-right">
            <button type="submit"
                    class="btn btn-primary mb-2 h-33 move-to-delete-all"
                    id="apply"
                    disabled
                    data-href="{{ $moveToTrashAllLink }}">
              Action
            </button>
          </div>
        </div>
      </div>
      <!-- End Header Section -->

      <!-- Table Section -->
      <div class="card-body table-responsive">
        <table id="employee_data_table" class="table table-striped">
          <thead>
            <tr>
              <th>Avatar</th>
              <th>Name</th>
              <th>Biodata</th>
              <th>Kontak</th>
              <th>Position</th>
              <th>Details</th>
              <th width="40">Status Pegawai</th>
              <th>Actions</th>
              <th>Select</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $employee)
            <tr>
              <td>
                <img src="{{ $employee->mediaUrl['thumb'] }}" alt="Avatar" class="table-user-thumb">
              </td>
              <td>{{ $employee->first_name. ' ' .$employee->last_name }}</td>
              <td>
                <div>
                  <b>Gender:</b> <span>{{ $employee->gender }}</span><br>
                  <b>Agama:</b> <span>{{ $employee->agama }}</span><br>
                  <b>Golongan Darah:</b> <span>{{ $employee->gol_darah }}</span><br>
                  <b>Tanggal Lahir:</b> <span>{{ $employee->tgl_lahir }}</span><br>
                  <b>Tempat Lahir:</b> <span>{{ $employee->tmp_lahir }}</span><br>
                  <b>Status Menikah:</b> <span>{{ $employee->status_nikah }}</span><br>
                </div>
              </td>
              <td>
                <div>
                  <b>Phone:</b> <span>{{ $employee->phone }}</span><br>
                  <b>Email:</b> <span>{{ $employee->email }}</span><br>
                </div>
              </td>
              <td>{{ $employee->position->title }}</td>
              <td>
                <div>
                  <b>Employee Id:</b> <span>{{ $employee->employee_id }}</span><br>
                  <b>Status Kerja:</b> <span>{{ $employee->status_kerja }}</span><br>
                  <b>Schedule:</b>
                    <span>{{ $employee->schedule->time_in }} - {{ $employee->schedule->time_out }}</span><br>
                  <b>Address:</b> <span>{{ $employee->address }}</span><br>
                </div>
              </td>
              <td>
                @if($employee->is_active == 1)
                  <span class="success-dot" title="Published"></span>
                @else
                  <i class="ik ik-alert-circle text-danger" title="In-Active Employee"></i>
                @endif
              </td>
              <td>
                <div class="table-actions">
                  {{--<a href=# "{{ route('admin.employee.show', ['employee_id' => $employee->employee_id]) }}" class="show-employee">
                    <i class="ik ik-eye text-primary"></i>
                  </a>  --}}
                  <a href="{{ route('admin.employee.edit', ['employee_id' => $employee->employee_id]) }}">
                    <i class="ik ik-edit-2 text-dark"></i>
                  </a>
                  <a href="#"
                     class="delete"
                     data-href="{{ route('admin.employee.destroy', ['id' => $employee->id]) }}">
                    <i class="ik ik-trash-2 text-danger"></i>
                  </a>
                </div>
              </td>
              <td>
                <div class="custom-control custom-checkbox pl-1 align-self-center">
                   <label class="custom-control custom-checkbox mb-0">
                     <input type="checkbox" class="custom-control-input sub_chk" data-id="{{$employee->id}}">
                     <span class="custom-control-label"></span>
                   </label>
                 </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center">No employees found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- End Table Section -->

    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#employee_data_table").DataTable();
    });
  </script>
