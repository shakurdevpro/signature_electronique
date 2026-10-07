@extends('layouts.base')
@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{asset('img/illustrations/signature electronique2 2003.png')}}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="illustrations/jojo.png" data-app-dark-img="illustrations/auth-login-illustration-dark.html">

          <img src="{{asset('img/illustrations/bg-shape-image-light.png')}}" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.html">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand mb-4">
            <a href="#" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{asset('img/logo.jpg')}}" width="55%" height="auto">
               </span>
            </a>
          </div>
          <!-- /Logo -->
          <h3 class="mb-1 fw-bold">Bienvenue sur e-signature! 👋</h3>
          <!--<p class="mb-4">Please sign-in to your account and start the adventure</p>-->

          
            <form method="post" action="{{route('envoyer')}}" class="mb-3">
                @csrf
            <div class="mb-3">
              <label for="matricule" class="form-label">Matricule</label>
              <input type="text" class="form-control" id="matricule" name="matricule" placeholder="matricule" autofocus required>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{route('password.request')}}">
                        <small>Mot de passe oublié</small>
                    </a>
                @endif
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder=".............." aria-describedby="password"  required/>
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span-->
              </div>
            </div>

            <!-- div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Rester connecté
                </label>
              </div>
            </div !-->
            <button class="btn btn-primary d-grid w-100">Connexion</button>
          </form>
        <!--
          <div class="divider my-4">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons fa-brands fa-google fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
              <i class="tf-icons fa-brands fa-twitter fs-5"></i>
            </a>
          </div>
        -->
        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>

  <!-- / Content -->
@endsection



