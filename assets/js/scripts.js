function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const isVisible = dropdown.classList.contains('open');

    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('open');
    });

    if (!isVisible) {
        dropdown.classList.add('open');
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('open');
        });
    }
});
