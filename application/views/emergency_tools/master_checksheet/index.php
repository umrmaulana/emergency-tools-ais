<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Master Checksheet Templates</h2>
                    <p class="text-muted mb-0">Kelola template checksheet untuk setiap jenis equipment</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checksheetModal"
                        onclick="addChecksheet()">
                        <i class="fas fa-plus me-2"></i>Tambah Template
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Equipment Type Selector -->
        <div class="col-xl-3 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filter by Equipment Type
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush" id="equipmentTypeList">
                        <button type="button" class="list-group-item list-group-item-action active"
                            onclick="filterByType('all')">
                            <i class="fas fa-list me-2"></i>Semua Template
                            <span class="badge bg-primary rounded-pill float-end">12</span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" onclick="filterByType(1)">
                            <i class="fas fa-fire-extinguisher me-2 text-danger"></i>Fire Extinguisher
                            <span class="badge bg-secondary rounded-pill float-end">5</span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" onclick="filterByType(2)">
                            <i class="fas fa-lightbulb me-2 text-warning"></i>Emergency Light
                            <span class="badge bg-secondary rounded-pill float-end">4</span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" onclick="filterByType(3)">
                            <i class="fas fa-plus-circle me-2 text-success"></i>First Aid Kit
                            <span class="badge bg-secondary rounded-pill float-end">3</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checksheet Templates -->
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>
                        Template Checksheet
                    </h5>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="reorderItems()">
                            <i class="fas fa-sort me-1"></i>Reorder
                        </button>
                        <button class="btn btn-success btn-sm" onclick="previewChecksheet()">
                            <i class="fas fa-eye me-1"></i>Preview
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="checksheetContainer">
                        <!-- Fire Extinguisher Template -->
                        <div class="equipment-group mb-4" data-type="1">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary mb-0">
                                    <i class="fas fa-fire-extinguisher me-2"></i>
                                    Fire Extinguisher (APAR)
                                </h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addItemToGroup(1)">
                                    <i class="fas fa-plus me-1"></i>Add Item
                                </button>
                            </div>

                            <div class="list-group" id="group-1">
                                <div class="list-group-item" data-order="1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-primary me-2">1</span>
                                                <strong>Kondisi Tabung</strong>
                                                <span class="ms-auto">
                                                    <button class="btn btn-sm btn-outline-secondary me-1"
                                                        onclick="editChecksheetItem(1)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteChecksheetItem(1)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">Tidak berkarat, tidak penyok, tidak bocor</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item" data-order="2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-primary me-2">2</span>
                                                <strong>Pressure Gauge</strong>
                                                <span class="ms-auto">
                                                    <button class="btn btn-sm btn-outline-secondary me-1"
                                                        onclick="editChecksheetItem(2)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteChecksheetItem(2)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">Jarum menunjuk area hijau (normal)</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item" data-order="3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-primary me-2">3</span>
                                                <strong>Safety Pin</strong>
                                                <span class="ms-auto">
                                                    <button class="btn btn-sm btn-outline-secondary me-1"
                                                        onclick="editChecksheetItem(3)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteChecksheetItem(3)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">Terpasang dengan baik dan tidak rusak</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Light Template -->
                        <div class="equipment-group mb-4" data-type="2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-warning mb-0">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    Emergency Light
                                </h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addItemToGroup(2)">
                                    <i class="fas fa-plus me-1"></i>Add Item
                                </button>
                            </div>

                            <div class="list-group" id="group-2">
                                <div class="list-group-item" data-order="1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-warning me-2">1</span>
                                                <strong>Kondisi Lampu</strong>
                                                <span class="ms-auto">
                                                    <button class="btn btn-sm btn-outline-secondary me-1"
                                                        onclick="editChecksheetItem(4)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteChecksheetItem(4)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">Tidak retak, tidak pecah</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item" data-order="2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-warning me-2">2</span>
                                                <strong>Brightness Test</strong>
                                                <span class="ms-auto">
                                                    <button class="btn btn-sm btn-outline-secondary me-1"
                                                        onclick="editChecksheetItem(5)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteChecksheetItem(5)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">Menyala terang saat test button ditekan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checksheet Item Modal -->
