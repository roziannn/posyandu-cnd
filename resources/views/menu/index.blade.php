@extends('layouts.app')

@section('content')
    <ul id="menu">
        @foreach ($menu as $item)
            @if (isset($item['submenu']))
                <li class="menu-item has-submenu" id="{{ $item['slug'] }}">
                    <a href="javascript:void(0);">{{ $item['name'] }}</a>
                    <ul class="submenu">
                        @foreach ($item['submenu'] as $subitem)
                            <li class="menu-item" id="{{ $subitem['slug'] }}">
                                <a href="{{ url($subitem['url']) }}">{{ $subitem['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="menu-item" id="{{ $item['slug'] }}">
                    <a href="{{ url($item['url']) }}">{{ $item['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endsection

@section('scripts')
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

            // Check the current URL and set the active class on the appropriate menu item
            const currentUrl = window.location.href;
            menuItems.forEach(item => {
                if (item.querySelector('a').href === currentUrl) {
                    item.classList.add('active');
                }
            });
        });
    </script>
@endsection
