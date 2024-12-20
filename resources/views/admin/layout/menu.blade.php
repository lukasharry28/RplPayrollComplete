<div class="nav-container">
    <nav id="main-menu-navigation" class="navigation-main">
        <div class="nav-item {{ request()->routeIs(['admin.dashboard']) ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
        </div>

        <div class="nav-lavel">Manage Site</div>
        <div class="nav-item has-sub {{ request()->routeIs('admin.position.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik ik-briefcase"></i><span>Positions</span>
                @if($counts['positions'] != 0)
                <span title="Total Records" class="badge badge-primary text-light">
                    {{ $counts['positions'] }}
                </span>
                @endif
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.position.create') }}"
                    class="menu-item {{ request()->routeIs('admin.position.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Position</a>
                <a href="{{ route('admin.position.index') }}"
                    class="menu-item {{ request()->routeIs('admin.position.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Position</a>
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('admin.schedule.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik clock ik-clock"></i><span>Schedules</span>
                @if($counts['schedules'] != 0)
                <span title="Total Records" class="badge badge-primary text-light">
                    {{ $counts['schedules'] }}
                </span>
                @endif
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.schedule.create') }}"
                    class="menu-item {{ request()->routeIs('admin.schedule.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Schedule</a>
                <a href="{{ route('admin.schedule.index') }}"
                    class="menu-item {{ request()->routeIs('admin.schedule.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Schedules</a>
            </div>
        </div>
        <div
            class="nav-item has-sub {{ request()->routeIs('admin.employee.*') ? 'active open' : '' }} {{ request()->routeIs('admin.overtime.*') ? 'active open' : '' }} {{ request()->routeIs('admin.cashadvance.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik users ik-users"></i><span>Employees</span>
                @if($counts['employees'] != 0)
                <span title="Total Records" class="badge badge-primary text-light">
                    {{ $counts['employees'] }}
                </span>
                @endif
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.employee.create') }}"
                    class="menu-item {{ request()->routeIs('admin.employee.create') ? 'active' : '' }}"><i
                        class="ik ik-user-plus"></i>Add New Employee</a>
                <a href="{{ route('admin.employee.index') }}"
                    class="menu-item {{ request()->routeIs('admin.employee.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Employees</a>
                {{-- <a href="{{ route('admin.overtime.index') }}"
                    class="menu-item {{ request()->routeIs('admin.overtime.*') ? 'active' : '' }}"><i
                        class="ik watch ik-watch"></i>Overtime</a>
                <a href="{{ route('admin.cashadvance.index') }}"
                    class="menu-item {{ request()->routeIs('admin.cashadvance.index') ? 'active' : '' }}"><i
                        class="ik at-sign ik-at-sign"></i>Cash Advance</a> --}}
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('admin.attendance.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik ik-check-circle"></i><span>Attendance</span>
                {{-- @if($counts['attendances'] != 0)
                <span title="Total Records" class="badge badge-danger text-light">
                    {{ $counts['attendances'] }}
                </span>
                @endif --}}
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.attendance.create') }}"
                    class="menu-item {{ request()->routeIs('admin.attendance.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Attendance</a>
                <a href="{{ route('admin.attendance.index') }}"
                    class="menu-item {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Attendance</a>
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('admin.deduction.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik file-minus ik-file-minus"></i><span>Deductions</span>
                @if($counts['deductions'] != 0)
                <span title="Total Records" class="badge badge-primary text-light">
                    {{ $counts['deductions'] }}
                </span>
                @endif
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.deduction.create') }}"
                    class="menu-item {{ request()->routeIs('admin.deduction.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Deduction</a>
                <a href="{{ route('admin.deduction.index') }}"
                    class="menu-item {{ request()->routeIs('admin.deduction.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Deductions</a>
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('admin.payroll.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik ik-dollar-sign"></i><span>Payroll</span>
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.payrollschedule.create') }}"
                    class="menu-item {{ request()->routeIs('admin.payrollschedule.create') ? 'active' : '' }}"><i
                        class="ik clock ik-clock"></i>Set Schedule Payroll</a>
                <a href="{{ route('admin.payrollschedule.index') }}"
                    class="menu-item {{ request()->routeIs('admin.payrollschedule.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>Jadwal Payroll</a>
                <a href="{{ route('admin.payroll.create') }}"
                    class="menu-item {{ request()->routeIs('admin.payroll.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Payroll</a>
                <a href="{{ route('admin.payroll.index') }}"
                    class="menu-item {{ request()->routeIs('admin.payroll.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>History</a>
            </div>
        </div>
        <div class="nav-lavel">Site Settings</div>
        {{-- <div class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <a href="{{ route('admin.profile.index') }}"><i class="ik user ik-user"></i><span>My Profile</span></a>
        </div> --}}
        <div class="nav-item has-sub {{ request()->routeIs('admin.rekening.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik credit-card ik-credit-card"></i><span>Rekening</span>
                {{-- @if($counts['rekenings'] != 0)
                <span title="Total Records" class="badge badge-primary text-light">
                    {{ $counts['rekenings'] }}
                </span>
                @endif --}}
            </a>
            <div class="submenu-content">
                <a href="{{ route('admin.rekening.create') }}"
                    class="menu-item {{ request()->routeIs('admin.rekening.create') ? 'active' : '' }}"><i
                        class="ik ik-plus-circle"></i>Add New Rekening</a>
                <a href="{{ route('admin.rekening.index') }}"
                    class="menu-item {{ request()->routeIs('admin.rekening.index') ? 'active' : '' }}"><i
                        class="ik file-text ik-file-text"></i>List Of Rekening</a>
            </div>
        </div>
        <div class="nav-item {{ request()->routeIs('admin.company.*') ? 'active' : '' }}">
            <a href=" {{ route('admin.company.index') }}"><i class="ik git-merge ik-git-merge"></i><span>Profile
                    Perusahan</span></a>
        </div>
        <div class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
            <a href=" {{ route('admin.user.index') }}"><i class="ik star ik-star-on"></i><span>User Admin</span></a>
        </div>
        {{-- <div class="nav-item {{ request()->routeIs('admin.company.*') ? 'active' : '' }}">
            <a href="{{ route('admin.company.index') }}"><i class="ik globe ik-globe"></i><span>Company</span></a>
        </div> --}}

        <div class="nav-item">
            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="ik log-out ik-log-out"></i><span class="text-danger">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

    </nav>
</div>
