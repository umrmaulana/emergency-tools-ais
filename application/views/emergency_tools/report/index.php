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

    <!-- Map Area (Placeholder) -->
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
                    <div class="text-center py-5" style="min-height: 300px; background: #f8f9fa; border-radius: 10px;">
                        <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Area Map</h5>
                        <p class="text-muted">Peta lokasi equipment akan ditampilkan di sini</p>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Load Map
                        </button>
                    </div>
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
                                    <th width="50">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th>Tanggal</th>
                                    <th>Equipment</th>
                                    <th>Inspector</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inspectionTableBody">
                                <!-- Data akan dimuat secara dinamis -->
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <div class="d-flex justify-content-center align-items-center py-4">
                                            <div class="spinner-border text-primary me-3" role="status"
                                                id="loadingSpinner">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span>Memuat data inspection...</span>
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

    .inspection-row {
        transition: all 0.3s ease;
    }

    .inspection-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        transition: all 0.3s ease;
    }

    .inspection-row:hover .user-avatar {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4) !important;
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

    .stat-card {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover::before {
        transform: scale(1.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
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

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
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
    let inspectionData = [];

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        loadInspectionData();
    });

    // Load inspection data dynamically
    function loadInspectionData() {
        // Show loading state
        const tbody = document.getElementById('inspectionTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat data inspection...</span>
                    </div>
                </td>
            </tr>
        `;

        // Simulate API call - replace with actual API endpoint
        fetch('<?= base_url("emergency_tools/report/api/get") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    inspectionData = data.data;
                    updateInspectionTable();
                } else {
                    showErrorTable(data.message || 'Gagal memuat data inspection');
                }
            })
            .catch(error => {
                console.error('Error loading inspection data:', error);
                showErrorTable('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
            });
    }

    // Update inspection table
    function updateInspectionTable() {
        const tbody = document.getElementById('inspectionTableBody');
        const countElement = document.getElementById('inspectionCount');

        if (!inspectionData || inspectionData.length === 0) {
            countElement.textContent = '(0 items)';
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <div class="py-5">
                            <i class="fas fa-inbox fa-4x mb-3 text-muted"></i><br>
                            <h5 class="text-muted">Belum ada data inspection</h5>
                            <p class="text-muted mb-3">Data inspection akan muncul setelah ada pengecekan</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        countElement.textContent = `(${inspectionData.length} items)`;

        tbody.innerHTML = inspectionData.map((inspection, index) => {
            const status = inspection.approval_status || 'pending';
            let badgeClass = '';
            switch (status) {
                case 'approved': badgeClass = 'bg-success'; break;
                case 'rejected': badgeClass = 'bg-danger'; break;
                default: badgeClass = 'bg-warning';
            }

            return `
                <tr class="inspection-row" data-inspection-id="${inspection.id}" style="animation: fadeIn 0.3s ease-in-out ${index * 0.1}s both;">
                    <td>
                        <input type="checkbox" class="form-check-input inspection-checkbox" value="${inspection.id}">
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            ${new Date(inspection.inspection_date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })}
                        </small>
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">${escapeHtml(inspection.equipment_code || 'N/A')}</span><br>
                            <small class="text-muted">Equipment ID: ${inspection.equipment_id}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar bg-info me-2 d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 30px; height: 30px; font-size: 0.8rem; color: white;">
                                ${(inspection.inspector_name || 'U').charAt(0).toUpperCase()}
                            </div>
                            ${escapeHtml(inspection.inspector_name || 'Unknown')}
                        </div>
                    </td>
                    <td>
                        <span class="badge ${badgeClass}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group action-buttons" role="group">
                            <button class="btn btn-sm btn-outline-primary"
                                onclick="viewDetail(${inspection.id})"
                                title="View Detail" data-bs-toggle="tooltip">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${status === 'pending' ? `
                                <button class="btn btn-sm btn-outline-success"
                                    onclick="approveInspection(${inspection.id})"
                                    title="Approve" data-bs-toggle="tooltip">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="rejectInspection(${inspection.id})"
                                    title="Reject" data-bs-toggle="tooltip">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : ''}
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
    function searchInspections() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.inspection-row');
        const countElement = document.getElementById('inspectionCount');

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
            countElement.textContent = `(${visibleCount} dari ${inspectionData.length} items)`;
            countElement.classList.add('text-primary');
        } else {
            countElement.textContent = `(${inspectionData.length} items)`;
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
        loadInspectionData();

        setTimeout(() => {
            refreshIcon.classList.remove('fa-spin');
            refreshBtn.disabled = false;
        }, 1000);
    }

    // Show error table
    function showErrorTable(message) {
        const tbody = document.getElementById('inspectionTableBody');
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

    // Utility function
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.inspection-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function viewDetail(inspectionId) {
        // Open detail modal or redirect to detail page
        alert('View detail for inspection ID: ' + inspectionId);
    }

    function approveInspection(inspectionId) {
        if (confirm('Apakah Anda yakin ingin approve inspection ini?')) {
            // Send AJAX request to approve
            fetch('<?php echo site_url("supervisor/report/approve/"); ?>' + inspectionId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function rejectInspection(inspectionId) {
        if (confirm('Apakah Anda yakin ingin reject inspection ini?')) {
            // Send AJAX request to reject
            fetch('<?php echo site_url("supervisor/report/reject/"); ?>' + inspectionId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function approveSelected() {
        const selected = Array.from(document.querySelectorAll('.inspection-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            alert('Pilih minimal satu inspection untuk di-approve!');
            return;
        }

        if (confirm('Approve ' + selected.length + ' inspection yang dipilih?')) {
            // Send AJAX request for bulk approve
            console.log('Bulk approve:', selected);
        }
    }

    function exportData() {
        // Export functionality
        alert('Export data functionality');
    }

    function applyFilter() {
        // Apply filter functionality
        const formData = new FormData(document.getElementById('filterForm'));
        console.log('Apply filter:', Object.fromEntries(formData));
        document.getElementById('filterModal').querySelector('[data-bs-dismiss="modal"]').click();
    }
</script>