<div class="modal fade" id="checksheetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Item Checksheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="checksheetForm">
                <div class="modal-body">
                    <input type="hidden" id="checksheetId" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Equipment Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="equipmentTypeId" name="equipment_type_id" required>
                                    <option value="">Pilih Jenis Equipment</option>
                                    <option value="1">Fire Extinguisher</option>
                                    <option value="2">Emergency Light</option>
                                    <option value="3">First Aid Kit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Order Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="orderNumber" name="order_number" min="1"
                                    required>
                                <div class="form-text">Urutan item dalam checksheet</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="itemName" name="item_name" required>
                        <div class="form-text">Nama item yang akan dicek (contoh: Kondisi Tabung)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Standard Condition <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="standardCondition" name="standar_condition" rows="3"
                            required></textarea>
                        <div class="form-text">Kondisi standar yang harus dipenuhi</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Standard Picture URL</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="standardPictureUrl" name="standar_picture_url"
                                placeholder="URL gambar referensi">
                            <button class="btn btn-outline-secondary" type="button" onclick="uploadStandardPicture()">
                                <i class="fas fa-upload me-1"></i>Upload
                            </button>
                        </div>
                        <div class="form-text">URL gambar referensi kondisi standar (opsional)</div>
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

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Checksheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="exportChecksheet()">
                    <i class="fas fa-download me-1"></i>Export PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let isEdit = false;
    let currentEquipmentType = 'all';

    function filterByType(typeId) {
        currentEquipmentType = typeId;

        // Update active button
        document.querySelectorAll('#equipmentTypeList button').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // Filter equipment groups
        document.querySelectorAll('.equipment-group').forEach(group => {
            if (typeId === 'all' || group.dataset.type == typeId) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });
    }

    function addChecksheet() {
        isEdit = false;
        document.getElementById('modalTitle').textContent = 'Tambah Item Checksheet';
        document.getElementById('checksheetForm').reset();
        document.getElementById('checksheetId').value = '';

        // Pre-select equipment type if filtered
        if (currentEquipmentType !== 'all') {
            document.getElementById('equipmentTypeId').value = currentEquipmentType;
        }
    }

    function editChecksheetItem(id) {
        isEdit = true;
        document.getElementById('modalTitle').textContent = 'Edit Item Checksheet';
        document.getElementById('checksheetId').value = id;

        // Sample data - replace with AJAX call
        const sampleData = {
            1: { type_id: 1, order: 1, name: 'Kondisi Tabung', condition: 'Tidak berkarat, tidak penyok, tidak bocor' },
            2: { type_id: 1, order: 2, name: 'Pressure Gauge', condition: 'Jarum menunjuk area hijau (normal)' },
            3: { type_id: 1, order: 3, name: 'Safety Pin', condition: 'Terpasang dengan baik dan tidak rusak' }
        };

        const data = sampleData[id];
        if (data) {
            document.getElementById('equipmentTypeId').value = data.type_id;
            document.getElementById('orderNumber').value = data.order;
            document.getElementById('itemName').value = data.name;
            document.getElementById('standardCondition').value = data.condition;
        }

        // Show modal
        new bootstrap.Modal(document.getElementById('checksheetModal')).show();
    }

    function deleteChecksheetItem(id) {
        if (confirm('Apakah Anda yakin ingin menghapus item checksheet ini?')) {
            alert('Delete checksheet item ID: ' + id);
            // AJAX call to delete
        }
    }

    function addItemToGroup(equipmentTypeId) {
        document.getElementById('equipmentTypeId').value = equipmentTypeId;
        addChecksheet();
        new bootstrap.Modal(document.getElementById('checksheetModal')).show();
    }

    function reorderItems() {
        alert('Reorder functionality - implement drag & drop or number input');
    }

    function previewChecksheet() {
        // Generate preview content
        const previewContent = `
        <div class="row">
            <div class="col-md-6">
                <h6>Fire Extinguisher Checksheet</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Standard Condition</th>
                                <th>Condition</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Kondisi Tabung</td>
                                <td>Tidak berkarat, tidak penyok, tidak bocor</td>
                                <td>_____________</td>
                                <td>□ OK □ NOT OK</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Pressure Gauge</td>
                                <td>Jarum menunjuk area hijau (normal)</td>
                                <td>_____________</td>
                                <td>□ OK □ NOT OK</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Safety Pin</td>
                                <td>Terpasang dengan baik dan tidak rusak</td>
                                <td>_____________</td>
                                <td>□ OK □ NOT OK</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

        document.getElementById('previewContent').innerHTML = previewContent;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    function exportChecksheet() {
        alert('Export checksheet to PDF functionality');
    }

    function uploadStandardPicture() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function (e) {
            const file = e.target.files[0];
            if (file) {
                // Upload file and get URL
                // For demo, just show filename
                document.getElementById('standardPictureUrl').value = 'uploaded/' + file.name;
            }
        };
        input.click();
    }

    // Form submission
    document.getElementById('checksheetForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const action = isEdit ? 'update' : 'create';

        // AJAX submission
        console.log('Submit checksheet form:', action, Object.fromEntries(formData));

        // Close modal
        document.querySelector('[data-bs-dismiss="modal"]').click();

        alert('Checksheet item ' + (isEdit ? 'updated' : 'created') + ' successfully!');
    });
</script>