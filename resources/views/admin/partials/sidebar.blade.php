@php
  $appInfo = App\Models\AppInfo::first();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          @if (isset($appInfo->logo) && $appInfo->logo != null)
            <div class="d-flex align-items-center">
                <img 
                    src="{{ $appInfo->logo == 'admin' 
                        ? asset(env('ADMINPATH') . $appInfo->logo) 
                        : asset(env('FRONTPATH') . $appInfo->logo) }}"
                    alt="App Logo"
                    style="width: 60px; height: auto; object-fit: contain;"
                >
            </div>
          @endif
        </span>
        <span class="app-brand-text demo menu-text fw-bold">{{ $appInfo -> app_name }}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      
      <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('app-info') ? 'active' : '' }}">
        <a href="{{ route('app-info.create') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
            <div data-i18n="App Info">App Info</div>
        </a>
      </li>
    

      <!-- Forms & Tables -->
      {{-- <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Forms & Tables">Forms &amp; Tables</span>
      </li> --}}
     

      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-text-wrap-disabled"></i>
          <div data-i18n="Form Wizard">Form Wizard</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="form-wizard-numbered.html" class="menu-link">
              <div data-i18n="Numbered">Numbered</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item">
        <a href="{{ route('roadmaps.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-mail"></i>
            <div data-i18n="Roadmaps">Roadmaps</div>
        </a>
    </li>

      <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Cache Clear">Cache &amp; Clear</span>
      </li>
      <li class="menu-item">
          <a href="{{ route('admin-cache-clear') }}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-mail"></i>
              <div data-i18n="Cache">Cache</div>
          </a>
      </li>
      

    </ul>
  </aside>