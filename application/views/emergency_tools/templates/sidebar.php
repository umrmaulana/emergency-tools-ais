<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="p-3">
        <h6 class="text-muted mb-3">MENU</h6>
        <nav class="nav flex-column">
            <!-- Emergency Tools Menu with Dropdown -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-between" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false" id="emergencyToolsDropdown">
                    <span>
                        <i class="fas fa-tools me-2"></i>
                        Emergency Tools
                    </span>
                </a>
                <ul class="dropdown-menu w-100 border-0 shadow-sm" aria-labelledby="emergencyToolsDropdown"
                    style="position: relative; transform: none !important; margin: 0;">
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/dashboard') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/dashboard'); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/report') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/report'); ?>">
                            <i class="fas fa-chart-bar me-2"></i>
                            Report
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/equipment') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/equipment'); ?>">
                            <i class="fas fa-cogs me-2"></i>
                            Equipment
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/master-location') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/master-location'); ?>">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Master Location
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/master-equipment') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/master-equipment'); ?>">
                            <i class="fas fa-cubes me-2"></i>
                            Master Equipment
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo (uri_string() == 'emergency-tools/master-checksheet') ? 'active' : ''; ?>"
                            href="<?php echo site_url('emergency-tools/master-checksheet'); ?>">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Master Checksheet
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="main-content" id="main-content">