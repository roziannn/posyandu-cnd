// public/js/menu.js

document.addEventListener('DOMContentLoaded', function () {
  const menuItems = document.querySelectorAll('.menu-item');

  menuItems.forEach(item => {
    item.addEventListener('click', function () {
      // Hapus kelas aktif dari semua item menu
      menuItems.forEach(menu => menu.classList.remove('active'));

      // Tambahkan kelas aktif ke item yang diklik
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
