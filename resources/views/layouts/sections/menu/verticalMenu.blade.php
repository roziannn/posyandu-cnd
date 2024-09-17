<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/Landing/logoposyandu.png') }}" alt="Posyandu Logo" width="200">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            @if (in_array(Auth::user()->role, $menu->roles))
                @php
                    // dd(Auth::user()->role == $menu->roles);
                    $activeClass = null;
                    $isMenuActive = false;
                    $currentRouteName = Route::currentRouteName();

                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                        $isMenuActive = true;
                    } elseif (isset($menu->submenu)) {
                        foreach ($menu->submenu as $submenu) {
                            if (isset($submenu->slug)) {
                                if ($currentRouteName === $submenu->slug) {
                                    $isMenuActive = true;
                                    break;
                                }
                            }
                        }
                        if ($isMenuActive) {
                            $activeClass = 'active open';
                        }
                    }
                @endphp

                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
                        @if (isset($menu->icon))
                            <i class="{{ $menu->icon }}"></i>
                        @endif
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        @isset($menu->badge)
                            <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                        @endisset
                    </a>

                    {{-- Render submenu if exists --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>
</aside>
