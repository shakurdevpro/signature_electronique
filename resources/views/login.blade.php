@extends('layouts.auth')

@section('title', 'Connexion')

@section('styles')
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('signature/assets/css/dashlite.css?ver=2.4.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('signature/assets/css/theme.css?ver=2.4.0') }}">
@endsection

@section('content')

    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">

        <!-- Mobile Info Button -->
        <div class="absolute-top-right d-lg-none p-3 p-sm-5">
            <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"
                aria-label="Afficher les informations">
                <em class="icon ni ni-info"></em>
            </a>
        </div>

        <!-- Authentication Body -->
        <div class="nk-block nk-block-middle nk-auth-body">

            <!-- Logo -->
            <div class="brand-logo pb-5">
                <a href="{{ route('login') }}" class="logo-link">
                    <img class="logo-light logo-img logo-img-lg" src="{{ asset('signature/images/logo-mfp.png') }}"
                        srcset="{{ asset('signature/images/logo-mfp.png') }} 2x" alt="Logo Signature">
                    <img class="logo-dark logo-img logo-img-lg" src="{{ asset('signature/images/logo-mfp.png') }}"
                        srcset="{{ asset('signature/images/logo-mfp.png') }} 2x" alt="Logo Signature - Mode sombre">
                </a>
            </div>

            <!-- Header -->
            <div class="nk-block-head">
                <div class="nk-block-head-content">

                    <h5 class="nk-block-title">
                        Connexion à E-Signature
                    </h5>

                    <div class="nk-block-des">
                        <p>
                            Veuillez renseigner votre matricule et votre mot de passe afin d'accéder à votre espace.
                        </p>
                    </div>

                </div>
            </div>
            <!-- .nk-block-head -->

            <!-- Login Form -->
            <form action="{{ route('envoyer') }}" method="post">
                @csrf
                <!-- Username -->
                <div class="form-group">

                    <div class="form-label-group">

                        <label class="form-label" for="matricule">
                            Matricule
                        </label>


                    </div>

                    <input type="text" class="form-control form-control-lg" id="matricule" name="matricule"
                        placeholder="Entrez votre matricule" autofocus required oninput="convertirEnMajuscules(this)">

                </div>
                <!-- .form-group -->

                <!-- Password -->
                <div class="form-group">

                    <div class="form-label-group">

                        <label class="form-label" for="password">
                            Mot de passe
                        </label>

                        <a class="link link-primary link-sm" tabindex="-1" href="#">
                            Mot de passe oublié ?
                        </a>

                    </div>

                    <div class="form-control-wrap">

                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch"
                            data-target="password" aria-label="Afficher ou masquer le mot de passe">

                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>

                        </a>

                        <input type="password" id="password" class="form-control form-control-lg" name="password"
                            placeholder="Entrez votre mot de passe" aria-describedby="password" required>

                    </div>

                </div>
                <!-- .form-group -->

                <!-- Submit -->
                <div class="form-group">

                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                        Se connecter
                    </button>

                </div>

            </form>
            <!-- form -->

            <!-- Register -->
            <div class="form-note-s2 pt-4">
                Un souci ?
                <a href="https://www.fonctionpublique.gouv.ci/index.php/front-page/navigator/contact" target="_blank">
                    Contactez le support technique
                </a>
            </div>



        </div>
        <!-- .nk-block -->

        <!-- ============================= -->
        <!-- BEGIN: Footer -->
        <!-- ============================= -->

        <div class="nk-block nk-auth-footer">

            <div class="nk-block-between">

                <ul class="nav nav-sm">

                    <!-- Terms -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Conditions d'utilisation
                        </a>
                    </li>

                    <!-- Privacy -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Politique de confidentialité
                        </a>
                    </li>



                </ul>
                <!-- .nav -->

            </div>
            <div class="mt-3">
                <p>
                    &copy; {{ date('Y') }} Signature. Tous droits réservés.
                </p>

            </div>

        </div>
        <!-- .nk-block -->

    </div>
    <!-- .nk-split-content -->
@endsection

@section('scripts')
    <!-- JavaScript -->
    <script src="{{ asset('signature/assets/js/bundle.js?ver=2.4.0') }}"></script>
    <script src="{{ asset('signature/assets/js/scripts.js?ver=2.4.0') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alert-message').fadeOut('fast');
            }, 10000);
        });
    </script>
    <script>
        function convertirEnMajuscules(input) {
            input.value = input.value.toUpperCase();
        }
    </script>
    <script>
        const inputMotDePasse = document.getElementById("password");
        const boutonAfficher = document.getElementById("affiche");

        boutonAfficher.addEventListener("click", () => {
            if (inputMotDePasse.type === "password") {
                inputMotDePasse.type = "text";
                boutonAfficher.innerHTML = '<i class="ti ti-eye"></i>';
            } else {
                inputMotDePasse.type = "password";
                boutonAfficher.innerHTML = '<i class="ti ti-eye-off"></i>';
            }
        });
    </script>
@endsection