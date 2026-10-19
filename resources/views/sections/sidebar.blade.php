 <!-- Sidebar -->
 <div class="nk-sidebar nk-sidebar-fixed is-light" data-content="sidebarMenu">

     <!-- Sidebar Head -->
     <div class="nk-sidebar-element nk-sidebar-head">

         <div class="nk-sidebar-brand">
             <a href="{{ route('accueil') }}" class="logo-link nk-sidebar-logo">

                 <img class="logo-light logo-img" src="{{ asset('signature/images/favicon.png') }}"
                     srcset="{{ asset('signature/images/favicon.png') }} 2x" alt="logo">

                 <img class="logo-dark logo-img" src="{{ asset('signature/images/favicon.png') }}"
                     srcset="{{ asset('signature/images/favicon.png') }} 2x" alt="logo-dark">

                 <img class="logo-small logo-img logo-img-small" src="{{ asset('signature/images/favicon.png') }}"
                     srcset="{{ asset('signature/images/favicon.png') }} 2x" alt="logo-small">

             </a>
         </div>

         <div class="nk-menu-trigger mr-n2">

             <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">

                 <em class="icon ni ni-arrow-left"></em>

             </a>

             <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                 data-target="sidebarMenu">

                 <em class="icon ni ni-menu"></em>

             </a>

         </div>

     </div>
     <!-- .nk-sidebar-element -->


     <div class="nk-sidebar-element">

         <div class="nk-sidebar-content">

             <div class="nk-sidebar-menu" data-simplebar>

                 <ul class="nk-menu">


                     {{-- ========================================================= --}}
                     {{-- ACCUEIL --}}
                     {{-- ========================================================= --}}

                     <li class="nk-menu-heading">
                         <h6 class="overline-title text-primary-alt">
                             Accueil
                         </h6>
                     </li>


                     {{-- Tableau de bord --}}

                     <li class="nk-menu-item {{ request()->routeIs('accueil') ? 'active' : '' }}">

                         <a href="{{ route('accueil') }}" class="nk-menu-link">

                             <span class="nk-menu-icon">
                                 <em class="icon ni ni-activity-round-fill"></em>
                             </span>

                             <span class="nk-menu-text">
                                 Tableau de bord
                             </span>

                         </a>

                     </li>


                     {{-- ========================================================= --}}
                     {{-- GESTION DES SIGNATURES --}}
                     {{-- ========================================================= --}}

                     <li class="nk-menu-heading">
                         <h6 class="overline-title text-primary-alt">
                             Gestion des signatures
                         </h6>
                     </li>


                     {{--
                        Ancienne condition PHP :

                        if (
                            $info['LOGINUSER'] != 'T279354' &&
                            $info['LOGINUSER'] != 'E319795' &&
                            $info['LOGINUSER'] != 'K349954' &&
                            $info['LOGINUSER'] != 'H388545'
                        )
                    --}}

                     @if (
                         $info['LOGINUSER'] != 'T279354' &&
                             $info['LOGINUSER'] != 'E319795' &&
                             $info['LOGINUSER'] != 'K349954' &&
                             $info['LOGINUSER'] != 'H388545')
                         {{-- Instance de signature --}}

                         <li class="nk-menu-item {{ request()->routeIs('instance') ? 'active' : '' }}">

                             <a href="{{ route('instance') }}" class="nk-menu-link">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-file-text-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     Instances de signature
                                 </span>

                             </a>

                         </li>


                         {{-- Tous les actes signés --}}

                         <li class="nk-menu-item {{ request()->routeIs('tous_signe') ? 'active' : '' }}">

                             <a href="{{ route('tous_signe') }}" class="nk-menu-link">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-check-circle-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     Actes signés
                                 </span>

                             </a>

                         </li>
                     @endif


                     {{-- Statistiques : accessible à tous --}}

                     <li class="nk-menu-item {{ request()->routeIs('signe') ? 'active' : '' }}">

                         <a href="{{ route('signe') }}" class="nk-menu-link">

                             <span class="nk-menu-icon">
                                 <em class="icon ni ni-bar-chart-fill"></em>
                             </span>

                             <span class="nk-menu-text">
                                 Statistiques
                             </span>

                         </a>

                     </li>


                     {{-- ========================================================= --}}
                     {{-- ESPACES INSTITUTIONNELS --}}
                     {{-- ========================================================= --}}

                     {{--
                        Ancienne condition PHP :

                        if (
                            $info['LOGINUSER'] == 'X505234'
                            OR $info['LOGINUSER'] == 'T279354'
                            OR $info['LOGINUSER'] == 'Z444473'
                        )
                    --}}

                     @if ($info['LOGINUSER'] == 'X505234' || $info['LOGINUSER'] == 'T279354' || $info['LOGINUSER'] == 'Z444473')
                         <li class="nk-menu-heading">
                             <h6 class="overline-title text-primary-alt">
                                 Espaces institutionnels
                             </h6>
                         </li>


                         {{-- ===================================================== --}}
                         {{-- MINISTRE --}}
                         {{-- ===================================================== --}}

                         <li
                             class="nk-menu-item has-sub
                            {{ request()->routeIs('accueil.min', 'sat.min') ? 'active' : '' }}">

                             <a href="#" class="nk-menu-link nk-menu-toggle">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-user-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     MINISTRE
                                 </span>

                             </a>


                             <ul class="nk-menu-sub">

                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('accueil.min') ? 'active' : '' }}">

                                     <a href="{{ route('accueil.min') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Tableau de bord
                                         </span>

                                     </a>

                                 </li>


                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('sat.min') ? 'active' : '' }}">

                                     <a href="{{ route('sat.min') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Statistiques
                                         </span>

                                     </a>

                                 </li>

                             </ul>

                         </li>


                         {{-- ===================================================== --}}
                         {{-- DAF --}}
                         {{-- ===================================================== --}}

                         <li
                             class="nk-menu-item has-sub
                            {{ request()->routeIs('accueil.daf', 'sat.daf') ? 'active' : '' }}">

                             <a href="#" class="nk-menu-link nk-menu-toggle">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-building-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     DAF
                                 </span>

                             </a>


                             <ul class="nk-menu-sub">

                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('accueil.daf') ? 'active' : '' }}">

                                     <a href="{{ route('accueil.daf') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Tableau de bord
                                         </span>

                                     </a>

                                 </li>


                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('sat.daf') ? 'active' : '' }}">

                                     <a href="{{ route('sat.daf') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Statistiques
                                         </span>

                                     </a>

                                 </li>

                             </ul>

                         </li>


                         {{-- ===================================================== --}}
                         {{-- DGAPCE --}}
                         {{-- ===================================================== --}}

                         <li
                             class="nk-menu-item has-sub
                            {{ request()->routeIs('accueil.dgapce', 'sat.dgapce') ? 'active' : '' }}">

                             <a href="#" class="nk-menu-link nk-menu-toggle">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-building-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     DGAPCE
                                 </span>

                             </a>


                             <ul class="nk-menu-sub">

                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('accueil.dgapce') ? 'active' : '' }}">

                                     <a href="{{ route('accueil.dgapce') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Tableau de bord
                                         </span>

                                     </a>

                                 </li>


                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('sat.dgapce') ? 'active' : '' }}">

                                     <a href="{{ route('sat.dgapce') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Statistiques
                                         </span>

                                     </a>

                                 </li>

                             </ul>

                         </li>


                         {{-- ===================================================== --}}
                         {{-- CCM --}}
                         {{-- ===================================================== --}}

                         <li
                             class="nk-menu-item has-sub
                            {{ request()->routeIs('ccm_instance', 'ccm_signe') ? 'active' : '' }}">

                             <a href="#" class="nk-menu-link nk-menu-toggle">

                                 <span class="nk-menu-icon">
                                     <em class="icon ni ni-users-fill"></em>
                                 </span>

                                 <span class="nk-menu-text">
                                     CCM
                                 </span>

                             </a>


                             <ul class="nk-menu-sub">

                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('ccm_instance') ? 'active' : '' }}">

                                     <a href="{{ route('ccm_instance') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Actes en instance
                                         </span>

                                     </a>

                                 </li>


                                 <li
                                     class="nk-menu-item
                                    {{ request()->routeIs('ccm_signe') ? 'active' : '' }}">

                                     <a href="{{ route('ccm_signe') }}" class="nk-menu-link">

                                         <span class="nk-menu-text">
                                             Actes signés
                                         </span>

                                     </a>

                                 </li>

                             </ul>

                         </li>
                     @endif


                 </ul>

             </div>

         </div>

     </div>

 </div>
 <!-- /Sidebar -->
