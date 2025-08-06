<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Equipment Management</h2>
                    <p class="text-muted mb-0">Kelola data equipment emergency tools</p>
                </div>
                <div>
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
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools me-2 text-primary"></i>
                        Data Equipment
                    </h5>
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
                            <tbody>
                                <?php if (!empty($equipments)): ?>
                                    <?php foreach ($equipments as $equipment): ?>
                                        <tr>
                                            <td>
                                                <span
                                                    class="fw-bold text-primary"><?php echo $equipment->equipment_code; ?></span>
                                            </td>
                                            <td><?php echo $equipment->location_name ?? 'N/A'; ?></td>
                                            <td>
                                                <span class="badge bg-info">Type ID:
                                                    <?php echo $equipment->equipment_type_id; ?></span>
                                            </td>
                                            <td>
                                                <?php if ($equipment->qrcode): ?>
                                                    <code><?php echo $equipment->qrcode; ?></code>
                                                <?php else: ?>
                                                    <small class="text-muted">Belum ada</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($equipment->last_check_date): ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        <?php echo date('d M Y', strtotime($equipment->last_check_date)); ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-warning">Belum pernah dicek</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $equipment->status ?? 'active';
                                                $badge_class = '';
                                                switch ($status) {
                                                    case 'active':
                                                        $badge_class = 'bg-success';
                                                        break;
                                                    case 'inactive':
                                                        $badge_class = 'bg-secondary';
                                                        break;
                                                    case 'maintenance':
                                                        $badge_class = 'bg-warning';
                                                        break;
                                                    default:
                                                        $badge_class = 'bg-secondary';
                                                }
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst($status); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="editEquipment(<?php echo $equipment->id; ?>)" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info"
                                                        onclick="generateQR(<?php echo $equipment->id; ?>)" title="Generate QR">
                                                        <i class="fas fa-qrcode"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteEquipment(<?php echo $equipment->id; ?>)" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-info-circle me-2 text-muted"></i>
                                            Belum ada data equipment
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

<script>
    let isEdit = false;

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