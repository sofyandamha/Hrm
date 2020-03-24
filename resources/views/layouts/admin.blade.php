<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    @yield('title')
    @include('layouts._partials.css')
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1"  >
            <div class="navbar-bg bg-danger"></div>
            <nav class="navbar navbar-expand-lg main-navbar" id="printPageButton" >
                <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                          <div class="dropdown-header">Notifications
                            <div class="float-right">
                              <a href="#">Mark All As Read</a>
                            </div>
                          </div>
                          <div class="dropdown-list-content dropdown-list-icons">
                            <a href="#" class="dropdown-item dropdown-item-unread">
                              <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-code"></i>
                              </div>
                              <div class="dropdown-item-desc">
                                Template update is available now!
                                <div class="time text-primary">2 Min Ago</div>
                              </div>
                            </a>
                            <a href="#" class="dropdown-item">
                              <div class="dropdown-item-icon bg-info text-white">
                                <i class="far fa-user"></i>
                              </div>
                              <div class="dropdown-item-desc">
                                <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                                <div class="time">10 Hours Ago</div>
                              </div>
                            </a>
                            <a href="#" class="dropdown-item">
                              <div class="dropdown-item-icon bg-success text-white">
                                <i class="fas fa-check"></i>
                              </div>
                              <div class="dropdown-item-desc">
                                <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                                <div class="time">12 Hours Ago</div>
                              </div>
                            </a>
                            <a href="#" class="dropdown-item">
                              <div class="dropdown-item-icon bg-danger text-white">
                                <i class="fas fa-exclamation-triangle"></i>
                              </div>
                              <div class="dropdown-item-desc">
                                Low disk space. Let's clean it!
                                <div class="time">17 Hours Ago</div>
                              </div>
                            </a>
                            <a href="#" class="dropdown-item">
                              <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                              </div>
                              <div class="dropdown-item-desc">
                                Welcome to Stisla template!
                                <div class="time">Yesterday</div>
                              </div>
                            </a>
                          </div>
                          <div class="dropdown-footer text-center">
                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                          </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth()->user()->full_name}}</div></a>
                        <div class="dropdown-menu dropdown-menu-right ">
                        <div class="dropdown-title">Welcome, {{ Auth()->user()->full_name}}</div>

                        <div class="dropdown-divider"></div>
                            <a href="{{ route('show_profile',Auth()->user()->id) }}" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <form id="logout-form" action="#" method="POST" style="display: none;">
            @csrf
            </form>

            <div class="main-sidebar sidebar-style-2 " id="printPageButton" >
                @include('layouts._partials.sidebar')
            </div>

        <!-- Main Content -->
            <div class="main-content">
                @if (session('status'))
                    <div class="alert alert-warning">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </div>

            <footer class="main-footer" id="printPageButton" >
                @include('layouts._partials.footer')
            </footer>

        </div>
    </div>
    @include('layouts._partials.js')
    @include('sweetalert::alert')
</body>
</html>
