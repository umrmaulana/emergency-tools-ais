<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Report & Approval</h2>
                    <p class="text-muted mb-0">Kelola laporan pengecekan dan approval</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshData()" title="Refresh Data"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="stat-number"><?php echo number_format($pending_count ?? 0); ?></div>
                <div class="stat-label">
                    <i class="fas fa-clock me-2"></i>
                    Pending Approval
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="stat-number"><?php echo number_format(count($inspections ?? [])); ?></div>
                <div class="stat-label">
                    <i class="fas fa-list me-2"></i>
                    Total Inspections
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <div class="stat-number"><?php echo date('d'); ?></div>
                <div class="stat-label">
                    <i class="fas fa-calendar-day me-2"></i>
                    Hari ini
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="stat-number"><?php echo date('M'); ?></div>
                <div class="stat-label">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Bulan ini
                </div>
            </div>
        </div>
    </div>

    <!-- Map Area -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map me-2 text-primary"></i>
                        Peta Area Equipment
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Leaflet Map -->
                    <div id="map"
                        style="height: 400px; width: 100%; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);">
                    </div>

                    <div class="map-controls text-center mb-3">
                        <button id="toggleMapping" class="btn btn-outline-primary btn-sm me-2 active">
                            <i class="fas fa-layer-group me-1"></i>Show Equipment
                        </button>
                        <button id="fitMapping" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-expand-arrows-alt me-1"></i>Fit to Area
                        </button>
                        <button id="resetView" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-home me-1"></i>Reset View
                        </button>
                    </div>

                    <!-- Equipment Filter Controls -->
                    <div class="equipment-filters text-center">
                        <button id="showAll" class="btn btn-outline-info btn-sm filter-btn active me-1 mb-2"
                            data-filter="all">
                            <i class="fas fa-th me-1"></i>All Equipment
                        </button>
                        <button class="btn btn-outline-success btn-sm filter-btn me-1 mb-2" data-filter="good">
                            <i class="fas fa-check-circle me-1"></i>Good
                        </button>
                        <button class="btn btn-outline-warning btn-sm filter-btn me-1 mb-2"
                            data-filter="needs_attention">
                            <i class="fas fa-exclamation-triangle me-1"></i>Needs Attention
                        </button>
                        <button class="btn btn-outline-danger btn-sm filter-btn me-1 mb-2" data-filter="critical">
                            <i class="fas fa-times-circle me-1"></i>Critical
                        </button>
                        <button class="btn btn-outline-secondary btn-sm filter-btn me-1 mb-2" data-filter="not_checked">
                            <i class="fas fa-question-circle me-1"></i>Not Checked
                        </button>
                    </div>

                    <p class="text-muted text-center mt-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Area mapping dengan lokasi equipment - Klik marker untuk melihat detail dan melakukan approval
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inspection Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>
                            Data Pengecekan
                            <small class="text-muted" id="inspectionCount">(<?= count($inspections ?? []) ?>
                                items)</small>
                        </h5>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari inspection..."
                                onkeyup="searchInspections()">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <button class="btn btn-success btn-sm me-2" onclick="approveSelected()">
                            <i class="fas fa-check me-1"></i>Approve Selected
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="exportData()">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover data-table">
                            <thead>
                                <tr>
                                    <th width="50"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                    <th>Tanggal</th>
                                    <th>Equipment</th>
                                    <th>Inspector</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inspectionTableBody">
                                <!-- Data inspections dari PHP -->
                                <?php if (isset($inspections) && count($inspections) > 0): ?>
                                    <?php foreach ($inspections as $index => $inspection): ?>
                                        <tr class="inspection-row" data-inspection-id="<?= $inspection->id ?>">
                                            <td>
                                                <input type="checkbox" class="form-check-input inspection-checkbox"
                                                    value="<?= $inspection->id ?>">
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= date('d M Y', strtotime($inspection->inspection_date)) ?></strong><br>
                                                    <small
                                                        class="text-muted"><?= date('H:i', strtotime($inspection->inspection_date)) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong
                                                        class="text-primary"><?= htmlspecialchars($inspection->equipment_code ?? 'N/A') ?></strong><br>
                                                    <small
                                                        class="text-muted"><?= htmlspecialchars($inspection->equipment_name ?? 'N/A') ?></small><br>
                                                    <small
                                                        class="badge bg-light text-dark"><?= htmlspecialchars($inspection->location_name ?? 'N/A') ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-2"
                                                        style="width: 32px; height: 32px; background: linear-gradient(45deg, #007bff, #0056b3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.8rem;">
                                                        <?= strtoupper(substr($inspection->inspector_name ?? 'U', 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= htmlspecialchars($inspection->inspector_name ?? 'Unknown') ?></strong><br>
                                                        <small
                                                            class="text-muted"><?= htmlspecialchars($inspection->inspector_level ?? 'N/A') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $inspection->approval_status ?? 'pending';
                                                $badgeClass = '';
                                                $statusText = '';
                                                switch ($status) {
                                                    case 'approved':
                                                        $badgeClass = 'bg-success';
                                                        $statusText = 'Approved';
                                                        break;
                                                    case 'rejected':
                                                        $badgeClass = 'bg-danger';
                                                        $statusText = 'Rejected';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-warning';
                                                        $statusText = 'Pending';
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                                                <?php if (isset($inspection->equipment_status) && $inspection->equipment_status): ?>
                                                    <br><small class="text-muted mt-1">Equipment:
                                                        <?php
                                                        $equipStatus = $inspection->equipment_status;
                                                        $equipBadge = '';
                                                        switch ($equipStatus) {
                                                            case 'good':
                                                                $equipBadge = 'success';
                                                                break;
                                                            case 'needs_attention':
                                                                $equipBadge = 'warning';
                                                                break;
                                                            case 'critical':
                                                                $equipBadge = 'danger';
                                                                break;
                                                            default:
                                                                $equipBadge = 'secondary';
                                                        }
                                                        ?>
                                                        <span
                                                            class="badge bg-<?= $equipBadge ?> badge-sm"><?= ucfirst($equipStatus) ?></span>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group action-buttons" role="group">
                                                    <button class="btn btn-sm btn-outline-info"
                                                        onclick="viewInspectionDetail(<?= $inspection->id ?>)"
                                                        title="View Detail" data-bs-toggle="tooltip">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if ($status === 'pending'): ?>
                                                        <button class="btn btn-sm btn-outline-success"
                                                            onclick="approveInspection(<?= $inspection->id ?>)" title="Approve"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="rejectInspection(<?= $inspection->id ?>)" title="Reject"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <span>Belum ada data inspection</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inspection Detail Modal -->
<div class="modal fade" id="inspectionDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list me-2"></i>Detail Inspection
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="inspectionDetailContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat detail inspection...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <div id="approvalButtons" style="display: none;">
                    <button type="button" class="btn btn-success me-2" onclick="approveFromModal()">
                        <i class="fas fa-check me-1"></i>Approve
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectFromModal()">
                        <i class="fas fa-times me-1"></i>Reject
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Confirmation Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalModalTitle">Konfirmasi Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="approvalModalText">Apakah Anda yakin ingin approve inspection ini?</p>
                <div class="mb-3">
                    <label class="form-label">Catatan (Optional)</label>
                    <textarea class="form-control" id="approvalNotes" rows="3"
                        placeholder="Tambahkan catatan approval..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmApprovalBtn" onclick="confirmApproval()">
                    <i class="fas fa-check me-1"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="date_from" id="dateFrom">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="applyFilter()">Apply Filter</button>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS dan JS -->
<link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<style>
    /* Enhanced Map Styling */
    .mapping-container {
        position: relative;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    #map {
        width: 100%;
        height: 400px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .leaflet-container {
        background: #f8f9fa;
        font-family: inherit;
        border-radius: 8px;
    }

    /* Custom Marker Styling */
    .custom-marker-container {
        background: none !important;
        border: none !important;
    }

    .custom-equipment-marker-container {
        background: none !important;
        border: none !important;
    }

    .equipment-marker-container:hover .equipment-icon {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
    }

    .custom-equipment-marker {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
        border: 3px solid white;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-equipment-marker:hover {
        transform: scale(1.2);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        z-index: 1000;
    }

    /* Equipment status colors */
    .status-good {
        background-color: #28a745;
    }

    .status-needs_attention {
        background-color: #ffc107;
        color: #000;
    }

    .status-critical {
        background-color: #dc3545;
    }

    .status-not_checked {
        background-color: #6c757d;
    }

    /* Popup Styling */
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border: 1px solid #e9ecef;
    }

    .leaflet-popup-content {
        margin: 15px 18px;
        font-size: 14px;
        line-height: 1.6;
        font-family: inherit;
    }

    .marker-popup {
        min-width: 220px;
        max-width: 300px;
    }

    .marker-popup h6 {
        margin: 0 0 10px 0;
        color: #2c3e50;
        font-weight: 600;
        font-size: 16px;
    }

    .marker-popup .badge {
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 15px;
    }

    .marker-popup small {
        color: #6c757d;
        display: block;
        margin-top: 8px;
        font-size: 12px;
    }

    /* Additional Styling */
    .approval-indicator {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 12px;
        height: 12px;
        background: #ffc107;
        border: 2px solid white;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
        }
    }
</style>

<script>
    // Global variables
    let inspectionData = [];
    let currentInspectionId = null;
    let currentApprovalAction = null;
    let map;
    let mappingOverlay = null;
    let equipmentMarkers = [];
    let showEquipmentMarkers = true;

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map
        initializeMap();

        // Initialize existing functionality only if data exists
        <?php if (isset($inspections) && is_array($inspections) && count($inspections) > 0): ?>
            loadInspectionData();
        <?php endif; ?>

        // Event listeners for map controls
        document.getElementById('toggleMapping').addEventListener('click', toggleEquipmentMarkers);
        document.getElementById('fitMapping').addEventListener('click', fitToMappingArea);
        document.getElementById('resetView').addEventListener('click', resetMapView);

        // Filter button event listeners
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterType = this.getAttribute('data-filter');
                filterEquipmentByType(filterType);
            });
        });

        // Select all checkbox handler
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.inspection-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }
    });

    // Initialize map
    function initializeMap() {
        console.log('Initializing map...');

        var imageWidth = 1000;
        var imageHeight = 800;
        var bounds = L.latLngBounds([[0, 0], [imageHeight, imageWidth]]);

        console.log('Image dimensions:', imageWidth, 'x', imageHeight);

        map = L.map('map', {
            crs: L.CRS.Simple,
            minZoom: -2,
            maxZoom: 2,
            attributionControl: false,
            zoomControl: true
        });

        console.log('Map initialized');

        const imageUrl = '<?= base_url("assets/emergency_tools/img/Mapping-area.png") ?>';
        console.log('Loading image from:', imageUrl);

        mappingOverlay = L.imageOverlay(imageUrl, bounds, {
            opacity: 1.0
        }).addTo(map);

        map.fitBounds(bounds);
        map.setMaxBounds(bounds);
        map.setView([imageHeight / 2, imageWidth / 2], map.getBoundsZoom(bounds));

        console.log('Adding equipment markers...');
        setTimeout(() => {
            addEquipmentMarkers();
            console.log('Equipment markers added');
        }, 500);
    }

    // Add equipment markers to map
    function addEquipmentMarkers() {
        // Get equipment data from PHP
        const equipmentData = <?php echo json_encode($equipments ?? []); ?>;
        console.log('Equipment data:', equipmentData);

        equipmentMarkers.forEach(marker => map.removeLayer(marker));
        equipmentMarkers = [];

        if (equipmentData && equipmentData.length > 0) {
            equipmentData.forEach(equipment => {
                console.log('Processing equipment:', equipment);

                if (!equipment.area_x || !equipment.area_y) {
                    console.log('Skipping equipment without coordinates:', equipment.equipment_code);
                    return;
                }

                console.log(`Equipment ${equipment.equipment_code} coordinates: x=${equipment.area_x}, y=${equipment.area_y}`);
                console.log(`Equipment icon_url: ${equipment.icon_url}`);

                let statusColor = '';
                let statusText = '';

                // Determine status based on equipment status and last check date
                const lastCheck = equipment.last_check_date ? new Date(equipment.last_check_date) : null;
                const daysSinceCheck = lastCheck ? Math.floor((new Date() - lastCheck) / (1000 * 60 * 60 * 24)) : null;

                if (equipment.status === 'maintenance') {
                    statusColor = '#6c757d';
                    statusText = 'Under Maintenance';
                } else if (!lastCheck) {
                    statusColor = '#6c757d';
                    statusText = 'Not Checked';
                } else if (daysSinceCheck > 30) {
                    statusColor = '#dc3545';
                    statusText = 'Needs Attention';
                } else if (daysSinceCheck > 14) {
                    statusColor = '#ffc107';
                    statusText = 'Due Soon';
                } else {
                    statusColor = '#28a745';
                    statusText = 'Good';
                }

                // Create equipment icon - use equipment icon from database if available
                let equipmentIcon = 'fas fa-fire-extinguisher'; // default icon
                if (equipment.icon_url) {
                    // If we have an icon URL from database, we'll use it as background image
                    const markerHtml = `
                        <div class="equipment-marker-container" style="position: relative;">
                            <div class="equipment-icon" style="
                                width: 32px; 
                                height: 32px; 
                                background-image: url('<?= base_url() ?>assets/emergency_tools/img/equipment/${equipment.icon_url}'); 
                                background-size: cover; 
                                background-position: center; 
                                border-radius: 50%; 
                                border: 3px solid white; 
                                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
                                cursor: pointer;
                                transition: all 0.3s ease;
                            "></div>
                            <div class="status-indicator" style="
                                position: absolute; 
                                bottom: -2px; 
                                right: -2px; 
                                width: 14px; 
                                height: 14px; 
                                background-color: ${statusColor}; 
                                border: 2px solid white; 
                                border-radius: 50%;
                                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
                            "></div>
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        html: markerHtml,
                        className: 'custom-equipment-marker-container',
                        iconSize: [36, 36],
                        iconAnchor: [18, 18],
                        popupAnchor: [0, -18]
                    });

                    // Use the same coordinate system as master location
                    // area_x = x coordinate, area_y = y coordinate (same as master location)
                    const marker = L.marker([parseFloat(equipment.area_x), parseFloat(equipment.area_y)], { icon: customIcon })
                        .addTo(map)
                        .bindPopup(`
                            <div class="marker-popup">
                                <h6>${equipment.equipment_name} - ${equipment.equipment_type}</h6>
                                <p class="mb-1"><strong>Code:</strong> ${equipment.equipment_code}</p>
                                <p class="mb-1"><strong>Location:</strong> ${equipment.location_name || 'N/A'}</p>
                                <p class="mb-1"><strong>Area:</strong> ${equipment.area_code || 'N/A'}</p>
                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    <span class="badge" style="background-color: ${statusColor}; color: white;">${statusText}</span>
                                </p>
                                ${lastCheck ?
                                `<small>Last Check: ${new Date(lastCheck).toLocaleDateString()}</small>` :
                                '<small>Never checked</small>'
                            }
                            </div>
                        `);

                    // Store equipment data with marker for filtering
                    marker.equipmentData = equipment;
                    marker.equipmentType = equipment.equipment_type;
                    marker.equipmentStatus = statusText.toLowerCase().replace(' ', '_');

                    equipmentMarkers.push(marker);
                } else {
                    // Fallback to FontAwesome icon if no equipment icon available
                    const markerHtml = `
                        <div class="custom-equipment-marker" style="
                            background-color: ${statusColor};
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-size: 14px;
                            font-weight: bold;
                            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
                            border: 3px solid white;
                            cursor: pointer;
                            transition: all 0.3s ease;
                        ">
                            <i class="fas fa-fire-extinguisher"></i>
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        html: markerHtml,
                        className: 'custom-marker-container',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16],
                        popupAnchor: [0, -16]
                    });

                    // Use the same coordinate system as master location
                    // area_x = x coordinate, area_y = y coordinate (same as master location)
                    const marker = L.marker([parseFloat(equipment.area_x), parseFloat(equipment.area_y)], { icon: customIcon })
                        .addTo(map)
                        .bindPopup(`
                            <div class="marker-popup">
                                <h6>${equipment.equipment_name} - ${equipment.equipment_type}</h6>
                                <p class="mb-1"><strong>Code:</strong> ${equipment.equipment_code}</p>
                                <p class="mb-1"><strong>Location:</strong> ${equipment.location_name || 'N/A'}</p>
                                <p class="mb-1"><strong>Area:</strong> ${equipment.area_code || 'N/A'}</p>
                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    <span class="badge" style="background-color: ${statusColor}; color: white;">${statusText}</span>
                                </p>
                                ${lastCheck ?
                                `<small>Last Check: ${new Date(lastCheck).toLocaleDateString()}</small>` :
                                '<small>Never checked</small>'
                            }
                            </div>
                        `);

                    // Store equipment data with marker for filtering
                    marker.equipmentData = equipment;
                    marker.equipmentType = equipment.equipment_type;
                    marker.equipmentStatus = statusText.toLowerCase().replace(' ', '_');

                    equipmentMarkers.push(marker);
                }
            });

            console.log(`Added ${equipmentMarkers.length} equipment markers to map`);
        } else {
            console.log('No equipment data found');
        }
    }    // Map control functions
    function toggleEquipmentMarkers() {
        const btn = document.getElementById('toggleMapping');
        if (!btn) return;

        showEquipmentMarkers = !showEquipmentMarkers;

        equipmentMarkers.forEach(marker => {
            if (showEquipmentMarkers) {
                map.addLayer(marker);
            } else {
                map.removeLayer(marker);
            }
        });

        btn.innerHTML = `<i class="fas fa-layer-group me-1"></i>${showEquipmentMarkers ? 'Hide' : 'Show'} Equipment`;
        btn.classList.toggle('active', showEquipmentMarkers);
    }

    function fitToMappingArea() {
        if (mappingOverlay) {
            const bounds = mappingOverlay.getBounds();
            map.fitBounds(bounds);
        }
    }

    function resetMapView() {
        if (mappingOverlay) {
            const bounds = mappingOverlay.getBounds();
            map.setView(bounds.getCenter(), map.getBoundsZoom(bounds));
        }
    }

    // Filter equipment by type
    function filterEquipmentByType(filterType) {
        equipmentMarkers.forEach(marker => {
            let showMarker = false;

            if (filterType === 'all') {
                showMarker = true;
            } else if (marker.equipmentType && marker.equipmentType.toLowerCase().includes(filterType.toLowerCase())) {
                showMarker = true;
            } else if (marker.equipmentStatus && marker.equipmentStatus === filterType) {
                showMarker = true;
            }

            if (showMarker && showEquipmentMarkers) {
                if (!map.hasLayer(marker)) {
                    map.addLayer(marker);
                }
            } else {
                if (map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            }
        });

        console.log(`Filtered by: ${filterType}, Showing ${equipmentMarkers.filter(m => map.hasLayer(m)).length} markers`);
    }

    // Load inspection data
    function loadInspectionData() {
        console.log('Inspection data loaded from PHP backend');

        setTimeout(() => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }, 1000);
    }

    // Search function
    function searchInspections() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.inspection-row');
        const countElement = document.getElementById('inspectionCount');

        let visibleCount = 0;
        let totalRows = rows.length;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (searchTerm !== '') {
            countElement.textContent = `(${visibleCount} dari ${totalRows} items)`;
            countElement.classList.add('text-primary');
        } else {
            countElement.textContent = `(${totalRows} items)`;
            countElement.classList.remove('text-primary');
        }
    }

    // Refresh data
    function refreshData() {
        const refreshBtn = document.querySelector('[onclick="refreshData()"]');
        const refreshIcon = refreshBtn.querySelector('i');

        refreshIcon.classList.add('fa-spin');
        refreshBtn.disabled = true;

        document.getElementById('searchInput').value = '';

        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    // Bulk approve function
    function approveSelected() {
        const selected = Array.from(document.querySelectorAll('.inspection-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada yang dipilih',
                    text: 'Pilih minimal satu inspection untuk di-approve!'
                });
            } else {
                alert('Pilih minimal satu inspection untuk di-approve!');
            }
            return;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Konfirmasi Bulk Approve',
                text: `Approve ${selected.length} inspection yang dipilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Approve!',
                cancelButtonText: 'Batal',
                input: 'textarea',
                inputPlaceholder: 'Catatan approval (optional)...',
                inputAttributes: {
                    'aria-label': 'Catatan approval'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const notes = result.value || '';
                    processBulkApproval(selected, notes);
                }
            });
        } else {
            const notes = prompt('Catatan approval (optional):') || '';
            if (confirm(`Approve ${selected.length} inspection yang dipilih?`)) {
                processBulkApproval(selected, notes);
            }
        }
    }

    // Process bulk approval
    function processBulkApproval(inspectionIds, notes) {
        // Show loading state
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Processing...',
                text: `Sedang memproses ${inspectionIds.length} inspection...`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Process each inspection one by one
        let processed = 0;
        let successful = 0;
        let failed = [];

        const processNext = (index) => {
            if (index >= inspectionIds.length) {
                // All done, show results
                showBulkApprovalResults(successful, failed.length, failed);
                return;
            }

            const inspectionId = inspectionIds[index];
            const url = `<?= base_url('emergency_tools/report/approve/') ?>${inspectionId}`;
            const formData = new FormData();
            formData.append('notes', notes);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    processed++;

                    if (data.success) {
                        successful++;
                        // Update UI for successful approval
                        updateInspectionRowStatus(inspectionId, 'approved');
                    } else {
                        failed.push({
                            id: inspectionId,
                            error: data.message || 'Unknown error'
                        });
                    }

                    // Update progress if using SweetAlert
                    if (typeof Swal !== 'undefined') {
                        Swal.update({
                            text: `Memproses... ${processed}/${inspectionIds.length}`
                        });
                    }

                    // Process next
                    setTimeout(() => processNext(index + 1), 200); // Small delay to prevent overwhelming server
                })
                .catch(error => {
                    processed++;
                    console.error('Error approving inspection:', inspectionId, error);
                    failed.push({
                        id: inspectionId,
                        error: 'Network error: ' + error.message
                    });

                    // Update progress if using SweetAlert
                    if (typeof Swal !== 'undefined') {
                        Swal.update({
                            text: `Memproses... ${processed}/${inspectionIds.length}`
                        });
                    }

                    // Process next
                    setTimeout(() => processNext(index + 1), 200);
                });
        };

        // Start processing
        processNext(0);
    }

    // Show bulk approval results
    function showBulkApprovalResults(successful, failedCount, failedItems) {
        // Clear all checkboxes
        document.querySelectorAll('.inspection-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;

        if (typeof Swal !== 'undefined') {
            if (failedCount === 0) {
                // All successful
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `${successful} inspection berhasil di-approve!`,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else if (successful === 0) {
                // All failed
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: `Gagal approve ${failedCount} inspection. Silakan coba lagi.`,
                    confirmButtonText: 'OK'
                });
            } else {
                // Mixed results
                let failedDetails = failedItems.map(item => `- ID ${item.id}: ${item.error}`).join('\n');
                Swal.fire({
                    icon: 'warning',
                    title: 'Sebagian Berhasil',
                    html: `
                        <div class="text-left">
                            <p><strong>Berhasil:</strong> ${successful} inspection</p>
                            <p><strong>Gagal:</strong> ${failedCount} inspection</p>
                            <div class="mt-3">
                                <small><strong>Detail kegagalan:</strong></small>
                                <div class="text-left" style="font-size: 0.8em; max-height: 200px; overflow-y: auto;">
                                    ${failedItems.map(item => `<div>• ID ${item.id}: ${item.error}</div>`).join('')}
                                </div>
                            </div>
                        </div>
                    `,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
            }
        } else {
            // Fallback for browsers without SweetAlert
            if (failedCount === 0) {
                alert(`${successful} inspection berhasil di-approve!`);
            } else {
                alert(`Berhasil: ${successful}, Gagal: ${failedCount} inspection`);
            }
            window.location.reload();
        }
    }

    // Update inspection row status in the table
    function updateInspectionRowStatus(inspectionId, newStatus) {
        const row = document.querySelector(`tr[data-inspection-id="${inspectionId}"]`);
        if (row) {
            const statusCell = row.querySelector('td:nth-child(5)'); // Status column
            if (statusCell) {
                const badge = statusCell.querySelector('.badge');
                if (badge) {
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Approved';
                }
            }

            // Hide action buttons for approved items
            const actionCell = row.querySelector('td:nth-child(6)'); // Action column  
            if (actionCell) {
                const approveBtn = actionCell.querySelector('.btn-outline-success');
                const rejectBtn = actionCell.querySelector('.btn-outline-danger');
                if (approveBtn) approveBtn.style.display = 'none';
                if (rejectBtn) rejectBtn.style.display = 'none';
            }

            // Uncheck the checkbox
            const checkbox = row.querySelector('.inspection-checkbox');
            if (checkbox) checkbox.checked = false;
        }
    }

    // Export data function
    function exportData() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Dalam pengembangan',
                text: 'Fitur export data sedang dalam pengembangan'
            });
        } else {
            alert('Fitur export data sedang dalam pengembangan');
        }
    }

    // View inspection detail function
    function viewInspectionDetail(inspectionId) {
        console.log('Viewing inspection detail for ID:', inspectionId);
        currentInspectionId = inspectionId;

        const modal = new bootstrap.Modal(document.getElementById('inspectionDetailModal'));
        modal.show();

        document.getElementById('inspectionDetailContent').innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat detail inspection...</p>
            </div>
        `;

        setTimeout(() => {
            const sampleDetail = {
                id: inspectionId,
                equipment_code: 'EQ-001',
                equipment_name: 'Fire Extinguisher',
                location_name: 'Building A - Floor 1',
                equipment_type: 'APAR',
                inspection_date: new Date().toISOString(),
                inspector_name: 'John Doe',
                equipment_status: 'good',
                approval_status: 'pending',
                notes: 'Equipment dalam kondisi baik, tekanan normal'
            };
            displayInspectionDetail(sampleDetail);
        }, 1000);
    }

    function displayInspectionDetail(inspection) {
        const content = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Equipment Information</h6>
                    <table class="table table-sm">
                        <tr><th width="40%">Equipment Code:</th><td>${inspection.equipment_code || 'N/A'}</td></tr>
                        <tr><th>Equipment Name:</th><td>${inspection.equipment_name || 'N/A'}</td></tr>
                        <tr><th>Location:</th><td>${inspection.location_name || 'N/A'}</td></tr>
                        <tr><th>Type:</th><td>${inspection.equipment_type || 'N/A'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Inspection Information</h6>
                    <table class="table table-sm">
                        <tr><th width="40%">Date:</th><td>${new Date(inspection.inspection_date).toLocaleString('id-ID')}</td></tr>
                        <tr><th>Inspector:</th><td>${inspection.inspector_name || 'N/A'}</td></tr>
                        <tr><th>Status:</th><td>
                            <span class="badge bg-${inspection.equipment_status === 'good' ? 'success' : inspection.equipment_status === 'needs_attention' ? 'warning' : inspection.equipment_status === 'critical' ? 'danger' : 'secondary'}">
                                ${(inspection.equipment_status || 'not_checked').replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                            </span>
                        </td></tr>
                        <tr><th>Approval:</th><td>
                            <span class="badge bg-${inspection.approval_status === 'approved' ? 'success' : inspection.approval_status === 'rejected' ? 'danger' : 'warning'}">
                                ${(inspection.approval_status || 'pending').charAt(0).toUpperCase() + (inspection.approval_status || 'pending').slice(1)}
                            </span>
                        </td></tr>
                    </table>
                </div>
            </div>
            
            ${inspection.notes ? `
                <div class="mt-3">
                    <h6 class="text-primary">Inspection Notes</h6>
                    <div class="bg-light p-3 rounded">
                        ${inspection.notes}
                    </div>
                </div>
            ` : ''}
        `;

        document.getElementById('inspectionDetailContent').innerHTML = content;

        if (inspection.approval_status === 'pending') {
            document.getElementById('approvalButtons').style.display = 'block';
        } else {
            document.getElementById('approvalButtons').style.display = 'none';
        }
    }

    // Approve inspection function
    function approveInspection(inspectionId) {
        console.log('Approving inspection ID:', inspectionId);
        currentInspectionId = inspectionId;
        currentApprovalAction = 'approve';

        document.getElementById('approvalModalTitle').textContent = 'Konfirmasi Approval';
        document.getElementById('approvalModalText').textContent = 'Apakah Anda yakin ingin approve inspection ini?';
        document.getElementById('confirmApprovalBtn').innerHTML = '<i class="fas fa-check me-1"></i>Approve';
        document.getElementById('confirmApprovalBtn').className = 'btn btn-success';
        document.getElementById('approvalNotes').value = '';

        const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
        modal.show();
    }

    // Reject inspection function
    function rejectInspection(inspectionId) {
        console.log('Rejecting inspection ID:', inspectionId);
        currentInspectionId = inspectionId;
        currentApprovalAction = 'reject';

        document.getElementById('approvalModalTitle').textContent = 'Konfirmasi Rejection';
        document.getElementById('approvalModalText').textContent = 'Apakah Anda yakin ingin reject inspection ini?';
        document.getElementById('confirmApprovalBtn').innerHTML = '<i class="fas fa-times me-1"></i>Reject';
        document.getElementById('confirmApprovalBtn').className = 'btn btn-danger';
        document.getElementById('approvalNotes').value = '';

        const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
        modal.show();
    }

    // Approve from modal
    function approveFromModal() {
        if (currentInspectionId) {
            approveInspection(currentInspectionId);
        }
    }

    // Reject from modal
    function rejectFromModal() {
        if (currentInspectionId) {
            rejectInspection(currentInspectionId);
        }
    }

    // Confirm approval function
    function confirmApproval() {
        if (!currentInspectionId || !currentApprovalAction) {
            console.error('Missing inspection ID or approval action');
            return;
        }

        const notes = document.getElementById('approvalNotes').value.trim();
        const btn = document.getElementById('confirmApprovalBtn');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Processing...';

        // Send AJAX request to backend
        const url = `<?= base_url('emergency_tools/report/') ?>${currentApprovalAction}/${currentInspectionId}`;
        const formData = new FormData();
        formData.append('notes', notes);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;

                const approvalModal = bootstrap.Modal.getInstance(document.getElementById('approvalModal'));
                const detailModal = bootstrap.Modal.getInstance(document.getElementById('inspectionDetailModal'));
                if (approvalModal) approvalModal.hide();
                if (detailModal) detailModal.hide();

                if (data.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        alert(data.message);
                        window.location.reload();
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message
                        });
                    } else {
                        alert(data.message);
                    }
                }

                // Reset variables
                currentInspectionId = null;
                currentApprovalAction = null;
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses approval'
                    });
                } else {
                    alert('Terjadi kesalahan saat memproses approval');
                }

                // Reset variables
                currentInspectionId = null;
                currentApprovalAction = null;
            });
    }

    // Apply filter function
    function applyFilter() {
        const formData = new FormData(document.getElementById('filterForm'));
        const filterData = Object.fromEntries(formData);

        console.log('Apply filter:', filterData);

        const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
        if (modal) modal.hide();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Filter Applied',
                text: 'Filter telah diterapkan (fitur dalam pengembangan)',
                timer: 2000,
                showConfirmButton: false
            });
        }
    }
</script>