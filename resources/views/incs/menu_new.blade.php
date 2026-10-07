<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
    <center><img src="{{asset('img/logo.jpg')}}" width="45%" height="auto"></center>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti ti-menu-2"></i>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards 
      <li class="menu-item active open">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboards">Dashboards</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
          </a>
          <ul class="menu-sub">
          <li class="menu-item">
              <a href="index.html" class="menu-link">
              <div data-i18n="Analytics">Analytics</div>
              </a>
          </li>
          <li class="menu-item active">
              <a href="dashboards-crm.html" class="menu-link">
              <div data-i18n="CRM">CRM</div>
              </a>
          </li>
          <li class="menu-item">
              <a href="dashboards-ecommerce.html" class="menu-link">
              <div data-i18n="eCommerce">eCommerce</div>
              </a>
          </li>
          </ul>
      </li>
-->
        <!-- Apps & Pages 
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        -->

        <li class="menu-item {{($_SERVER['REQUEST_URI']=="/accueil" ? "active" :"")}}">
            <a href="/accueil" class="menu-link">
            <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
            <div data-i18n="TABLEAU DE BORD">TABLEAU DE BORD</div>
            </a>
        </li>
<?php  if ($info['LOGINUSER'] != 'T279354' && $info['LOGINUSER'] != 'E319795' && $info['LOGINUSER'] != 'K349954' && $info['LOGINUSER'] != 'H388545' ) { ?>
        <li class="menu-item {{($_SERVER['REQUEST_URI']=="/instance" ? "active" :"")}}">
            <a href="/instance" class="menu-link">
            <i class="menu-icon tf-icons ti ti-pencil"></i>
            <div data-i18n="INSTANCE DE SIGNATURE">INSTANCE DE SIGNATURE</div>
            </a>
        </li>
        <li class="menu-item {{($_SERVER['REQUEST_URI']=="/tous_signe" ? "active" :"")}}">
            <a href="/tous_signe" class="menu-link">
            <i class="menu-icon tf-icons ti ti-check"></i>
            <div data-i18n="TOUS LES ACTES SIGNES">TOUS LES ACTES SIGNES</div>
            </a>
        </li>
 <?php } ?>
        <li class="menu-item {{($_SERVER['REQUEST_URI']=="/signe" ? "active" :"")}}">
            <a href="/signe" class="menu-link">
            <i class="menu-icon tf-icons ti ti-check"></i>
            <div data-i18n="STATISTIQUE">STATISTIQUE</div>
            </a>
        </li>


<?php  if ($info['LOGINUSER'] == 'X505234' OR $info['LOGINUSER'] == 'T279354' OR $info['LOGINUSER'] == 'Z444473') { ?>


    <li class="menu-item" style="background-color: darkorange;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="MINISTRE">MINISTRE</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/accueil1" class="menu-link">
            <div data-i18n="TABLEAU DE BORD">TABLEAU DE BORD</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/stat1" class="menu-link">
            <div data-i18n="STATISTIQUE">STATISTIQUE</div>
          </a>
        </li>
      </ul>
    </li>


    <li class="menu-item" style=" background-color: white;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="DAF">DAF</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/accueil2" class="menu-link">
            <div data-i18n="TABLEAU DE BORD">TABLEAU DE BORD</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/stat2" class="menu-link">
            <div data-i18n="STATISTIQUE">STATISTIQUE</div>
          </a>
        </li>
      </ul>
    </li>


     <li class="menu-item" style="background-color: forestgreen;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="DGAPCE">DGAPCE</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/accueil3" class="menu-link">
            <div data-i18n="TABLEAU DE BORD">TABLEAU DE BORD</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/stat3" class="menu-link">
            <div data-i18n="STATISTIQUE">STATISTIQUE</div>
          </a>
        </li>
      </ul>
    </li>


  <li class="menu-item" style="background-color: #D3D3D3;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="CCM">CCM</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/mise_formation_hors_pays_en_instance_de_signature" class="menu-link">
            <div data-i18n="EN INSTANTACE">EN INSTANTACE</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/mise_formation_hors_pays_signe" class="menu-link">
            <div data-i18n="SIGNE">SIGNE</div>
          </a>
        </li>
      </ul>
    </li>


<?php } ?>

    </ul>
</aside>