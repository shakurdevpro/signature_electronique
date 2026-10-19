<!-- main header-->
<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                        class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/index.html" class="logo-link">
                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x"
                        alt="logo">
                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x"
                        alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-news ml-3 ml-xl-0">
                <div class="d-flex align-items-center">
                    <em class="icon ni ni-signature mr-2 text-primary"></em>
                    <div>
                        <div class="text-dark-green font-weight-bold">
                            Bienvenue sur la plateforme e-Signature
                        </div>
                        <div class="text-soft fs-12px d-none d-md-block">
                            Votre espace sécurisé pour la gestion et la signature électronique des actes administratifs.
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">


                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <img src="{{ asset('img/avatars/1.jpg') }}" alt="Photo de profil"
                                        class="rounded-circle">
                                </div>

                                <div class="user-info d-none d-xl-block">
                                    <div class="user-status user-status-unverified">
                                        Connecté
                                    </div>
                                    <div class="user-name dropdown-indicator">
                                        @php echo utf8_encode($info['NOM PRENOMS']); @endphp
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <img src="{{ asset('img/avatars/1.jpg') }}" alt="Photo de profil"
                                            class="rounded-circle">
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">@php echo utf8_encode($info['NOM PRENOMS']); @endphp</span>
                                        <span class="sub-text">{{ $info['FONCTION'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="html/user-profile-regular.html"><em
                                                class="icon ni ni-user-alt"></em><span>
                                                Informations du compte</span></a></li>
                                    <li><a href="html/user-profile-setting.html"><em
                                                class="icon ni ni-setting-alt"></em><span>Paramètres du compte
                                            </span></a></li>

                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{ route('logout') }}"><em
                                                class="icon ni ni-signout"></em><span>Déconnexion</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header -->
