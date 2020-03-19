<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
           <img src="http://freshbox.tetambastudio.com/assets/img/logo-freshbox.png">
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
             <img src="http://freshbox.tetambastudio.com/assets/img/icon-freshbox.png" width="32px" height="32px">
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

          <li class="menu-header">Menu {{Auth()->user()->getRoleNames()}}</li>
                <li class="dropdown {{ Request::segment(2) === 'home'? 'active' : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                </li>
                <li class="dropdown {{ Request::segment(2) === 'requestApp' || Request::segment(2) === 'leaveReport' ? 'active' : null }} ">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-sign-out-alt"></i> <span>Leave Management</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown {{ Request::segment(2) === 'requestApp' ? 'active' : null }}">
                            <a href="{{ route('show_requestApp') }}" class="nav-link" > <span>Request Application</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'leaveReport' ? 'active' : null }}">
                            <a href="route('show_leaveReport')" class="nav-link" > <span>Leave Report</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-user-clock"></i> <span>Attendance</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown {{ Request::segment(2) === 'workshift' ? 'active' : null }}">
                            <a href="{{ route('show_workshift') }}" class="nav-link" > <span>Manage Work Shift</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'report' ? 'active' : null }}">
                            <a href="{{ route('show_report') }}" class="nav-link" > <span>Attendance Report</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-money-bill-alt"></i> <span>Payroll</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Monthly Pay Grade</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Hourly Pay Grade</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Payment History</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-street-view"></i> <span>Recruitement</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Job Post</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Job Candidate</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Notice Board</span></a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown {{ Request::segment(1) === 'schedule' ? 'active' : null }}">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-calendar-alt"></i> <span>Scheduling</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown {{ Request::segment(1) === 'schedule' ? 'active' : null }}">
                            <a href="{{ route('show_schedule') }}" class="nav-link" > <span>Schedule</span></a>
                        </li>
                    </ul>
                </li>

                @role('Super Admin')
                <li class="dropdown {{ Request::segment(1) === 'department' || Request::segment(1) === 'employee' || Request::segment(1) === 'payroll' || Request::segment(1) === 'leaveType' || Request::segment(1) === 'status' || Request::segment(1) === 'workingTime' ? 'active' : null }}">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-server"></i> <span>Master Data</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown {{Request::segment(1) === 'department' ? 'active' : null}}">
                            <a href="{{route('show_department')}}" class="nav-link" > <span>Department</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'employee' ? 'active' : null}}">
                            <a href="{{route('show_employee')}}" class="nav-link" > <span>Employee</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'payroll' ? 'active' : null}}">
                            <a href="{{route('show_taxsetup')}}" class="nav-link" > <span>Payroll</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'leaveType' ? 'active' : null}}">
                            <a href="{{route('show_leaveType')}}" class="nav-link" > <span>Leave Type</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'status' ? 'active' : null}}">
                            <a href="{{route('show_statusEmployee')}}" class="nav-link" > <span>Status Employee</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'workingTime' ? 'active' : null}}">
                            <a href="{{route('show_workingTime')}}" class="nav-link" > <span>Working Time</span></a>
                        </li>
                    </ul>
                </li>
                @endrole
          </ul>
          </aside>
