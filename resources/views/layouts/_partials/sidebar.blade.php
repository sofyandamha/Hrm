<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
           <img src="http://freshbox.tetambastudio.com/assets/img/logo-freshbox.png">
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
             <img src="http://freshbox.tetambastudio.com/assets/img/icon-freshbox.png" width="32px" height="32px">
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="menu-header">Menu</li>
                <li class="dropdown {{ Request::segment(2) === 'home'? 'active' : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                </li>
                <li class="dropdown {{ Request::segment(1) === 'department' ? 'active' : null }}">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-users-cog"></i> <span>Employee Management</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown  {{ Request::segment(1) === 'department' ? 'active' : null }}">
                            <a href="#" class="nav-link" > <span>Department</span></a>
                        </li>
                        <li class="dropdown  {{ Request::segment(1) === 'designation' ? 'active' : null }}">
                            <a href="#" class="nav-link" > <span>Designation</span></a>
                        </li>
                        <li class="dropdown  {{ Request::segment(1) === 'employee' ? 'active' : null }}">
                            <a href="#" class="nav-link" > <span>Manage Employee</span></a>
                        </li>
                        <li class="dropdown  {{ Request::segment(1) === 'termination' ? 'active' : null }}">
                            <a href="#" class="nav-link" > <span>Termination</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(1) === 'permanent' ? 'active' : null }}">
                            <a href="#" class="nav-link" > <span>Employee Permanent</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-user-clock"></i> <span>Attendance</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Manage Work Shift</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Report</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" ><i class="fas fa-money-bill-alt"></i> <span>Payroll</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Tax Rule Setup</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Late Configuration</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Allowance</span></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link" > <span>Deduction</span></a>
                        </li>
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
          </ul>
          </aside>
