/**
 * module-header.js - Module 1: Header / Navbar Interaction
 */
document.addEventListener('DOMContentLoaded', function() {
    // 1. Account Dropdown Toggle
    var accountToggle = document.getElementById('accountDropdownToggle');
    var accountMenu   = document.getElementById('accountDropdownMenu');

    if (accountToggle && accountMenu) {
        accountToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = accountMenu.classList.contains('show');
            if (isOpen) {
                accountMenu.classList.remove('show');
                accountToggle.setAttribute('aria-expanded', 'false');
            } else {
                accountMenu.classList.add('show');
                accountToggle.setAttribute('aria-expanded', 'true');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!accountMenu.contains(e.target) && !accountToggle.contains(e.target)) {
                accountMenu.classList.remove('show');
                accountToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // 2. Mobile Menu Toggle
    var mobileBtn      = document.getElementById('headerMobileToggle');
    var collapseWrapper = document.getElementById('headerCollapseWrapper');

    if (mobileBtn && collapseWrapper) {
        mobileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            collapseWrapper.classList.toggle('show');
        });
    }
});
