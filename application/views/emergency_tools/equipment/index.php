<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Equipment Management</h2>
                    <p class="text-muted mb-0">Kelola data equipment emergency tools</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshData()" title="Refresh Data"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#equipmentModal"
                        onclick="addEquipment()">
                        <i class="fas fa-plus me-2"></i>Tambah Equipment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tools me-2 text-primary"></i>
                                Data Equipment
                                <small class="text-muted" id="equipmentCount">(0 items)</small>
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input-group w-250">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari equipment..."
                                    onkeyup="searchEquipments()">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Equipment Code</th>
                                    <th>Lokasi</th>
                                    <th>Jenis</th>
                                    <th>QR Code</th>
                                    <th>Last Check</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="equipmentTableBody">
                                <!-- Data akan dimuat secara dinamis -->
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <div class="d-flex justify-content-center align-items-center py-4">
                                            <div class="spinner-border text-primary me-3" role="status"
                                                id="loadingSpinner">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span>Memuat data equipment...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Equipment Modal -->
<div class="modal fade" id="equipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="equipmentForm">
                <div class="modal-body">
                    <input type="hidden" id="equipmentId" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Equipment Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="equipmentCode" name="equipment_code"
                                    required onblur="autoGenerateQROnBlur()">
                                <div class="form-text">Contoh: APAR-PA-001</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <select class="form-select" id="locationId" name="location_id" required>
                                    <option value="">Pilih Lokasi</option>
                                    <!-- Will be populated via AJAX -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Equipment <span class="text-danger">*</span></label>
                                <select class="form-select" id="equipmentTypeId" name="equipment_type_id" required>
                                    <option value="">Pilih Jenis</option>
                                    <!-- Will be populated via AJAX -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">QR Code</label>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="qrcode" name="qrcode"
                                        placeholder="QR Code akan dibuat otomatis" readonly style="display: none;">
                                    <div class="form-control bg-light text-muted">
                                        <i class="fas fa-qrcode me-2"></i>QR Code akan dibuat otomatis
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="qr-preview text-center" id="qrPreview">
                                    <span class="text-muted">QR Code Preview</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-text">
                            QR Code image akan dibuat otomatis saat equipment disimpan
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode me-2"></i>QR Code - <span id="qrModalTitle"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="qr-code-display mb-3">
                    <img id="qrModalImage" src="" alt="QR Code" class="img-fluid"
                        style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div class="qr-code-info">
                    <p class="text-muted mb-2">Equipment Code: <strong id="qrModalCode"></strong></p>
                    <p class="text-muted small">Scan QR code ini untuk mengakses detail equipment</p>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" onclick="downloadQRCodeFromModal()">
                    <i class="fas fa-download me-2"></i>Download QR Code
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let isEdit = false;
    let equipmentData = [];

    // Base URL for asset paths
    function base_url() {
        return '<?= base_url() ?>';
    }

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        loadEquipmentData();
    });

    // Load equipment data
    function loadEquipmentData() {
        const tbody = document.getElementById('equipmentTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat data equipment...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch('<?= base_url("emergency_tools/equipment/api/get") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    equipmentData = data.data;
                    updateEquipmentTable();
                } else {
                    showErrorTable('Gagal memuat data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error loading equipment data:', error);
                showErrorTable('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
            });
    }

    // Update equipment table
    function updateEquipmentTable() {
        const tbody = document.getElementById('equipmentTableBody');
        const countElement = document.getElementById('equipmentCount');

        if (!equipmentData || equipmentData.length === 0) {
            countElement.textContent = '(0 items)';
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 text-muted"></i><br>
                        Belum ada data equipment
                    </td>
                </tr>
            `;
            return;
        }

        countElement.textContent = `(${equipmentData.length} items)`;

        tbody.innerHTML = equipmentData.map((equipment, index) => {
            const status = equipment.status || 'active';
            let badgeClass = '';
            switch (status) {
                case 'active': badgeClass = 'bg-success'; break;
                case 'inactive': badgeClass = 'bg-secondary'; break;
                case 'maintenance': badgeClass = 'bg-warning'; break;
                default: badgeClass = 'bg-secondary';
            }

            return `
                <tr class="equipment-row" data-equipment-id="${equipment.id}">
                    <td>
                        <span class="fw-bold text-primary">${escapeHtml(equipment.equipment_code)}</span>
                    </td>
                    <td>${escapeHtml(equipment.location_name || 'N/A')}</td>
                    <td>
                        <div>
                            <span class="fw-bold text-dark">${escapeHtml(equipment.equipment_name || 'N/A')}</span><br>
                            <small class="text-muted">${escapeHtml(equipment.equipment_type || 'N/A')}</small>
                        </div>
                    </td>
                    <td class="qr-code-cell">
                        <div class="qr-code-container">
                            ${equipment.qrcode && equipment.qrcode.includes('assets/') ?
                    `<div class="qr-code-wrapper">
                                    <img src="${base_url()}${equipment.qrcode}" 
                                         alt="QR Code" 
                                         class="qr-code-img"
                                         title="QR Code: ${escapeHtml(equipment.equipment_code)}"
                                         onclick="viewQRCode('${base_url()}${equipment.qrcode}', '${escapeHtml(equipment.equipment_code)}')">
                                    <div class="qr-code-actions">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="viewQRCode('${base_url()}${equipment.qrcode}', '${escapeHtml(equipment.equipment_code)}')"
                                                title="Lihat QR Code">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="downloadQRCode('${base_url()}${equipment.qrcode}', '${escapeHtml(equipment.equipment_code)}')"
                                                title="Download QR Code">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="equipment-code-title">${escapeHtml(equipment.equipment_code)}</div>` :
                    `<div class="no-qr-placeholder">
                                    <i class="fas fa-qrcode text-muted mb-2"></i>
                                    <small class="text-muted d-block mb-2">No QR Code</small>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="generateQRCode(${equipment.id})"
                                            title="Generate QR Code">
                                        <i class="fas fa-plus me-1"></i>Generate
                                    </button>
                                    <div class="equipment-code-title mt-2">${escapeHtml(equipment.equipment_code)}</div>
                                </div>`
                }
                        </div>
                    </td>
                    <td>
                        ${equipment.last_check_date ?
                    `<small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                ${new Date(equipment.last_check_date).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    })}
                            </small>` :
                    '<small class="text-warning">Belum pernah dicek</small>'
                }
                    </td>
                    <td>
                        <span class="badge ${badgeClass}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group action-buttons" role="group">
                            <button class="btn btn-sm btn-outline-primary"
                                onclick="editEquipment(${equipment.id})"
                                title="Edit ${escapeHtml(equipment.equipment_code)}" data-bs-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteEquipment(${equipment.id})"
                                title="Hapus ${escapeHtml(equipment.equipment_code)}" data-bs-toggle="tooltip">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Search function
    function searchEquipments() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.equipment-row');
        const countElement = document.getElementById('equipmentCount');

        let visibleCount = 0;
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counter
        if (searchTerm !== '') {
            countElement.textContent = `(${visibleCount} dari ${equipmentData.length} items)`;
            countElement.classList.add('text-primary');
        } else {
            countElement.textContent = `(${equipmentData.length} items)`;
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
        loadEquipmentData();

        setTimeout(() => {
            refreshIcon.classList.remove('fa-spin');
            refreshBtn.disabled = false;
        }, 1000);
    }

    // Show error table
    function showErrorTable(message) {
        const tbody = document.getElementById('equipmentTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-danger py-4">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                    ${message}
                </td>
            </tr>
        `;
    }

    // Utility function
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function addEquipment() {
        isEdit = false;
        document.getElementById('modalTitle').textContent = 'Tambah Equipment';
        document.getElementById('equipmentForm').reset();
        document.getElementById('equipmentId').value = '';

        // Reset QR preview
        const qrPreview = document.getElementById('qrPreview');
        qrPreview.innerHTML = '<span class="text-muted">QR Code Preview</span>';

        loadDropdownData();
    }

    function editEquipment(id) {
        isEdit = true;
        document.getElementById('modalTitle').textContent = 'Edit Equipment';
        document.getElementById('equipmentId').value = id;

        // Load dropdown data first, then load equipment data
        loadDropdownData().then(() => {
            // Load equipment data after dropdowns are loaded
            return fetch(`<?= base_url("emergency_tools/equipment/api/get/") ?>${id}`);
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const equipment = data.data;
                    document.getElementById('equipmentCode').value = equipment.equipment_code;
                    document.getElementById('locationId').value = equipment.location_id;
                    document.getElementById('equipmentTypeId').value = equipment.equipment_type_id;
                    document.getElementById('status').value = equipment.status || 'active';

                    // Show QR preview for existing equipment
                    const qrPreview = document.getElementById('qrPreview');
                    if (equipment.qrcode && equipment.qrcode.includes('assets/')) {
                        // Display saved QR image
                        const qrUrl = base_url() + equipment.qrcode;

                        qrPreview.innerHTML = `
                        <img src="${qrUrl}" alt="QR Code Preview" title="QR Code: ${equipment.equipment_code}">
                        <div class="mt-2 small text-muted">${equipment.equipment_code}</div>
                    `;
                    } else {
                        qrPreview.innerHTML = '<span class="text-muted">No QR Image Available</span>';
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', data.message, 'error');
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading equipment data:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Gagal memuat data equipment', 'error');
                } else {
                    alert('Error: Gagal memuat data equipment');
                }
            });

        // Show modal
        new bootstrap.Modal(document.getElementById('equipmentModal')).show();
    }

    function deleteEquipment(id) {
        const confirmMessage = 'Apakah Anda yakin ingin menghapus equipment ini?';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
            });
        } else {
            if (confirm(confirmMessage)) {
                performDelete(id);
            }
        }
    }

    function performDelete(id) {
        fetch(`<?= base_url("emergency_tools/equipment/api/delete/") ?>${id}`, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Berhasil!', data.message, 'success');
                    } else {
                        alert('Success: ' + data.message);
                    }
                    loadEquipmentData();
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', data.message, 'error');
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error deleting equipment:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Gagal menghapus equipment', 'error');
                } else {
                    alert('Error: Gagal menghapus equipment');
                }
            });
    }

    function autoGenerateQROnBlur() {
        const equipmentCode = document.getElementById('equipmentCode').value.trim();
        const qrPreview = document.getElementById('qrPreview');

        if (equipmentCode && !isEdit) {
            // Show placeholder message since QR image will be generated on save
            qrPreview.innerHTML = `
                <div class="text-center text-info">
                    <i class="fas fa-qrcode fa-2x mb-2"></i><br>
                    <small>QR Code akan dibuat saat menyimpan</small>
                    <div class="mt-2 small text-muted">${equipmentCode}</div>
                </div>
            `;
        } else if (!equipmentCode) {
            // Clear QR preview if equipment code is empty
            qrPreview.innerHTML = '<span class="text-muted">QR Code Preview</span>';
        }
    }

    function loadDropdownData() {
        const promises = [];

        // Load locations
        const locationSelect = document.getElementById('locationId');
        locationSelect.innerHTML = '<option value="">Pilih Lokasi</option>';

        const locationPromise = fetch('<?= base_url("emergency_tools/equipment/api/get_locations") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name;
                        locationSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading locations:', error);
            });

        promises.push(locationPromise);

        // Load equipment types
        const typeSelect = document.getElementById('equipmentTypeId');
        typeSelect.innerHTML = '<option value="">Pilih Jenis</option>';

        const typePromise = fetch('<?= base_url("emergency_tools/equipment/api/get_equipment_types") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.id;
                        option.textContent = type.name;
                        typeSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading equipment types:', error);
            });

        promises.push(typePromise);

        // Return promise that resolves when all dropdowns are loaded
        return Promise.all(promises);
    }

    // Form submission
    document.getElementById('equipmentForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const action = isEdit ? 'update' : 'create';

        // For create, remove qrcode field - let controller generate it
        if (!isEdit) {
            formData.delete('qrcode');
        }

        // Debug: Log form data for edit
        if (isEdit) {
            console.log('Edit form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key, '=', value);
            }
        }

        submitForm(formData, action);
    });

    function submitForm(formData, action) {
        // Show loading state
        const submitBtn = document.querySelector('#equipmentForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        fetch(`<?= base_url("emergency_tools/equipment/api/") ?>${action}`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Berhasil!', data.message, 'success');
                    } else {
                        alert('Success: ' + data.message);
                    }

                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('equipmentModal'));
                    modal.hide();

                    // Reload data
                    loadEquipmentData();

                    // Show QR code success message for new equipment
                    if (!isEdit && data.qr_image_url) {
                        setTimeout(() => {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'QR Code Created!',
                                    text: 'QR Code image telah disimpan untuk equipment ini',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        }, 1000);
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', data.message, 'error');
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data', 'error');
                } else {
                    alert('Error: Terjadi kesalahan saat menyimpan data');
                }
            })
            .finally(() => {
                // Restore button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
    }

    // QR Code functions
    let currentQRData = {};

    function viewQRCode(qrImageUrl, equipmentCode) {
        currentQRData = {
            imageUrl: qrImageUrl,
            code: equipmentCode
        };

        document.getElementById('qrModalTitle').textContent = equipmentCode;
        document.getElementById('qrModalCode').textContent = equipmentCode;
        document.getElementById('qrModalImage').src = qrImageUrl;

        const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        modal.show();
    }

    function downloadQRCode(qrImageUrl, equipmentCode) {
        // Create a temporary link to download the image
        const link = document.createElement('a');
        link.href = qrImageUrl;
        link.download = `QR_Code_${equipmentCode}.png`;

        // Trigger download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Show success message
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Download Started!',
                text: `QR Code untuk ${equipmentCode} sedang didownload`,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    function downloadQRCodeFromModal() {
        if (currentQRData.imageUrl && currentQRData.code) {
            downloadQRCode(currentQRData.imageUrl, currentQRData.code);
        }
    }

    // Generate QR Code button functionality in modal
    function generateQRCode(equipmentId) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Generate QR Code',
                text: 'Apakah Anda ingin membuat QR Code untuk equipment ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Generate!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Generating QR Code...',
                        text: 'Sedang membuat QR Code',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Call API to generate QR code
                    fetch(`<?= base_url("emergency_tools/equipment/api/generate_qr/") ?>${equipmentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'QR Code Generated!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Reload equipment data to show new QR code
                                loadEquipmentData();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error generating QR code:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat membuat QR Code'
                            });
                        });
                }
            });
        }
    }
