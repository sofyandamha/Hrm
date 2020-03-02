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
                    <a href="{{ route('home') }}" class="nav-link" ><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                </li>
            @if (auth()->user()->role_id  == 1)
                <li class="dropdown {{ Request::segment(2) === 'resume'? 'active' : null }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Administrator</span></a>
                    <ul class="dropdown-menu">
                    <li class="{{  Request::segment(2) === 'resume' ? 'active' : null }}"><a class="nav-link" href="{{ route('resume') }}">Data Price</a></li>
                    </ul>
                </li>
            @elseif(auth()->user()->role_id  == 2)
                <li class="dropdown {{ Request::segment(2) === 'addprice'? 'active' : null }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bullhorn"></i> <span>Vendor</span></a>
                    <ul class="dropdown-menu">
                    <li class="{{  Request::segment(2) === 'addprice' ? 'active' : null }}"><a class="nav-link" href="{{ route('add_price') }}">Add Price</a></li>
                    </ul>
                </li>
            @endif
          </ul>
          </aside>
