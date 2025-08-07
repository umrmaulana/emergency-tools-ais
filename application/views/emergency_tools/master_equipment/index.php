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
                                <?php if (isset($equipment_types) && count($equipment_types) > 0): ?>
                                    <?php foreach ($equipment_types as $equipment): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; background: #007bff; border-radius: 8px;">
                                                    <?php if ($equipment->icon_url): ?>
                                                        <img src="<?= base_url('assets/emergency_tools/img/equipment/' . $equipment->icon_url) ?>"
                                                            alt="<?= htmlspecialchars($equipment->equipment_name) ?>"
                                                            style="width: 24px; height: 24px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="fas fa-tools text-white"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span
                                                        class="fw-bold"><?= htmlspecialchars($equipment->equipment_name) ?></span><br>
                                                    <small
                                                        class="text-muted"><?= htmlspecialchars($equipment->equipment_type) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge"
                                                    style="background: #<?= substr(md5($equipment->equipment_type), 0, 6) ?>">
                                                    <?= htmlspecialchars($equipment->equipment_type) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?= $equipment->desc ? htmlspecialchars(substr($equipment->desc, 0, 50)) . (strlen($equipment->desc) > 50 ? '...' : '') : '-' ?>
                                            </td>
                                            <td>
                                                <?php if ($equipment->is_active): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="editEquipmentType(<?= $equipment->id ?>)" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteEquipmentType(<?= $equipment->id ?>)" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                            Belum ada data equipment types
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
                            loadEquipmentTypes(); // Reload table
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
        fetch('<?= base_url('emergency_tools/master_equipment/api/get') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    equipmentTypesData = data.data;
                    updateTable();
                }
            })
            .catch(error => {
                console.error('Error loading equipment types:', error);
            });
    }

    function updateTable() {
        const tbody = document.getElementById('equipmentTypesBody');
        if (equipmentTypesData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i><br>
                        Belum ada data equipment types
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = equipmentTypesData.map(equipment => {
            const randomColor = equipment.equipment_type.split('').reduce((a, b) => {
                a = ((a << 5) - a) + b.charCodeAt(0);
                return a & a;
            }, 0);
            const bgColor = Math.abs(randomColor).toString(16).substring(0, 6).padStart(6, '0');

            return `
                <tr>
                    <td>
                        <div class="d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; background: #007bff; border-radius: 8px;">
                            ${equipment.icon_url ?
                    `<img src="<?= base_url('assets/emergency_tools/img/equipment/') ?>${equipment.icon_url}" 
                                     alt="${equipment.equipment_name}"
                                     style="width: 24px; height: 24px; object-fit: contain;">` :
                    '<i class="fas fa-tools text-white"></i>'
                }
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">${equipment.equipment_name}</span><br>
                            <small class="text-muted">${equipment.equipment_type}</small>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: #${bgColor}">
                            ${equipment.equipment_type}
                        </span>
                    </td>
                    <td>
                        ${equipment.desc ?
                    (equipment.desc.length > 50 ?
                        equipment.desc.substring(0, 50) + '...' :
                        equipment.desc) :
                    '-'
                }
                    </td>
                    <td>
                        ${equipment.is_active == 1 ?
                    '<span class="badge bg-success">Active</span>' :
                    '<span class="badge bg-secondary">Inactive</span>'
                }
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary"
                                onclick="editEquipmentType(${equipment.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteEquipmentType(${equipment.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
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

                    // Reload table
                    loadEquipmentTypes();
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