</script>

<style>
    /* QR Code styling improvements */
    .qr-code-cell {
        text-align: center;
        vertical-align: middle !important;
        width: 120px;
    }

    .qr-code-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80px;
    }

    .qr-code-wrapper {
        position: relative;
        display: inline-block;
    }

    .qr-code-img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .qr-code-img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .qr-code-actions {
        display: none;
        position: absolute;
        top: -5px;
        right: -5px;
        flex-direction: column;
        gap: 2px;
    }

    .qr-code-wrapper:hover .qr-code-actions {
        display: flex;
    }

    .qr-code-actions .btn {
        width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.75rem;
    }

    .equipment-code-title {
        font-size: 10px;
        color: #6c757d;
        margin-top: 4px;
        font-weight: 500;
        word-break: break-all;
    }

    .no-qr-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 80px;
        min-height: 60px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background-color: #f8f9fa;
        margin: 0 auto;
        padding: 8px 4px;
    }

    .no-qr-placeholder i {
        font-size: 16px;
        color: #adb5bd;
    }

    .no-qr-placeholder .btn {
        font-size: 0.7rem;
        padding: 2px 6px;
    }

    /* QR Modal styling */
    #qrCodeModal .modal-dialog {
        max-width: 450px;
    }

    #qrCodeModal .qr-code-display {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    #qrCodeModal .qr-code-display img {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    #qrCodeModal .qr-code-info {
        background: #e7f3ff;
        padding: 12px;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
    }

    /* Responsive QR code */
    @media (max-width: 768px) {
        .qr-code-cell {
            width: 100px;
        }

        .qr-code-img {
            width: 50px;
            height: 50px;
        }

        .no-qr-placeholder {
            width: 70px;
            min-height: 50px;
        }

        .equipment-code-title {
            font-size: 9px;
        }
    }
</style>