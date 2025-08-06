<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Report & Approval</h2>
                    <p class="text-muted mb-0">Kelola laporan pengecekan dan approval</p>
                </div>
                <div>
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
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i>
                        Data Pengecekan
                    </h5>
                    <div>
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
                            <tbody>
                                <?php if (!empty($inspections)): ?>
                                    <?php foreach ($inspections as $inspection): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input inspection-checkbox"
                                                    value="<?php echo $inspection->id; ?>">
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    <?php echo date('d M Y, H:i', strtotime($inspection->inspection_date)); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div>
                                                    <span
                                                        class="fw-bold"><?php echo $inspection->equipment_code ?? 'N/A'; ?></span><br>
                                                    <small class="text-muted">Equipment ID:
                                                        <?php echo $inspection->equipment_id; ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar bg-info me-2"
                                                        style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                        <?php echo strtoupper(substr($inspection->inspector_name ?? 'U', 0, 1)); ?>
                                                    </div>
                                                    <?php echo $inspection->inspector_name ?? 'Unknown'; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $inspection->approval_status ?? 'pending';
                                                $badge_class = '';
                                                switch ($status) {
                                                    case 'approved':
                                                        $badge_class = 'bg-success';
                                                        break;
                                                    case 'rejected':
                                                        $badge_class = 'bg-danger';
                                                        break;
                                                    default:
                                                        $badge_class = 'bg-warning';
                                                }
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst($status); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="viewDetail(<?php echo $inspection->id; ?>)"
                                                        title="View Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if ($status === 'pending'): ?>
                                                        <button class="btn btn-sm btn-outline-success"
                                                            onclick="approveInspection(<?php echo $inspection->id; ?>)"
                                                            title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="rejectInspection(<?php echo $inspection->id; ?>)"
                                                            title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-info-circle me-2 text-muted"></i>
                                            Belum ada data pengecekan
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

<script>
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