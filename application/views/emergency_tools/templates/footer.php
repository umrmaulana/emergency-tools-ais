</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    let sidebarCollapsed = false;

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        if (window.innerWidth <= 768) {
            // Mobile behavior - slide in/out
            sidebar.classList.toggle('show');
        } else {
            // Desktop behavior - collapse/expand
            sidebarCollapsed = !sidebarCollapsed;

            if (sidebarCollapsed) {
                sidebar.style.transform = 'translateX(-240px)';
                sidebar.style.width = '20px';
                mainContent.style.marginLeft = '20px';

                // Hide text in sidebar, only show icons
                const navLinks = sidebar.querySelectorAll('.nav-link, .dropdown-item');
                navLinks.forEach(link => {
                    const text = link.querySelector('span:last-child') || link.lastChild;
                    if (text && text.nodeType === Node.TEXT_NODE) {
                        text.style.display = 'none';
                    }
                });

                // Hide dropdown arrows and text
                const dropdownTexts = sidebar.querySelectorAll('.dropdown-toggle span, .dropdown-item');
                dropdownTexts.forEach(text => {
                    if (text.textContent.trim() && !text.querySelector('i')) {
                        text.style.opacity = '0';
                    }
                });
            } else {
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.width = 'var(--sidebar-width)';
                mainContent.style.marginLeft = 'var(--sidebar-width)';

                // Show text in sidebar
                const navLinks = sidebar.querySelectorAll('.nav-link, .dropdown-item');
                navLinks.forEach(link => {
                    const text = link.querySelector('span:last-child') || link.lastChild;
                    if (text && text.nodeType === Node.TEXT_NODE) {
                        text.style.display = 'inline';
                    }
                });

                // Show dropdown text
                const dropdownTexts = sidebar.querySelectorAll('.dropdown-toggle span, .dropdown-item');
                dropdownTexts.forEach(text => {
                    text.style.opacity = '1';
                });
            }
        }
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        if (window.innerWidth > 768) {
            // Reset mobile classes
            sidebar.classList.remove('show');

            // Apply desktop state
            if (sidebarCollapsed) {
                sidebar.style.transform = 'translateX(-240px)';
                sidebar.style.width = '20px';
                mainContent.style.marginLeft = '20px';
            } else {
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.width = 'var(--sidebar-width)';
                mainContent.style.marginLeft = 'var(--sidebar-width)';
            }
        } else {
            // Reset desktop styles for mobile
            sidebar.style.transform = '';
            sidebar.style.width = '';
            mainContent.style.marginLeft = '0';

            // Reset text visibility
            const navLinks = sidebar.querySelectorAll('.nav-link, .dropdown-item');
            navLinks.forEach(link => {
                const text = link.querySelector('span:last-child') || link.lastChild;
                if (text && text.nodeType === Node.TEXT_NODE) {
                    text.style.display = 'inline';
                }
            });

            const dropdownTexts = sidebar.querySelectorAll('.dropdown-toggle span, .dropdown-item');
            dropdownTexts.forEach(text => {
                text.style.opacity = '1';
            });
        }
    });

    // Initialize DataTables
    $(document).ready(function () {
        $('.data-table').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            }
        });
    });

    // Auto hide alerts
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            alert.style.opacity = '0';
            setTimeout(function () {
                alert.remove();
            }, 300);
        });
    }, 5000);
</script>
</body>

</html>