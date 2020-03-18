<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts._partials.css')
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script>
    <title>Login</title>
</head>
<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
              <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                  <div class="login-brand">
                    <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                  </div>

                  <div class="card card-primary">
                    <div class="card-header"><h4>Login</h4></div>

                    <div class="card-body">
                      <form method="POST" action="{{ route('auth_login') }}" class="needs-validation" novalidate="">
                        @csrf

                        @if (session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>
                        @endif

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete='email' autofocus>

                          @error('email')
                            <div class="invalid-feedback">
                              {{ $msg }}
                            </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <div class="d-block">
                              <label for="password" class="control-label">Password</label>

                            @if (Route::has('password_request'))
                              <div class="float-right">
                                <a href="password_request" class="text-small">
                                  {{ __('Forgot Password?') }}
                                </a>
                              </div>
                            @endif
                          </div>
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="password" required>
                          @error('password')
                            <div class="invalid-feedback">
                              {{ @msg }}
                            </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }} id="remember-me">
                            <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>

        <footer class="main-footer" id="printPageButton" >
            @include('layouts._partials.footer')
        </footer>
    </div>

    @include('layouts._partials.js')
    @include('sweetalert::alert')
</body>
</html>
