<style>
    /* Location marker styles - titik kecil yang akurat */
    .location-marker {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #dc3545;
        border: 2px solid white;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .location-marker:hover {
        width: 16px;
        height: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }

    .location-marker.selected {
        background: #007bff;
        width: 16px;
        height: 16px;
    }

    /* Map container dengan zoom capability */
    .map-container {
        position: relative;
        overflow: hidden;
        border: 2px solid #ddd;
        border-radius: 8px;
        background: #f8f9fa;
        cursor: crosshair;
    }

    .map-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .zoom-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 20;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .zoom-btn {
        width: 35px;
        height: 35px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .zoom-btn:hover {
        background: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Master Location</h2>
                    <p class="text-muted mb-0">Kelola data lokasi area dengan posisi pada peta</p>
                </div>
                <div>
                    <a href="<?= base_url('emergency_tools/master_location/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Lokasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Map Area - Full Width -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map me-2 text-primary"></i>
                        Peta Area & Posisi Lokasi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="mapContainer" class="map-container" style="min-height: 500px;">
                        <!-- Zoom Controls -->
                        <div class="zoom-controls">
                            <button class="zoom-btn" onclick="zoomIn()">+</button>
                            <button class="zoom-btn" onclick="zoomOut()">-</button>
                            <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">⌂</button>
                        </div>

                        <!-- Area Mapping Grid 8x4 with zoom capability -->
                        <img id="areaMapping" src="<?php echo base_url('assets/img/area_mapping_8x4.png'); ?>"
                            class="map-image" style="width: 800px; height: 400px; object-fit: contain;">

                        <!-- Location Markers Container -->
                        <div id="locationMarkers"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Klik pada area untuk melihat informasi lokasi.
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">
                        Area: 8 kolom × 4 baris = 32 zona lokasi
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Location List with Search - Full Width -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2 text-primary"></i>
                        Daftar Lokasi
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Search Box -->
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="locationSearch" placeholder="Cari lokasi...">
                        </div>
                        <!-- Show entries -->
                        <div class="d-flex align-items-center">
                            <label class="me-2 text-nowrap">Tampilkan:</label>
                            <select class="form-select form-select-sm" id="entriesPerPage" style="width: 80px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50px">No</th>
                                    <th>Kode Lokasi</th>
                                    <th>Nama Lokasi</th>
                                    <th>Deskripsi</th>
                                    <th width="100px">Area</th>
                                    <th width="120px">Koordinat</th>
                                    <th width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="locationTableBody">
                                <?php if (isset($locations) && !empty($locations)): ?>
                                    <?php foreach ($locations as $index => $location): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <span
                                                    class="fw-bold text-primary"><?php echo htmlspecialchars($location->location_code); ?></span>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?php echo htmlspecialchars($location->location_name); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted"><?php echo htmlspecialchars($location->desc ?: '-'); ?></small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-info"><?php echo htmlspecialchars($location->area_code); ?></span>
                                            </td>
                                            <td>
                                                <small class="text-muted">(<?php echo $location->area_x; ?>,
                                                    <?php echo $location->area_y; ?>)</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('emergency_tools/master_location/edit/' . $location->id) ?>"
                                                        class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger"
                                                        onclick="deleteLocation(<?php echo $location->id; ?>)" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            Belum ada data lokasi
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination and Info -->
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <div class="text-muted" id="tableInfo">
                            Menampilkan 1 sampai <?php echo isset($locations) ? count($locations) : 0; ?> dari
                            <?php echo isset($locations) ? count($locations) : 0; ?> data
                        </div>
                        <div id="tablePagination">
                            <!-- Pagination will be generated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables for location data and pagination
    let allLocations = []; // Store all location data
    let currentPage = 1;
    let entriesPerPage = 10;
    let zoomLevel = 1;
    const maxZoom = 3;
    const minZoom = 0.5;

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function () {
        // Load location data
        loadLocationList();

        // Initialize search functionality
        const searchInput = document.getElementById('locationSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                filterLocations();
            });
        }

        // Initialize entries per page change
        const entriesSelect = document.getElementById('entriesPerPage');
        if (entriesSelect) {
            entriesSelect.addEventListener('change', function () {
                entriesPerPage = parseInt(this.value);
                currentPage = 1;
                renderLocationTable();
            });
        }

        // Initialize map click handler
        const mapContainer = document.getElementById('mapContainer');
        if (mapContainer) {
            mapContainer.addEventListener('click', function (e) {
                if (e.target.id === 'areaMapping') {
                    showLocationInfo(e);
                }
            });
        }
    });

    // Function to filter locations based on search
    function filterLocations() {
        const searchTerm = document.getElementById('locationSearch').value.toLowerCase();
        const filteredLocations = allLocations.filter(location => {
            return location.location_code.toLowerCase().includes(searchTerm) ||
                location.location_name.toLowerCase().includes(searchTerm) ||
                (location.desc && location.desc.toLowerCase().includes(searchTerm)) ||
                (location.area_code && location.area_code.toLowerCase().includes(searchTerm));
        });

        currentPage = 1;
        renderLocationTable(filteredLocations);
    }

    // Function to render location table with pagination
    function renderLocationTable(locations = null) {
        const locationsToRender = locations || allLocations;
        const tbody = document.getElementById('locationTableBody');
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;
        const pageLocations = locationsToRender.slice(startIndex, endIndex);

        // Clear current table
        tbody.innerHTML = '';

        if (pageLocations.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Tidak ada data yang ditemukan
                    </td>
                </tr>
            `;
        } else {
            pageLocations.forEach((location, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${startIndex + index + 1}</td>
                    <td>
                        <span class="fw-bold text-primary">${escapeHtml(location.location_code)}</span>
                    </td>
                    <td>
                        <div class="fw-bold">${escapeHtml(location.location_name)}</div>
                    </td>
                    <td>
                        <small class="text-muted">${escapeHtml(location.desc || '-')}</small>
                    </td>
                    <td>
                        <span class="badge bg-info">${escapeHtml(location.area_code || '-')}</span>
                    </td>
                    <td>
                        <small class="text-muted">(${location.area_x || 0}, ${location.area_y || 0})</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?= base_url('emergency_tools/master_location/edit/') ?>${location.id}" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger" onclick="deleteLocation(${location.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Update table info and pagination
        updateTableInfo(locationsToRender.length, startIndex + 1, Math.min(endIndex, locationsToRender.length));
        renderPagination(locationsToRender.length);
    }

    // Function to update table info
    function updateTableInfo(total, start, end) {
        const tableInfo = document.getElementById('tableInfo');
        if (tableInfo) {
            if (total === 0) {
                tableInfo.textContent = 'Tidak ada data yang ditemukan';
            } else {
                tableInfo.textContent = `Menampilkan ${start} sampai ${end} dari ${total} data`;
            }
        }
    }

    // Function to render pagination
    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / entriesPerPage);
        const paginationContainer = document.getElementById('tablePagination');

        if (!paginationContainer || totalPages <= 1) {
            if (paginationContainer) paginationContainer.innerHTML = '';
            return;
        }

        let paginationHTML = '<nav><ul class="pagination pagination-sm mb-0">';

        // Previous button
        if (currentPage > 1) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">‹</a></li>`;
        }

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">›</a></li>`;
        }

        paginationHTML += '</ul></nav>';
        paginationContainer.innerHTML = paginationHTML;
    }

    // Function to change page
    function changePage(page) {
        currentPage = page;
        filterLocations();
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function (m) { return map[m]; });
    }

    // Function to show location info when clicking main map
    function showLocationInfo(event) {
        const img = event.target;
        const rect = img.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        // Calculate area code
        const gridX = Math.floor((x / rect.width) * 8);
        const gridY = Math.floor((y / rect.height) * 4);
        const areaCode = String.fromCharCode(65 + gridY) + (gridX + 1);

        // Show tooltip or info
        showAlert(`Area: ${areaCode} - Posisi: (${Math.round((x / rect.width) * 800)}, ${Math.round((y / rect.height) * 400)})`, 'info');
    }

    // Zoom functions untuk main map
    function zoomIn() {
        if (zoomLevel < maxZoom) {
            zoomLevel += 0.25;
            applyZoom();
        }
    }

    function zoomOut() {
        if (zoomLevel > minZoom) {
            zoomLevel -= 0.25;
            applyZoom();
        }
    }

    function resetZoom() {
        zoomLevel = 1;
        applyZoom();
    }

    function applyZoom() {
        const mapImage = document.getElementById('areaMapping');
        mapImage.style.transform = `scale(${zoomLevel})`;
        mapImage.style.transformOrigin = 'center center';

        // Update markers position based on zoom
        updateAllMarkersPosition();
    }

    // Function to show alert messages using SweetAlert2
    function showAlert(message, type = 'success') {
        let icon = 'success';
        let confirmButtonColor = '#28a745';

        switch (type) {
            case 'error':
            case 'danger':
                icon = 'error';
                confirmButtonColor = '#dc3545';
                break;
            case 'warning':
                icon = 'warning';
                confirmButtonColor = '#f39c12';
                break;
            case 'info':
                icon = 'info';
                confirmButtonColor = '#3085d6';
                break;
            default:
                icon = 'success';
                confirmButtonColor = '#28a745';
        }

        Swal.fire({
            icon: icon,
            title: type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : type === 'warning' ? 'Peringatan!' : 'Informasi!',
            text: message,
            confirmButtonColor: confirmButtonColor,
            timer: type === 'success' ? 3000 : null,
            timerProgressBar: type === 'success' ? true : false,
            showConfirmButton: type !== 'success'
        });
    }

    // Function to load and refresh location list
    function loadLocationList() {
        fetch('<?= base_url('emergency_tools/master_location/api/get') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    allLocations = data.data || data || [];
                    renderLocationTable();
                    updateLocationMarkers(allLocations);
                } else {
                    console.error('Error loading locations:', data.message);
                    allLocations = [];
                    renderLocationTable();
                }
            })
            .catch(error => {
                console.error('Error loading locations:', error);
                allLocations = [];
                renderLocationTable();
            });
    }

    // Function to update location markers on map
    function updateLocationMarkers(locations) {
        const markersContainer = document.getElementById('locationMarkers');
        if (!markersContainer) return;

        // Clear existing markers
        markersContainer.innerHTML = '';

        // Add markers for each location
        locations.forEach(location => {
            if (location.area_x !== null && location.area_y !== null) {
                addLocationMarkerToMap(location);
            }
        });
    }

    // Function to add single marker to map
    function addLocationMarkerToMap(location) {
        const markersContainer = document.getElementById('locationMarkers');
        if (!markersContainer) return;

        // Create marker element
        const marker = document.createElement('div');
        marker.className = 'location-marker';
        marker.setAttribute('data-location-id', location.id);
        marker.setAttribute('data-location-name', location.location_name);
        marker.setAttribute('data-area-code', location.area_code);
        marker.setAttribute('data-x', location.area_x);
        marker.setAttribute('data-y', location.area_y);
        marker.style.pointerEvents = 'auto'; // Enable clicks

        // Position marker based on stored coordinates
        positionMarker(marker, location.area_x, location.area_y);

        // Add click event for marker info
        marker.addEventListener('click', function (e) {
            e.stopPropagation();
            showLocationDetails(location);
        });

        // Add tooltip
        marker.title = `${location.location_name} (${location.location_code})`;

        markersContainer.appendChild(marker);
    }

    // Function to position marker based on coordinates and current zoom
    function positionMarker(marker, x, y) {
        const mapContainer = document.getElementById('mapContainer');
        const mapImage = document.getElementById('areaMapping');

        if (!mapContainer || !mapImage) return;

        const containerRect = mapContainer.getBoundingClientRect();
        const imageRect = mapImage.getBoundingClientRect();

        // Calculate the actual position within the container
        const imageOffsetX = imageRect.left - containerRect.left;
        const imageOffsetY = imageRect.top - containerRect.top;

        // Calculate position as percentage of image size
        const xPercent = (parseInt(x) / 800); // 800 is original map width
        const yPercent = (parseInt(y) / 400); // 400 is original map height

        // Calculate actual pixel position
        const actualX = imageOffsetX + (xPercent * imageRect.width);
        const actualY = imageOffsetY + (yPercent * imageRect.height);

        marker.style.left = actualX + 'px';
        marker.style.top = actualY + 'px';
    }

    // Function to update all markers position when zooming
    function updateAllMarkersPosition() {
        const markers = document.querySelectorAll('#locationMarkers .location-marker');
        markers.forEach(marker => {
            const x = marker.getAttribute('data-x');
            const y = marker.getAttribute('data-y');
            if (x !== null && y !== null) {
                positionMarker(marker, x, y);
            }
        });
    }

    // Function to show location details when marker is clicked
    function showLocationDetails(location) {
        showAlert(`Lokasi: ${location.location_name} (${location.location_code}) - Area: ${location.area_code}`, 'info');
    }

    // Delete location function with SweetAlert2 confirmation
    function deleteLocation(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data lokasi ini akan dihapus permanen dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang menghapus data lokasi',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX delete request
                fetch('<?= base_url('emergency_tools/master_location/api/delete/') ?>' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + id
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success || data.status === 'success') {
                            showAlert(data.message || 'Lokasi berhasil dihapus', 'success');
                            // Reload location list
                            loadLocationList();
                        } else {
                            showAlert(data.message || 'Gagal menghapus lokasi', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Gagal menghapus lokasi!', 'error');
                    });
            }
        });
    }
</script>