<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">

      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">

          <img src="{{asset('img/logo.jpg')}}" width="8%" height="auto">
          <span class = "app-brand-text demo menu-text fw-bold">Bienvenue sur E-Signature</span>


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
          <i class="ti ti-x ti-sm align-middle"></i>
        </a>
      </div>

      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none  ">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="ti ti-menu-2 ti-sm"></i>
        </a>
      </div>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{asset('img/avatars/1.jpg')}}" alt class="h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="pages-account-settings-account.html">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{asset('img/avatars/1.jpg')}}" alt class="h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">@php echo utf8_encode($info['NOM PRENOMS']); @endphp</span>
                      <small class="text-muted">{{$info['FONCTION']}}</small>
                    </div>
                  </div>
                </a>
              </li>
              <!--
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li >
                <a class="dropdown-item" href="#">
                  <i class="ti ti-check me-2 ti-sm"></i>
                  <span class="align-middle">Tous les actes signés</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="ti ti-files me-2 ti-sm"></i>
                  <span class="align-middle">Tous les actes a signer</span>
                </a>
              </li>
              -->
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a href = "{{route('logout')}}">
                  
                    <button type="submit" class="dropdown-item"><i class ="ti ti-logout me-2 ti-sm"></i> Déconnection</button>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->

        </ul>
      </div>

      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
        <input type="text" class="form-control search-input  border-0" placeholder="Search..." aria-label="Search...">
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
      </div>

    </div>
  </nav>
