<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Master Equipment Types</h2>
                    <p class="text-muted mb-0">Kelola jenis-jenis equipment emergency tools</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshData()" title="Refresh Data"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#equipmentTypeModal"
                        onclick="addEquipmentType()">
                        <i class="fas fa-plus me-2"></i>Tambah Jenis Equipment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Types Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cubes me-2 text-primary"></i>
                                Jenis Equipment
                                <small class="text-muted" id="equipmentCount">(0 items)</small>
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 250px;">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari equipment..."
                                    onkeyup="searchEquipmentTypes()">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="equipmentTypesTable">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Equipment Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="equipmentTypesBody">
                                <!-- Data akan dimuat secara dinamis -->
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <div class="d-flex justify-content-center align-items-center py-4">
                                            <div class="spinner-border text-primary me-3" role="status"
                                                id="loadingSpinner">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span>Memuat data equipment types...</span>
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

<!-- Equipment Type Modal -->
<div class="modal fade" id="equipmentTypeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Jenis Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="equipmentTypeForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="equipmentTypeId" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Equipment Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="equipmentName" name="equipment_name"
                                    required>
                                <div class="form-text">Contoh: Fire Extinguisher</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Equipment Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="equipmentType" name="equipment_type"
                                    required>
                                <div class="form-text">Contoh: APAR, LAMPU_DARURAT, P3K</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="desc" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Icon Upload</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="iconFile" name="icon_file"
                                        accept="image/*" onchange="previewIcon()">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="document.getElementById('iconFile').click()">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                                <div class="form-text">Upload gambar untuk icon (PNG, JPG, SVG - Max 2MB)</div>

                                <!-- Icon Preview -->
                                <div id="iconPreviewContainer" class="mt-2" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img id="iconPreviewImg" src="" alt="Preview"
                                                style="width: 40px; height: 40px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <div>
                                            <small class="text-muted">Preview icon</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Icon for Edit -->
                                <div id="currentIconContainer" class="mt-2" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img id="currentIconImg" src="" alt="Current Icon"
                                                style="width: 40px; height: 40px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <div>
                                            <small class="text-muted">Icon saat ini</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="isActive" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Jenis equipment yang sudah dibuat akan mempengaruhi template
                        checksheet. Upload icon dalam format PNG atau SVG untuk hasil terbaik.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
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

    .equipment-icon {
        transition: all 0.3s ease;
    }

    .equipment-row:hover .equipment-icon {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4) !important;
    }

    .equipment-info .fw-bold {
        transition: color 0.3s ease;
    }

    .equipment-row:hover .equipment-info .fw-bold {
        color: #007bff !important;
    }

    .equipment-type-badge {
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 0.375rem 0.75rem;
    }

    .equipment-row:hover .equipment-type-badge {
        transform: scale(1.05);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .description-cell {
        max-width: 250px;
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

    .modal-header {
        border-bottom: 2px solid #f8f9fa;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
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

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #b8daff);
        border: none;
        border-radius: 10px;
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

        .equipment-icon {
            width: 35px !important;
            height: 35px !important;
        }

        .equipment-info .fw-bold {
            font-size: 0.9rem;
        }

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
        }

        .description-cell {
            max-width: 150px;
        }
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
</style>

<script>
    let isEdit = false;
    let equipmentTypesData = [];

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        loadEquipmentTypes();
    });

    function addEquipmentType() {
        isEdit = false;
        document.getElementById('modalTitle').textContent = 'Tambah Jenis Equipment';
        document.getElementById('equipmentTypeForm').reset();
        document.getElementById('equipmentTypeId').value = '';

        // Hide preview containers
        document.getElementById('iconPreviewContainer').style.display = 'none';
        document.getElementById('currentIconContainer').style.display = 'none';
    }

    function editEquipmentType(id) {
        isEdit = true;
        document.getElementById('modalTitle').textContent = 'Edit Jenis Equipment';
        document.getElementById('equipmentTypeId').value = id;

        // Show loading
        Swal.fire({
            title: 'Loading...',
            text: 'Mengambil data equipment type',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Fetch equipment type data
        fetch(`<?= base_url('emergency_tools/master_equipment/api/get/') ?>${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success && data.data) {
                    const equipment = data.data;
                    document.getElementById('equipmentName').value = equipment.equipment_name;
                    document.getElementById('equipmentType').value = equipment.equipment_type;
                    document.getElementById('description').value = equipment.desc || '';
                    document.getElementById('isActive').value = equipment.is_active;

                    // Show current icon if exists
                    if (equipment.icon_url) {
                        const currentIconImg = document.getElementById('currentIconImg');
                        currentIconImg.src = `<?= base_url('assets/emergency_tools/img/equipment/') ?>${equipment.icon_url}`;
                        document.getElementById('currentIconContainer').style.display = 'block';
                    } else {
                        document.getElementById('currentIconContainer').style.display = 'none';
                    }

                    // Hide preview container initially
                    document.getElementById('iconPreviewContainer').style.display = 'none';

                    // Show modal
                    new bootstrap.Modal(document.getElementById('equipmentTypeModal')).show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Gagal mengambil data equipment type'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data'
                });
            });
    }

    function deleteEquipmentType(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus equipment type ini? Data equipment yang menggunakan jenis ini mungkin akan terpengaruh.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang menghapus equipment type',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`<?= base_url('emergency_tools/master_equipment/api/delete/') ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Reload table with animation delay
                            setTimeout(() => {
                                loadEquipmentTypes();
                            }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    });
            }
        });
    }

    function previewIcon() {
        const fileInput = document.getElementById('iconFile');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('iconPreviewImg').src = e.target.result;
                document.getElementById('iconPreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('iconPreviewContainer').style.display = 'none';
        }
    }

    function loadEquipmentTypes() {
        // Show loading state
        const tbody = document.getElementById('equipmentTypesBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat data equipment types...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch('<?= base_url('emergency_tools/master_equipment/api/get') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    equipmentTypesData = data.data;
                    updateTable();
                } else {
                    showErrorTable(data.message || 'Gagal memuat data equipment types');
                }
            })
            .catch(error => {
                console.error('Error loading equipment types:', error);
                showErrorTable('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
            });
    }

    function showErrorTable(message) {
        const tbody = document.getElementById('equipmentTypesBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger">
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

    function updateTable() {
        const tbody = document.getElementById('equipmentTypesBody');
        const countElement = document.getElementById('equipmentCount');

        // Handle empty data
        if (!equipmentTypesData || equipmentTypesData.length === 0) {
            countElement.textContent = '(0 items)';
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <div class="py-5">
                            <i class="fas fa-inbox fa-4x mb-3 text-muted"></i><br>
                            <h5 class="text-muted">Belum ada data equipment types</h5>
                            <p class="text-muted mb-3">Mulai dengan menambahkan jenis equipment pertama Anda</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#equipmentTypeModal" onclick="addEquipmentType()">
                                <i class="fas fa-plus me-2"></i>Tambah Equipment Type
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        // Update counter
        countElement.textContent = `(${equipmentTypesData.length} items)`;

        // Generate table rows with improved styling
        tbody.innerHTML = equipmentTypesData.map((equipment, index) => {
            // Generate consistent color for equipment type
            const randomColor = equipment.equipment_type.split('').reduce((a, b) => {
                a = ((a << 5) - a) + b.charCodeAt(0);
                return a & a;
            }, 0);
            const bgColor = Math.abs(randomColor).toString(16).substring(0, 6).padStart(6, '0');

            return `
                <tr class="equipment-row" data-equipment-id="${equipment.id}" style="animation: fadeIn 0.3s ease-in-out ${index * 0.1}s both;">
                    <td>
                        <div class="d-flex align-items-center justify-content-center equipment-icon"
                            style="width: 45px; height: 45px; background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 10px; box-shadow: 0 2px 4px rgba(0,123,255,0.3);">
                            ${equipment.icon_url ?
                    `<img src="<?= base_url('assets/emergency_tools/img/equipment/') ?>${equipment.icon_url}" 
                                     alt="${escapeHtml(equipment.equipment_name)}"
                                     style="width: 28px; height: 28px; object-fit: contain;">` :
                    '<i class="fas fa-tools text-white fs-6"></i>'
                }
                        </div>
                    </td>
                    <td>
                        <div class="equipment-info">
                            <span class="fw-bold text-dark">${escapeHtml(equipment.equipment_name)}</span><br>
                            <small class="text-muted">${escapeHtml(equipment.equipment_type)}</small>
                        </div>
                    </td>
                    <td>
                        <span class="badge equipment-type-badge" style="background: #${bgColor}; color: white; font-weight: 500;">
                            ${escapeHtml(equipment.equipment_type)}
                        </span>
                    </td>
                    <td class="description-cell">
                        ${equipment.desc ?
                    (equipment.desc.length > 50 ?
                        `<span title="${escapeHtml(equipment.desc)}">${escapeHtml(equipment.desc.substring(0, 50))}...</span>` :
                        escapeHtml(equipment.desc)) :
                    '<span class="text-muted">-</span>'
                }
                    </td>
                    <td>
                        ${equipment.is_active == 1 ?
                    '<span class="badge bg-success">Active</span>' :
                    '<span class="badge bg-secondary">Inactive</span>'
                }
                    </td>
                    <td>
                        <div class="btn-group action-buttons" role="group">
                            <button class="btn btn-sm btn-outline-primary" 
                                onclick="editEquipmentType(${equipment.id})" 
                                title="Edit ${escapeHtml(equipment.equipment_name)}"
                                data-bs-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteEquipmentType(${equipment.id})" 
                                title="Hapus ${escapeHtml(equipment.equipment_name)}"
                                data-bs-toggle="tooltip">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        // Initialize tooltips for action buttons
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Utility function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Search function
    function searchEquipmentTypes() {
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

        // Update counter with filtered results
        if (searchTerm !== '') {
            countElement.textContent = `(${visibleCount} dari ${equipmentTypesData.length} items)`;
            countElement.classList.add('text-primary');
        } else {
            countElement.textContent = `(${equipmentTypesData.length} items)`;
            countElement.classList.remove('text-primary');
        }

        // Show no results message if needed
        const tbody = document.getElementById('equipmentTypesBody');
        const noResultsRow = document.getElementById('noResultsRow');

        if (visibleCount === 0 && equipmentTypesData.length > 0 && searchTerm !== '') {
            if (!noResultsRow) {
                const noResultsHtml = `
                    <tr id="noResultsRow">
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-3x mb-3"></i><br>
                            <h5>Tidak ada hasil yang ditemukan untuk "${searchTerm}"</h5>
                            <p>Coba kata kunci yang berbeda atau <button class="btn btn-link p-0" onclick="clearSearch()">hapus pencarian</button></p>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', noResultsHtml);
            }
        } else if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    // Clear search function
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        searchEquipmentTypes();
    }

    // Refresh data with visual feedback
    function refreshData() {
        const refreshBtn = document.querySelector('[onclick="loadEquipmentTypes()"]');
        const refreshIcon = refreshBtn.querySelector('i');

        // Add spinning animation
        refreshIcon.classList.add('fa-spin');
        refreshBtn.disabled = true;

        // Clear search when refreshing
        clearSearch();

        loadEquipmentTypes();

        // Remove spinning after a delay
        setTimeout(() => {
            refreshIcon.classList.remove('fa-spin');
            refreshBtn.disabled = false;
        }, 1000);
    }

    // Form submission
    document.getElementById('equipmentTypeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const action = isEdit ? 'update' : 'create';

        // Show loading
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        submitBtn.disabled = true;

        fetch(`<?= base_url('emergency_tools/master_equipment/api/') ?>${action}`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                if (data.success) {
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('equipmentTypeModal')).hide();

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload table with animation delay
                    setTimeout(() => {
                        loadEquipmentTypes();
                    }, 500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            });
    });
</script>