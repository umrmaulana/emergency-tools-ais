<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    #leafletMap {
        height: 500px;
        width: 100%;
        border-radius: 15px;
        overflow: hidden;
        /* Hide any overflow beyond card bounds */
    }

    .coordinate-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem
    }

    .btn-gradient {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        color: white;
    }

    .btn-gradient:hover {
        background: linear-gradient(45deg, #0056b3, #004085);
        color: white;
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">
            <i class="fas fa-plus me-3"></i>Tambah Lokasi Baru
        </h2>
        <p class="text-muted mb-0">Pilih lokasi pada peta dan isi informasi lokasi</p>
    </div>
    <a href="<?= base_url('index.php/emergency_tools/master_location') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Content Area -->
<form id="locationForm" method="POST">
    <div class="row">
        <!-- Map Section -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map me-2"></i>Pilih Lokasi pada Peta
                    </h5>
                    <small class="text-muted">Klik pada peta untuk menentukan posisi lokasi</small>
                </div>
                <div class="card-body p-0">
                    <div id="leafletMap"></div>
                </div>
            </div>

            <!-- Coordinate Info -->
            <div id="coordinateInfo" class="coordinate-info" style="display: none;">
                <h6 class="text-primary mb-2">
                    <i class="fas fa-crosshairs me-2"></i>Koordinat Terpilih
                </h6>
                <div id="coordinateDisplay" class="text-muted">
                    <!-- Coordinate info will be displayed here -->
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Lokasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="location_code" class="form-label">
                            <i class="fas fa-code me-1"></i>Kode Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="location_code" name="location_code" required
                            placeholder="Contoh: LOC-001">
                    </div>

                    <div class="mb-3">
                        <label for="location_name" class="form-label">
                            <i class="fas fa-tag me-1"></i>Nama Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="location_name" name="location_name" required
                            placeholder="Contoh: Fire Extinguisher Area A">
                    </div>

                    <div class="mb-3">
                        <label for="area_code" class="form-label">
                            <i class="fas fa-map-pin me-1"></i>Kode Area
                        </label>
                        <input type="text" class="form-control" id="area_code" name="area_code" readonly
                            placeholder="Akan terisi otomatis">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="area_x" class="form-label">Koordinat X</label>
                                <input type="number" step="0.01" class="form-control" id="area_x" name="area_x"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="area_y" class="form-label">Koordinat Y</label>
                                <input type="number" step="0.01" class="form-control" id="area_y" name="area_y"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Deskripsi
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Deskripsi tambahan lokasi (opsional)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan Lokasi
                    </button>

                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            (*) Field yang wajib diisi<br>
                            Pastikan telah memilih lokasi pada peta
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Global variables
    let leafletMap;
    let selectedMarker = null;
    let selectedCoordinates = null;

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Create form loaded');

        // Initialize Leaflet map
        initializeMap();

        // Initialize form submission
        const form = document.getElementById('locationForm');
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
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
            attributionControl: false,
            maxBoundsViscosity: 1.0 // Prevent dragging outside bounds
        });

        // Add the Mapping-area.png as the main layer
        L.imageOverlay('<?= base_url("assets/emergency_tools/img/Mapping-area.png") ?>', bounds, {
            opacity: 1.0
        }).addTo(leafletMap);

        // Fit map to show the full image and restrict bounds to image only
        leafletMap.fitBounds(bounds);
        leafletMap.setMaxBounds(bounds);

        // Set the initial view to show the entire image at maximum zoom out
        leafletMap.setView([imageHeight / 2, imageWidth / 2], leafletMap.getBoundsZoom(bounds));

        // Add click handler for selecting location - only within image bounds
        leafletMap.on('click', function (e) {
            // Check if click is within image bounds
            if (e.latlng.lat >= 0 && e.latlng.lat <= imageHeight &&
                e.latlng.lng >= 0 && e.latlng.lng <= imageWidth) {
                selectLocation(e.latlng);
            } else {
                console.log('Click outside image bounds, ignoring');
            }
        });

        console.log('Leaflet map initialized with image bounds only');
    }

    // Function to select location on map
    function selectLocation(latlng) {
        console.log('selectLocation called with:', latlng);

        // Remove existing marker if any
        if (selectedMarker) {
            leafletMap.removeLayer(selectedMarker);
        }

        // Create new marker
        const markerIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="width: 20px; height: 20px; background: linear-gradient(135deg, #4facfe, #00f2fe); border: 3px solid white; border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.3);"></div>',
            iconSize: [26, 26],
            iconAnchor: [13, 13]
        });

        selectedMarker = L.marker([latlng.lat, latlng.lng], {
            icon: markerIcon
        }).addTo(leafletMap);

        // Store selected coordinates
        selectedCoordinates = {
            lat: latlng.lat,
            lng: latlng.lng
        };

        console.log('Setting form fields:', latlng.lat.toFixed(2), latlng.lng.toFixed(2));

        // Update form fields with pixel coordinates
        document.getElementById('area_x').value = latlng.lat.toFixed(2);
        document.getElementById('area_y').value = latlng.lng.toFixed(2);

        // Generate area code based on coordinates
        const areaCode = generateAreaCode(latlng.lat, latlng.lng);
        document.getElementById('area_code').value = areaCode;

        // Update coordinate display
        updateCoordinateDisplay(latlng.lat, latlng.lng, areaCode);

        console.log('Selected location:', latlng.lat, latlng.lng, 'Area:', areaCode);
    }

    // Function to generate area code based on coordinates
    function generateAreaCode(lat, lng) {
        // Generate area code based on image pixel coordinates
        const normalizedX = Math.abs(lat);
        const normalizedY = Math.abs(lng);

        const gridX = Math.floor(normalizedX / 100) % 8; // 0-7
        const gridY = Math.floor(normalizedY / 125) % 4; // 0-3

        const areaLetter = String.fromCharCode(65 + gridY); // A-D
        const areaNumber = gridX + 1; // 1-8

        return areaLetter + areaNumber;
    }

    // Function to update coordinate display
    function updateCoordinateDisplay(lat, lng, areaCode) {
        const coordinateInfo = document.getElementById('coordinateInfo');
        const coordinateDisplay = document.getElementById('coordinateDisplay');

        coordinateDisplay.innerHTML = `
            <div class="row">
                <div class="col-6">
                    <strong>X Position:</strong><br>
                    <code>${lat.toFixed(2)}</code>
                </div>
                <div class="col-6">
                    <strong>Y Position:</strong><br>
                    <code>${lng.toFixed(2)}</code>
                </div>
            </div>
            <div class="mt-2">
                <strong>Area Code:</strong> 
                <span class="badge bg-primary">${areaCode}</span>
            </div>
        `;

        coordinateInfo.style.display = 'block';
    }

    // Handle form submission
    function handleFormSubmit(e) {
        e.preventDefault();

        // Validate required fields
        const locationCode = document.getElementById('location_code').value.trim();
        const locationName = document.getElementById('location_name').value.trim();

        if (!locationCode) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kode Lokasi Diperlukan',
                    text: 'Silakan isi kode lokasi terlebih dahulu.',
                    confirmButtonColor: '#f39c12'
                }).then(() => {
                    document.getElementById('location_code').focus();
                });
            } else {
                alert('Silakan isi kode lokasi terlebih dahulu.');
                document.getElementById('location_code').focus();
            }
            return;
        }

        if (!locationName) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama Lokasi Diperlukan',
                    text: 'Silakan isi nama lokasi terlebih dahulu.',
                    confirmButtonColor: '#f39c12'
                }).then(() => {
                    document.getElementById('location_name').focus();
                });
            } else {
                alert('Silakan isi nama lokasi terlebih dahulu.');
                document.getElementById('location_name').focus();
            }
            return;
        }

        if (!selectedCoordinates) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi Belum Dipilih',
                    text: 'Silakan pilih lokasi pada peta terlebih dahulu.',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                alert('Silakan pilih lokasi pada peta terlebih dahulu.');
            }
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan Data...';
        submitBtn.disabled = true;

        // Prepare form data
        const formParams = new URLSearchParams();
        formParams.append('location_code', locationCode);
        formParams.append('location_name', locationName);
        formParams.append('area_x', selectedCoordinates.lat.toFixed(2));
        formParams.append('area_y', selectedCoordinates.lng.toFixed(2));
        formParams.append('area_code', document.getElementById('area_code').value);
        formParams.append('description', document.getElementById('description').value);

        // Submit via AJAX
        fetch('<?= base_url("index.php/emergency_tools/master_location/api/create") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formParams.toString()
        })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        window.location.href = '<?= base_url("index.php/emergency_tools/master_location") ?>';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Gagal menyimpan data lokasi. Silakan coba lagi.',
                    confirmButtonColor: '#dc3545'
                });
            });
    }
</script>