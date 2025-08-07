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
                            <div class="input-group" style="width: 250px;">
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
                        <table class="table table-hover data-table">
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
                                    required>
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
                        <div class="input-group">
                            <input type="text" class="form-control" id="qrcode" name="qrcode"
                                placeholder="Auto generate atau input manual">
                            <button class="btn btn-outline-secondary" type="button" onclick="generateQRCode()">
                                <i class="fas fa-magic me-1"></i>Auto Generate
                            </button>
                        </div>
                        <div class="form-text">QR Code akan di-generate otomatis jika kosong</div>
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

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .equipment-row {
        transition: all 0.3s ease;
    }

    .equipment-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .action-buttons .btn {
        transition: all 0.2s ease;
        margin: 0 1px;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        background-color: rgba(0, 123, 255, 0.05);
        padding: 1rem 0.75rem;
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    /* Loading states */
    .fa-spin {
        animation: fa-spin 1s infinite linear;
    }

    @keyframes fa-spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Search highlight effect */
    .input-group:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-radius: 8px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .input-group {
            width: 100% !important;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>

<script>
    let isEdit = false;
    let equipmentData = [];

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

        // Simulate API call - replace with actual endpoint
        fetch('<?= base_url("emergency_tools/equipment/api/get") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    equipmentData = data.data;
                    updateEquipmentTable();
                } else {
                    showErrorTable(data.message || 'Gagal memuat data equipment');
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
                    <td colspan="7" class="text-center text-muted">
                        <div class="py-5">
                            <i class="fas fa-inbox fa-4x mb-3 text-muted"></i><br>
                            <h5 class="text-muted">Belum ada data equipment</h5>
                            <p class="text-muted mb-3">Mulai dengan menambahkan equipment pertama Anda</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#equipmentModal" onclick="addEquipment()">
                                <i class="fas fa-plus me-2"></i>Tambah Equipment
                            </button>
                        </div>
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
                <tr class="equipment-row" data-equipment-id="${equipment.id}" style="animation: fadeIn 0.3s ease-in-out ${index * 0.1}s both;">
                    <td>
                        <span class="fw-bold text-primary">${escapeHtml(equipment.equipment_code)}</span>
                    </td>
                    <td>${escapeHtml(equipment.location_name || 'N/A')}</td>
                    <td>
                        <span class="badge bg-info">Type ID: ${equipment.equipment_type_id}</span>
                    </td>
                    <td>
                        ${equipment.qrcode ?
                    `<code>${escapeHtml(equipment.qrcode)}</code>` :
                    '<small class="text-muted">Belum ada</small>'
                }
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
                            <button class="btn btn-sm btn-outline-info"
                                onclick="generateQR(${equipment.id})"
                                title="Generate QR untuk ${escapeHtml(equipment.equipment_code)}" data-bs-toggle="tooltip">
                                <i class="fas fa-qrcode"></i>
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
                <td colspan="7" class="text-center text-danger">
                    <div class="py-4">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i><br>
                        <strong>Error:</strong> ${message}<br>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="refreshData()">
                                <i class="fas fa-sync-alt me-1"></i>Coba Lagi
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                                <i class="fas fa-redo me-1"></i>Reload Halaman
                            </button>
                        </div>
                    </div>
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
        loadDropdownData();
    }

    function editEquipment(id) {
        isEdit = true;
        document.getElementById('modalTitle').textContent = 'Edit Equipment';
        document.getElementById('equipmentId').value = id;

        // Load equipment data
        // This would typically be an AJAX call
        // For now, we'll use placeholder data
        loadDropdownData();

        // Show modal
        new bootstrap.Modal(document.getElementById('equipmentModal')).show();
    }

    function deleteEquipment(id) {
        if (confirm('Apakah Anda yakin ingin menghapus equipment ini?')) {
            // AJAX call to delete
            alert('Delete equipment ID: ' + id);
        }
    }

    function generateQR(id) {
        // Generate QR Code for specific equipment
        alert('Generate QR for equipment ID: ' + id);
    }

    function generateQRCode() {
        const equipmentCode = document.getElementById('equipmentCode').value;
        if (equipmentCode) {
            document.getElementById('qrcode').value = 'QR_' + equipmentCode.replace(/-/g, '_').toUpperCase();
        } else {
            alert('Masukkan Equipment Code terlebih dahulu!');
        }
    }

    function loadDropdownData() {
        // Load locations
        const locationSelect = document.getElementById('locationId');
        locationSelect.innerHTML = '<option value="">Pilih Lokasi</option>';

        // Sample data - replace with AJAX call
        const locations = [
            { id: 1, name: 'Area Produksi A' },
            { id: 2, name: 'Area Produksi B' },
            { id: 3, name: 'Gudang Material' },
            { id: 4, name: 'Office Area' }
        ];

        locations.forEach(location => {
            const option = document.createElement('option');
            option.value = location.id;
            option.textContent = location.name;
            locationSelect.appendChild(option);
        });

        // Load equipment types
        const typeSelect = document.getElementById('equipmentTypeId');
        typeSelect.innerHTML = '<option value="">Pilih Jenis</option>';

        // Sample data - replace with AJAX call
        const types = [
            { id: 1, name: 'Fire Extinguisher' },
            { id: 2, name: 'Emergency Light' },
            { id: 3, name: 'First Aid Kit' },
            { id: 4, name: 'Emergency Phone' }
        ];

        types.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = type.name;
            typeSelect.appendChild(option);
        });
    }

    // Form submission
    document.getElementById('equipmentForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const action = isEdit ? 'update' : 'create';

        // AJAX submission
        console.log('Submit equipment form:', action, Object.fromEntries(formData));

        // Close modal and reload page
        document.querySelector('[data-bs-dismiss="modal"]').click();
        // location.reload(); // Uncomment when implementing real AJAX

        alert('Equipment ' + (isEdit ? 'updated' : 'created') + ' successfully!');
    });
</script>