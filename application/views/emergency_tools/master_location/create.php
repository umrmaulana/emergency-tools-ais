<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi Baru - Emergency Tools</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            overflow: hidden;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
        }

        .location-marker {
            position: absolute;
            width: 14px;
            height: 14px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: 3px solid white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .location-marker.selected {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            width: 18px;
            height: 18px;
        }

        .map-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            background: #f8f9fa;
            cursor: crosshair;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .map-image {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="main-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="fas fa-map-marker-alt me-3"></i>Tambah Lokasi Baru</h1>
                        <p class="mb-0">Pilih posisi pada peta dan lengkapi informasi lokasi</p>
                    </div>
                    <a href="<?= base_url('index.php/emergency_tools/master_location') ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-4">
                <form id="locationForm" action="<?= base_url('index.php/emergency_tools/master_location/api/create') ?>"
                    method="POST">
                    <div class="row g-4">
                        <!-- Map Area -->
                        <div class="col-lg-8">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map me-2"></i>
                                        Pilih Posisi Lokasi
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div id="mapContainer" class="map-container" style="min-height: 500px;">
                                        <!-- Area Mapping Grid -->
                                        <img id="areaMapping"
                                            src="<?php echo base_url('assets/img/area_mapping_8x4.png'); ?>"
                                            class="map-image" style="width: 800px; height: 400px; object-fit: contain;"
                                            onclick="selectPoint(event)" alt="Area Mapping">

                                        <!-- Selected Point Marker -->
                                        <div id="selectedMarker" class="location-marker selected"
                                            style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <div id="positionInfo" class="alert alert-secondary mb-0">
                                        <i class="fas fa-crosshairs me-2"></i>
                                        Belum ada posisi yang dipilih
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Area -->
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-edit me-2"></i>Informasi Lokasi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Kode Lokasi <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="location_code" name="location_code"
                                            placeholder="Contoh: LOC001" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Nama Lokasi <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="location_name" name="location_name"
                                            placeholder="Contoh: Area Produksi A" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Area X</label>
                                                <input type="number" class="form-control" id="area_x" name="area_x"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Area Y</label>
                                                <input type="number" class="form-control" id="area_y" name="area_y"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kode Area</label>
                                        <input type="text" class="form-control" id="area_code" name="area_code"
                                            readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"
                                            placeholder="Tambahkan deskripsi atau catatan lokasi..."></textarea>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center">
                                    <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Simpan Lokasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Global variables
        let selectedX = null;
        let selectedY = null;
        let selectedArea = null;

        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Create form loaded');

            // Initialize form submission
            const form = document.getElementById('locationForm');
            if (form) {
                form.addEventListener('submit', handleFormSubmit);
            }
        });

        // Function to select point on map
        function selectPoint(event) {
            event.preventDefault();
            event.stopPropagation();

            const img = event.target;
            const rect = img.getBoundingClientRect();

            // Get click coordinates relative to image
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            // Store coordinates (convert to actual pixel coordinates)
            selectedX = Math.round((x / rect.width) * 800); // 800 is original map width
            selectedY = Math.round((y / rect.height) * 400); // 400 is original map height

            // Calculate area code based on grid (8x4)
            const gridX = Math.floor((x / rect.width) * 8);
            const gridY = Math.floor((y / rect.height) * 4);
            selectedArea = String.fromCharCode(65 + gridY) + (gridX + 1);

            // Update form fields
            document.getElementById('area_x').value = selectedX;
            document.getElementById('area_y').value = selectedY;
            document.getElementById('area_code').value = selectedArea;

            // Show marker at clicked position
            const marker = document.getElementById('selectedMarker');
            marker.style.left = x + 'px';
            marker.style.top = y + 'px';
            marker.style.display = 'block';

            // Update position info
            const positionInfo = document.getElementById('positionInfo');
            positionInfo.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>Posisi:</strong> (${selectedX}, ${selectedY}) - <strong>Area:</strong> ${selectedArea}
            `;
            positionInfo.className = 'alert alert-success mb-0';

            console.log('Selected position:', selectedX, selectedY, 'Area:', selectedArea);
        }

        // Handle form submission
        function handleFormSubmit(e) {
            e.preventDefault();

            // Validate required fields
            const locationCode = document.getElementById('location_code').value.trim();
            const locationName = document.getElementById('location_name').value.trim();

            if (!locationCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kode Lokasi Diperlukan!',
                    text: 'Silakan isi kode lokasi.',
                    confirmButtonColor: '#f39c12'
                }).then(() => {
                    document.getElementById('location_code').focus();
                });
                return;
            }

            if (!locationName) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama Lokasi Diperlukan!',
                    text: 'Silakan isi nama lokasi.',
                    confirmButtonColor: '#f39c12'
                }).then(() => {
                    document.getElementById('location_name').focus();
                });
                return;
            }

            if (selectedX === null || selectedY === null) {
                Swal.fire({
                    icon: 'info',
                    title: 'Pilih Posisi Lokasi!',
                    text: 'Silakan pilih posisi pada peta terlebih dahulu.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan Data...';
            submitBtn.disabled = true;

            // Prepare form data as URL encoded string  
            const formParams = new URLSearchParams();
            formParams.append('location_code', locationCode);
            formParams.append('location_name', locationName);
            formParams.append('area_x', selectedX);
            formParams.append('area_y', selectedY);
            formParams.append('area_code', selectedArea);
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
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Lokasi berhasil ditambahkan!',
                            confirmButtonColor: '#28a745',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            // Redirect after success
                            window.location.href = '<?= base_url("index.php/emergency_tools/master_location") ?>';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan!',
                            text: data.message || 'Gagal menambahkan lokasi!',
                            confirmButtonColor: '#dc3545'
                        });
                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Error!',
                        text: 'Error: ' + error.message,
                        confirmButtonColor: '#dc3545'
                    });
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }
    </script>
</body>

</html>