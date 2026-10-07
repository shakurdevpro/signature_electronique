<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
  <div class="container-xxl d-flex h-100">
      <ul class="menu-inner">
        @foreach ($menus as $menu)
          <li class="menu-item {{$menu->lien =='accueil' ? "active" : ""}}">
            <a href="javascript:void(0)" class="menu-link {{$menu->icone}} menu-toggle">
                <i class="menu-icon tf-icons ti {{$menu->icone}}"></i>
                <div data-i18n="{{$menu->libelle}}">{{$menu->libelle}}</div>
            </a>
            @if ($menu->sousmenu == 1)
            <ul class="menu-sub">
                @foreach ($menu->sousmenus as $sousmenu)
                <li class="menu-item">
                    <a href="../../{{ $sousmenu->lien }}" class="menu-link">
                        <i class="menu-icon tf-icons ti {{$sousmenu->icone}}"></i>
                        <div data-i18n="{{$sousmenu->libelle}}">{{$sousmenu->libelle}}</div>
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
          </li>
          @endforeach
      </ul>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{asset('img/avatars/1.png')}}" alt class="h-auto rounded-circle">
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="{{asset('img/avatars/1.png')}}" alt class="h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">{{ Auth::user()->username}}</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class = "dropdown-item"><i class="ti ti-logout me-2 ti-sm"></i> Déconnection</button>
            </form>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</aside>