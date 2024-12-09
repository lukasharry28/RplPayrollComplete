<!--Live Deduction Data-->
<div class="card-header">
    <div class="col-md-6 d-block">
        <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i>
            Create User Admin</a>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply"
            disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
    </div>
</div>

<div class="card-body table-responsive p-0">
  <table id="state_data_table" class="table mb-0 table-hover">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Avatar</th>
                <th width="350" class="text-left">Email</th>
                <th width="200" >Username</th>
                <th width="200">Role</th>
                <th >Actions</th>
                <th >
                    <div class="custom-control custom-checkbox pl-1 align-self-center">
                        <label class="custom-control custom-checkbox mb-0" title="Select All" data-toggle="tooltip"
                            data-placement="right">
                            <input type="checkbox" class="custom-control-input" id="master">
                            <span class="custom-control-label"></span>
                        </label>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td class="text-center">
                    {{ ($loop->index + 1) }}
                  </td>
                <td style="text-align: center; vertical-align: middle;">
                    <p>
                        <img src="{{ asset('admin_assets/avatars/admin/' . strtolower($admin->image) . '.png') }}"
                             alt="{{ $admin->image }}"
                             style="width: 50px; object-fit: cover; display: block; margin: 0 auto;">
                    </p>
                </td>

                <td class="text-left">
                    <p>{{ $admin->email }}</p>
                </td>
                <td>
                    <p>{{ $admin->username }}</p>
                </td>
                <td>
                    <code class="pc">{{ $admin->role }}</code>
                </td>
                <td>
                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                        <a href="{{ route('admin.user.edit',['admin'=>$admin]) }}" type="button"
                            class="btn btn-sm btn-outline-primary">
                            <i class="ik edit-2 ik-edit-2"></i>
                        </a>
                        <a data-href="{{ route('admin.user.destroy',['admin'=>$admin]) }}" type="button"
                            class="btn btn-sm btn-outline-danger delete">
                            <i class="ik trash-2 ik-trash-2"></i>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="custom-control custom-checkbox pl-1 align-self-center">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input sub_chk" data-id="{{$admin->id}}">
                            <span class="custom-control-label"></span>
                        </label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!--EndLive Deduction Data-->
