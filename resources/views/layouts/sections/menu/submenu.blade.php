<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- Determine if current submenu is active --}}
            @php
                $isActive = false;
                $currentRouteName = Route::currentRouteName();

                if ($currentRouteName === $submenu->slug) {
                    $isActive = true;
                } elseif (isset($submenu->submenu)) {
                    if (is_array($submenu->slug)) {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                                $isActive = true;
                            }
                        }
                    } else {
                        if (
                            str_contains($currentRouteName, $submenu->slug) &&
                            strpos($currentRouteName, $submenu->slug) === 0
                        ) {
                            $isActive = true;
                        }
                    }
                }
            @endphp

            {{-- Submenu item --}}
            <li class="menu-item {{ $isActive ? 'active' : '' }}">
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                    class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($submenu->target) && !empty($submenu->target)) target="_blank" @endif>
                    @if (isset($submenu->icon))
                        <i class="{{ $submenu->icon }}"></i>
                    @endif
                    <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    @isset($submenu->badge)
                        <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
                    @endisset
                </a>

                {{-- Render submenu if exists --}}
                @if (isset($submenu->submenu))
                    @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                // Hapus kelas active dari semua item menu
                menuItems.forEach(menu => menu.classList.remove('active'));

                // Tambahkan kelas active ke item yang diklik
                item.classList.add('active');
            });
        });

        // Periksa URL saat ini dan atur kelas active pada item menu yang sesuai
        const currentUrl = window.location.href;
        menuItems.forEach(item => {
            if (item.querySelector('a').href === currentUrl) {
                item.classList.add('active');
            }
        });
    });
</script>
