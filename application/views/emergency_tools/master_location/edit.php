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
        margin-top: 1rem;
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">
            <i class="fas fa-edit me-3"></i>Edit Lokasi
        </h2>
        <p class="text-muted mb-0">Perbarui informasi dan posisi lokasi</p>
    </div>
    <a href="<?= base_url('index.php/emergency_tools/master_location') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Content Area -->
<form id="locationForm" method="POST">
    <input type="hidden" id="location_id" name="id" value="<?= isset($location->id) ? $location->id : "" ?>">

    <div class="row">
        <!-- Map Section -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map me-2"></i>Posisi Lokasi pada Peta
                    </h5>
                    <small class="text-muted">Klik pada peta untuk mengubah posisi lokasi</small>
                </div>
                <div class="card-body p-0">
                    <div id="leafletMap"></div>
                </div>
            </div>

            <!-- Coordinate Info -->
            <div id="coordinateInfo" class="coordinate-info">
                <h6 class="text-primary mb-2">
                    <i class="fas fa-crosshairs me-2"></i>Koordinat Lokasi
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
                        <label for="location_code" class="form-label">Kode Lokasi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="location_code" name="location_code" required
                            value="<?= isset($location->location_code) ? htmlspecialchars($location->location_code) : "" ?>"
                            placeholder="Contoh: LOC-001">
                    </div>

                    <div class="mb-3">
                        <label for="location_name" class="form-label">Nama Lokasi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="location_name" name="location_name" required
                            value="<?= isset($location->location_name) ? htmlspecialchars($location->location_name) : "" ?>"
                            placeholder="Contoh: Fire Extinguisher Area A">
                    </div>

                    <div class="mb-3">
                        <label for="area_code" class="form-label">Kode Area</label>
                        <input type="text" class="form-control" id="area_code" name="area_code" readonly
                            value="<?= isset($location->area_code) ? htmlspecialchars($location->area_code) : "" ?>"
                            placeholder="Akan terisi otomatis">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="area_x" class="form-label">Koordinat X</label>
                                <input type="number" step="0.01" class="form-control" id="area_x" name="area_x" readonly
                                    value="<?= isset($location->area_x) ? $location->area_x : "" ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="area_y" class="form-label">Koordinat Y</label>
                                <input type="number" step="0.01" class="form-control" id="area_y" name="area_y" readonly
                                    value="<?= isset($location->area_y) ? $location->area_y : "" ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Deskripsi tambahan lokasi (opsional)"><?= isset($location->desc) ? htmlspecialchars($location->desc) : (isset($location->description) ? htmlspecialchars($location->description) : "") ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Update Lokasi
                    </button>
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

    // Location data from server
    const locationData = {
        id: '<?= isset($location->id) ? $location->id : "" ?>',
        location_code: '<?= isset($location->location_code) ? addslashes($location->location_code) : "" ?>',
        location_name: '<?= isset($location->location_name) ? addslashes($location->location_name) : "" ?>',
        area_x: '<?= isset($location->area_x) ? $location->area_x : "" ?>',
        area_y: '<?= isset($location->area_y) ? $location->area_y : "" ?>',
        area_code: '<?= isset($location->area_code) ? addslashes($location->area_code) : "" ?>',
        description: '<?= isset($location->desc) ? addslashes($location->desc) : (isset($location->description) ? addslashes($location->description) : "") ?>'
    };

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Edit form loaded with data:', locationData);

        // Initialize Leaflet map
        initializeMap();

        // Initialize form submission
        const form = document.getElementById('locationForm');
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }

        // Set initial coordinates from existing data
        if (locationData.area_x && locationData.area_y) {
            const lat = parseFloat(locationData.area_x);
            const lng = parseFloat(locationData.area_y);

            selectedCoordinates = { lat: lat, lng: lng };

            // Update coordinate display
            updateCoordinateDisplay(lat, lng, locationData.area_code);

            // Center map on existing location after a short delay
            setTimeout(() => {
                if (leafletMap) {
                    showMarkerAtPosition(lat, lng);
                }
            }, 500);
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

    // Show marker at specific position
    function showMarkerAtPosition(lat, lng) {
        // Remove existing marker if any
        if (selectedMarker) {
            leafletMap.removeLayer(selectedMarker);
        }

        // Create marker icon
        const markerIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="width: 20px; height: 20px; background: linear-gradient(135deg, #4facfe, #00f2fe); border: 3px solid white; border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.3);"></div>',
            iconSize: [26, 26],
            iconAnchor: [13, 13]
        });

        selectedMarker = L.marker([lat, lng], {
            icon: markerIcon
        }).addTo(leafletMap);

        // Center map on marker with appropriate zoom
        leafletMap.setView([lat, lng], 0); // Use zoom level 0 for better visibility within image bounds

        console.log('Marker positioned at:', lat, lng);
    }

    // Function to select location on map
    function selectLocation(latlng) {
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
    }

    // Handle form submission
    function handleFormSubmit(e) {
        e.preventDefault();

        // Validate required fields
        const locationCode = document.getElementById('location_code').value.trim();
        const locationName = document.getElementById('location_name').value.trim();
        const locationId = document.getElementById('location_id').value;

        if (!locationId) {
            Swal.fire({
                icon: 'error',
                title: 'ID Lokasi Tidak Valid',
                text: 'ID lokasi tidak ditemukan.',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        if (!locationCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Kode Lokasi Diperlukan',
                text: 'Silakan isi kode lokasi terlebih dahulu.',
                confirmButtonColor: '#f39c12'
            }).then(() => {
                document.getElementById('location_code').focus();
            });
            return;
        }

        if (!locationName) {
            Swal.fire({
                icon: 'warning',
                title: 'Nama Lokasi Diperlukan',
                text: 'Silakan isi nama lokasi terlebih dahulu.',
                confirmButtonColor: '#f39c12'
            }).then(() => {
                document.getElementById('location_name').focus();
            });
            return;
        }

        if (!selectedCoordinates) {
            Swal.fire({
                icon: 'warning',
                title: 'Koordinat Tidak Valid',
                text: 'Silakan pilih lokasi pada peta terlebih dahulu.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan Data...';
        submitBtn.disabled = true;

        // Prepare form data
        const formParams = new URLSearchParams();
        formParams.append('id', locationId);
        formParams.append('location_code', locationCode);
        formParams.append('location_name', locationName);
        formParams.append('area_x', selectedCoordinates.lat.toFixed(2));
        formParams.append('area_y', selectedCoordinates.lng.toFixed(2));
        formParams.append('area_code', document.getElementById('area_code').value);

        // Get current description value, preserve original if empty
        const currentDescription = document.getElementById('description').value;
        const finalDescription = currentDescription.trim() !== '' ? currentDescription : locationData.description;
        formParams.append('description', finalDescription);

        // Submit via AJAX
        fetch('<?= base_url("index.php/emergency_tools/master_location/api/update") ?>', {
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
                    text: 'Gagal mengupdate data lokasi. Silakan coba lagi.',
                    confirmButtonColor: '#dc3545'
                });
            });
    }
</script>