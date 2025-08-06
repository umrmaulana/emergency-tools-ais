<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Master Equipment Types</h2>
                    <p class="text-muted mb-0">Kelola jenis-jenis equipment emergency tools</p>
                </div>
                <div>
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
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cubes me-2 text-primary"></i>
                        Jenis Equipment
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover data-table">
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
                            <tbody>
                                <!-- Sample Data -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; background: #dc3545; border-radius: 8px;">
                                            <i class="fas fa-fire-extinguisher text-white"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">Fire Extinguisher</span><br>
                                            <small class="text-muted">Alat Pemadam Api Ringan</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-danger">APAR</span></td>
                                    <td>Alat Pemadam Api Ringan</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editEquipmentType(1)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteEquipmentType(1)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; background: #ffc107; border-radius: 8px;">
                                            <i class="fas fa-lightbulb text-white"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">Emergency Light</span><br>
                                            <small class="text-muted">Lampu Penerangan Darurat</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">LAMPU_DARURAT</span></td>
                                    <td>Lampu penerangan darurat</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editEquipmentType(2)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteEquipmentType(2)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; background: #28a745; border-radius: 8px;">
                                            <i class="fas fa-plus-circle text-white"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">First Aid Kit</span><br>
                                            <small class="text-muted">Kotak P3K</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">P3K</span></td>
                                    <td>Kotak Pertolongan Pertama Pada Kecelakaan</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editEquipmentType(3)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteEquipmentType(3)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
            <form id="equipmentTypeForm">
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
                                <label class="form-label">Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i id="iconPreview" class="fas fa-tools"></i>
                                    </span>
                                    <input type="text" class="form-control" id="iconUrl" name="icon_url"
                                        placeholder="fas fa-fire-extinguisher" onchange="updateIconPreview()">
                                </div>
                                <div class="form-text">Font Awesome icon class (contoh: fas fa-fire-extinguisher)</div>
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
                        checksheet.
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

<!-- Icon Selection Modal -->
<div class="modal fade" id="iconSelectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2" id="iconGrid">
                    <!-- Popular emergency icons -->
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-fire-extinguisher')">
                            <i class="fas fa-fire-extinguisher fa-2x"></i><br>
                            <small>Fire Ext.</small>
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-lightbulb')">
                            <i class="fas fa-lightbulb fa-2x"></i><br>
                            <small>Light</small>
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-plus-circle')">
                            <i class="fas fa-plus-circle fa-2x"></i><br>
                            <small>First Aid</small>
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-phone')">
                            <i class="fas fa-phone fa-2x"></i><br>
                            <small>Phone</small>
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-shower')">
                            <i class="fas fa-shower fa-2x"></i><br>
                            <small>Shower</small>
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-outline-secondary p-3 w-100"
                            onclick="selectIcon('fas fa-exclamation-triangle')">
                            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                            <small>Warning</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let isEdit = false;

    function addEquipmentType() {
        isEdit = false;
        document.getElementById('modalTitle').textContent = 'Tambah Jenis Equipment';
        document.getElementById('equipmentTypeForm').reset();
        document.getElementById('equipmentTypeId').value = '';
        updateIconPreview();
    }

    function editEquipmentType(id) {
        isEdit = true;
        document.getElementById('modalTitle').textContent = 'Edit Jenis Equipment';
        document.getElementById('equipmentTypeId').value = id;

        // Sample data - replace with AJAX call
        const sampleData = {
            1: { name: 'Fire Extinguisher', type: 'APAR', desc: 'Alat Pemadam Api Ringan', icon: 'fas fa-fire-extinguisher', active: 1 },
            2: { name: 'Emergency Light', type: 'LAMPU_DARURAT', desc: 'Lampu penerangan darurat', icon: 'fas fa-lightbulb', active: 1 },
            3: { name: 'First Aid Kit', type: 'P3K', desc: 'Kotak Pertolongan Pertama Pada Kecelakaan', icon: 'fas fa-plus-circle', active: 1 }
        };

        const data = sampleData[id];
        if (data) {
            document.getElementById('equipmentName').value = data.name;
            document.getElementById('equipmentType').value = data.type;
            document.getElementById('description').value = data.desc;
            document.getElementById('iconUrl').value = data.icon;
            document.getElementById('isActive').value = data.active;
            updateIconPreview();
        }

        // Show modal
        new bootstrap.Modal(document.getElementById('equipmentTypeModal')).show();
    }

    function deleteEquipmentType(id) {
        if (confirm('Apakah Anda yakin ingin menghapus jenis equipment ini? Data equipment yang menggunakan jenis ini mungkin akan terpengaruh.')) {
            alert('Delete equipment type ID: ' + id);
            // AJAX call to delete
        }
    }

    function updateIconPreview() {
        const iconUrl = document.getElementById('iconUrl').value || 'fas fa-tools';
        const preview = document.getElementById('iconPreview');
        preview.className = iconUrl;
    }

    function selectIcon(iconClass) {
        document.getElementById('iconUrl').value = iconClass;
        updateIconPreview();
        // Close icon selection modal
        bootstrap.Modal.getInstance(document.getElementById('iconSelectionModal')).hide();
    }

    // Add button to open icon selection
    document.getElementById('iconUrl').addEventListener('focus', function () {
        // new bootstrap.Modal(document.getElementById('iconSelectionModal')).show();
    });

    // Form submission
    document.getElementById('equipmentTypeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const action = isEdit ? 'update' : 'create';

        // AJAX submission
        console.log('Submit equipment type form:', action, Object.fromEntries(formData));

        // Close modal
        document.querySelector('[data-bs-dismiss="modal"]').click();

        alert('Equipment type ' + (isEdit ? 'updated' : 'created') + ' successfully!');
    });
</script>