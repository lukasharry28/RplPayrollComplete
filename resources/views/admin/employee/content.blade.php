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
              <th>First Name</th>
              <th>Last Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Position</th>
              <th>Details</th>
              <th>Publish</th>
              <th>Actions</th>
              <th>
                <div class="custom-control custom-checkbox pl-1 align-self-center">
                  <input type="checkbox" class="custom-control-input" id="dt-live-select-all">
                  <label class="custom-control-label" for="dt-live-select-all"></label>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $employee)
            <tr>
              <td>
                <img src="{{ $employee->mediaUrl['thumb'] }}" alt="Avatar" class="table-user-thumb">
              </td>
              <td>{{ $employee->first_name }}</td>
              <td>{{ $employee->last_name }}</td>
              <td>{{ $employee->phone }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ $employee->position->title }}</td>
              <td>
                <div>
                  <b>Gender:</b> <span>{{ $employee->gender }}</span><br>
                  <b>Employee Id:</b> <span>{{ $employee->employee_id }}</span><br>
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
                  <a href="{{ route('admin.employee.show', ['employee_id' => $employee->employee_id]) }}" class="show-employee">
                    <i class="ik ik-eye text-primary"></i>
                  </a>
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
                  <input type="checkbox"
                         class="custom-control-input sub_chk"
                         id="select-{{ $employee->id }}"
                         data-id="{{ $employee->id }}">
                  <label class="custom-control-label" for="select-{{ $employee->id }}"></label>
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
