<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    /* Animation and transition styles for consistency */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateX(2px);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .sortable {
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .sortable:hover {
        color: #0d6efd;
    }

    /* Leaflet Map Styles */
    #leafletMap {
        height: 600px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Custom marker popup styles */
    .custom-popup {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .custom-popup .popup-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .custom-popup .popup-content {
        font-size: 13px;
        color: #7f8c8d;
    }
</style>

<!-- Page Header -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Master Location</h2>
                    <p class="text-muted mb-0">Kelola data lokasi emergency tools</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshData()" title="Refresh Data"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <a href="<?= base_url('emergency_tools/master_location/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Lokasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map me-2 text-primary"></i>
                            Peta Lokasi Area Pabrik
                        </h5>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" onclick="fitMapToMarkers()">
                            <i class="fas fa-expand me-1"></i>Fit All Markers
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="leafletMap"></div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control" id="locationSearch"
                    placeholder="Cari berdasarkan kode atau nama lokasi...">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="entriesPerPage">
                <option value="10">10 entries</option>
                <option value="25">25 entries</option>
                <option value="50">50 entries</option>
                <option value="100">100 entries</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-secondary" onclick="refreshData()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Location List Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        Daftar Lokasi
                        <small class="text-muted" id="locationCount">(0 items)</small>
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="locationTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%" class="sortable" data-sort="location_code">
                                    Kode Lokasi <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th style="width: 25%" class="sortable" data-sort="location_name">
                                    Nama Lokasi <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th style="width: 10%">Area</th>
                                <th style="width: 20%">Koordinat</th>
                                <th style="width: 25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="locationTableBody">
                            <tr id="loadingRow">
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="text-muted">Memuat data lokasi...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div id="tableInfo" class="text-muted">
                    Menampilkan 0 dari 0 entries
                </div>
                <div id="tablePagination">
                    <!-- Pagination akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Global variables for location data and pagination
    let allLocations = []; // Store all location data
    let currentPage = 1;
    let entriesPerPage = 10;
    let leafletMap;
    let markers = [];

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Leaflet map
        initializeMap();

        // Load location data
        loadLocationList();

        // Initialize search functionality
        const searchInput = document.getElementById('locationSearch');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(filterLocations, 300));
        }

        // Initialize entries per page change
        const entriesSelect = document.getElementById('entriesPerPage');
        if (entriesSelect) {
            entriesSelect.addEventListener('change', function () {
                entriesPerPage = parseInt(this.value);
                currentPage = 1;
                filterLocations();
            });
        }
    });

    // Initialize Leaflet map with only Mapping-area.png image
    function initializeMap() {
        // Calculate image dimensions for proper display
        var imageWidth = 1000;  // Adjust based on your image width
        var imageHeight = 800;  // Adjust based on your image height
        var bounds = [[0, 0], [imageHeight, imageWidth]];

        // Initialize map without any base layer
        leafletMap = L.map('leafletMap', {
            crs: L.CRS.Simple,
            minZoom: -2,
            maxZoom: 3,
            zoomControl: true,
            attributionControl: false
        });

        // Add the Mapping-area.png as the main layer
        L.imageOverlay('<?= base_url("assets/emergency_tools/img/Mapping-area.png") ?>', bounds, {
            opacity: 1.0
        }).addTo(leafletMap);

        // Fit map to the bounds of the image and set max bounds
        leafletMap.fitBounds(bounds);

        // Set maximum zoom out to show only the image (no padding for zoom out limit)
        leafletMap.setMaxBounds(bounds);

        // Set the initial view to show the entire image at maximum zoom out
        leafletMap.setView([imageHeight / 2, imageWidth / 2], leafletMap.getBoundsZoom(bounds)); console.log('Leaflet map initialized');
    }

    // Function to add markers to the map
    function addMarkersToMap(locations) {
        console.log('addMarkersToMap called with:', locations);

        // Clear existing markers
        markers.forEach(marker => leafletMap.removeLayer(marker));
        markers = [];

        // Add new markers
        locations.forEach((location, index) => {
            console.log(`Processing location ${index}:`, location);

            if (location.area_x && location.area_y) {
                // Convert coordinates to image pixel coordinates
                const x = parseFloat(location.area_x);
                const y = parseFloat(location.area_y);

                console.log(`Creating marker at coordinates: ${x}, ${y}`);

                // Create custom marker icon
                const markerIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: '<div style="width: 16px; height: 16px; background: #dc3545; border: 3px solid white; border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.3);"></div>',
                    iconSize: [22, 22],
                    iconAnchor: [11, 11]
                });

                // Create marker using the stored coordinates as pixel positions
                const marker = L.marker([x, y], {
                    icon: markerIcon
                }).addTo(leafletMap);

                // Add popup with location info
                const popupContent = `
                    <div class="custom-popup">
                        <div class="popup-title">${escapeHtml(location.location_name)}</div>
                        <div class="popup-content">
                            <strong>Kode:</strong> ${escapeHtml(location.location_code)}<br>
                            <strong>Area:</strong> ${escapeHtml(location.area_code || '-')}<br>
                            <strong>Koordinat:</strong> ${location.area_x}, ${location.area_y}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-primary" onclick="editLocation(${location.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteLocation(${location.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
                markers.push(marker);
                console.log(`Marker ${index} created successfully`);
            } else {
                console.log(`Skipping location ${index} - missing coordinates`);
            }
        });

        console.log(`Total markers created: ${markers.length}`);
    }

    // Function to filter locations based on search
    function filterLocations() {
        const searchTerm = document.getElementById('locationSearch').value.toLowerCase();
        const filteredLocations = allLocations.filter(location =>
            location.location_code.toLowerCase().includes(searchTerm) ||
            location.location_name.toLowerCase().includes(searchTerm) ||
            (location.area_code && location.area_code.toLowerCase().includes(searchTerm))
        );

        currentPage = 1;
        renderLocationTable(filteredLocations);
        addMarkersToMap(filteredLocations);
        updateLocationCount(filteredLocations.length);
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
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Tidak ada data lokasi yang ditemukan</p>
                    </td>
                </tr>
            `;
        } else {
            pageLocations.forEach((location, index) => {
                const row = `
                    <tr>
                        <td>${startIndex + index + 1}</td>
                        <td>
                            <span class="badge bg-secondary">${escapeHtml(location.location_code)}</span>
                        </td>
                        <td>
                            <strong>${escapeHtml(location.location_name)}</strong>
                            ${location.desc ? `<br><small class="text-muted">${escapeHtml(location.desc)}</small>` : ''}
                        </td>
                        <td>
                            <span class="badge bg-info">${escapeHtml(location.area_code || '-')}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                ${location.area_x && location.area_y ?
                        `${parseFloat(location.area_x).toFixed(2)},<br>${parseFloat(location.area_y).toFixed(2)}` :
                        '-'}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="editLocation(${location.id})" title="Edit Lokasi">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" 
                                        onclick="viewOnMap(${location.area_x}, ${location.area_y})" title="Lihat di Peta">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteLocation(${location.id})" title="Hapus Lokasi">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
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
            if (total > 0) {
                tableInfo.textContent = `Menampilkan ${start} sampai ${end} dari ${total} entries`;
            } else {
                tableInfo.textContent = 'Menampilkan 0 dari 0 entries';
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
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            `;
        }

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>
                    </li>
                `;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            `;
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
        return text ? text.toString().replace(/[&<>"']/g, function (m) { return map[m]; }) : '';
    }

    // Function to show alert messages using SweetAlert2
    function showAlert(message, type = 'success') {
        // Check if SweetAlert2 is available
        if (typeof Swal === 'undefined') {
            console.warn('SweetAlert2 not available, using standard alert');
            alert(message);
            return;
        }

        let icon = 'success';
        let confirmButtonColor = '#28a745';

        switch (type) {
            case 'error':
                icon = 'error';
                confirmButtonColor = '#dc3545';
                break;
            case 'warning':
                icon = 'warning';
                confirmButtonColor = '#ffc107';
                break;
            case 'info':
                icon = 'info';
                confirmButtonColor = '#17a2b8';
                break;
        }

        Swal.fire({
            icon: icon,
            title: type === 'success' ? 'Berhasil!' : (type === 'error' ? 'Error!' : 'Informasi'),
            text: message,
            confirmButtonColor: confirmButtonColor,
            showConfirmButton: type !== 'success'
        });
    }

    // Function to load and refresh location list
    function loadLocationList() {
        console.log('loadLocationList called');

        // Show loading state
        showLoadingState();

        const url = '<?= base_url("index.php/emergency_tools/master_location/api/get") ?>';
        console.log('Fetching from URL:', url);

        fetch(url)
            .then(response => {
                console.log('Response received:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.success) {
                    allLocations = data.data;
                    console.log('allLocations set to:', allLocations);
                    renderLocationTable();
                    addMarkersToMap(allLocations);
                    updateLocationCount(allLocations.length);
                    console.log('Loaded locations:', allLocations);
                } else {
                    console.error('Failed to load locations:', data.message);
                    showAlert('Gagal memuat data lokasi: ' + data.message, 'error');
                    showEmptyState();
                }
            })
            .catch(error => {
                console.error('Error loading locations:', error);
                showAlert('Terjadi kesalahan saat memuat data lokasi', 'error');
                showEmptyState();
            });
    }

    // Function to view location on map
    function viewOnMap(lat, lng) {
        if (lat && lng) {
            const x = parseFloat(lat);
            const y = parseFloat(lng);

            leafletMap.setView([x, y], 0); // Use zoom level 0 for better visibility within image bounds

            // Find and open the popup for this location
            markers.forEach(marker => {
                const markerLatLng = marker.getLatLng();
                if (Math.abs(markerLatLng.lat - x) < 0.1 &&
                    Math.abs(markerLatLng.lng - y) < 0.1) {
                    marker.openPopup();
                }
            });
        }
    }

    // Function to edit location
    function editLocation(id) {
        window.location.href = `<?= base_url('index.php/emergency_tools/master_location/edit') ?>/${id}`;
    }

    // Delete location function with SweetAlert2 confirmation
    function deleteLocation(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus lokasi ini? Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?= base_url('index.php/emergency_tools/master_location/api/delete') ?>/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message, 'success');
                            loadLocationList(); // Refresh the list
                        } else {
                            showAlert(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting location:', error);
                        showAlert('Terjadi kesalahan saat menghapus lokasi', 'error');
                    });
            }
        });
    }

    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Utility functions for loading states
    function showLoadingState() {
        const tbody = document.getElementById('locationTableBody');
        tbody.innerHTML = `
            <tr id="loadingRow">
                <td colspan="6" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="spinner-border spinner-border-sm text-primary mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="text-muted">Memuat data lokasi...</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function showEmptyState() {
        const tbody = document.getElementById('locationTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x text-muted mb-2"></i>
                        <span class="text-muted">Tidak ada data lokasi</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function updateLocationCount(count) {
        const countElement = document.getElementById('locationCount');
        if (countElement) {
            countElement.textContent = `(${count} items)`;
        }
    }

    // Refresh data function
    function refreshData() {
        console.log('Refreshing location data...');
        loadLocationList();
    }
</script>