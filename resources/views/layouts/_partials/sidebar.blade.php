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
                <li class="dropdown {{ Request::segment(2) === 'employe'? : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Employee Management</span></a>
                    <ul>
                        <li class="dropdown {{ Request::segment(2) === 'department'? : null }}">
                            <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Department</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'designation'? : null }}">
                            <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Designation</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'manageemployee'? : null }}">
                            <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Manage Employee</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'termination'? : null }}">
                            <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Termination</span></a>
                        </li>
                        <li class="dropdown {{ Request::segment(2) === 'employeepermanent'? : null }}">
                            <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Employee Permanent</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown {{ Request::segment(2) === 'attandance'? 'active' : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Attandance</span></a>
                </li>
                <li class="dropdown {{ Request::segment(2) === 'payroll'? 'active' : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Payroll</span></a>
                </li>
                <li class="dropdown {{ Request::segment(2) === 'recruitement'? 'active' : null }}">
                    <a href="#" class="nav-link" ><i class="fas fa-fire"></i> <span>Recruitement</span></a>
                </li>
          </ul>
          </aside>
