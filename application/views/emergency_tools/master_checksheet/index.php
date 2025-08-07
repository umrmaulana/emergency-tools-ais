<!-- Page Header with consistent styling -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

            <style>
                /* Animation and transition styles for consistency */
                .fade-in {
                    animation: fadeIn 0.5s ease-in-out;
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .card {
                    transition: all 0.3s ease;
                }

                .card:hover {
                    <span class="badge bg-secondary">$ {
                        template.order_number
                    }

                    </span>box-shadow: 0 4px 15px rgba(0, 0, 0, 0 <span class="badge bg-secondary" >$ {
                            template.order_number
                        }

                        </span>1);
                }

                .btn {
                    transition: all 0.3s ease;
                }

                .equipment-type-card {
                    cursor: pointer;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .equipment-type-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                }

                .table tbody tr {
                    transition: all 0.3s ease;
                }

                .table tbody tr:hover {
                    background-color: rgba(0, 123, 255, 0.05);
                }

                .template-row {
                    transition: all 0.3s ease;
                }

                .template-row:hover {
                    background-color: rgba(0, 123, 255, 0.05);
                    transform: translateX(5px);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .equipment-icon {
                    transition: all 0.3s ease;
                }

                .template-row:hover .equipment-icon {
                    transform: scale(1.1);
                    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4) !important;
                }

                .template-info .fw-bold {
                    transition: color 0.3s ease;
                }

                .template-row:hover .template-info .fw-bold {
                    color: #007bff !important;
                }

                .order-badge {
                    transition: all 0.3s ease;
                    border-radius: 12px;
                    padding: 0.375rem 0.75rem;
                }

                .template-row:hover .order-badge {
                    transform: scale(1.05);
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .condition-cell {
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

                    .template-info .fw-bold {
                        font-size: 0.9rem;
                    }

                    .action-buttons .btn {
                        padding: 0.25rem 0.5rem;
                    }

                    .condition-cell {
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

                /* Grouped table styles */
                .equipment-type-group-header {
                    position: sticky;
                    z-index: 10;
                }

                .equipment-type-group-header:hover {
                    background-color: rgba(0, 123, 255, 0.15) !important;
                }

                .group-item-row {
                    border-left: 4px solid #007bff;
                    background-color: #fafbfc;
                }

                .transition-icon {
                    transition: transform 0.3s ease;
                }

                .equipment-type-group-header:hover .transition-icon {
                    transform: scale(1.1);
                }

                /* Group expansion animation */
                @keyframes slideDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .template-row {
                    animation: slideDown 0.3s ease-out;
                }
            </style>

            <section class="content">
                <div class="container-fluid">

                    <!-- Page Header with consistent styling -->
                    <div class="container-fluid mb-4">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div
                                    class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                                    <div>
                                        <h2 class="mb-1 fw-bold text-primary">
                                            <i class="fas fa-clipboard-check me-2"></i><?= $title ?>
                                        </h2>
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0">
                                                <li class="breadcrumb-item">
                                                    <a href="<?= base_url('emergency_tools/dashboard') ?>"
                                                        class="text-decoration-none">
                                                        <i class="fas fa-home me-1"></i>Dashboard
                                                    </a>
                                                </li>
                                                <li class="breadcrumb-item active"><?= $title ?></li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary" onclick="refreshData()"
                                            title="Refresh Data" data-bs-toggle="tooltip">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary" id="btn-add-template">
                                            <i class="fas fa-plus me-2"></i>Add Template
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Equipment Types Overview -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-tools me-2 text-primary"></i>
                                            Equipment Types with Templates
                                            <small class="text-muted" id="equipmentTypesCount">(0 items)</small>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="equipment-overview">
                                        <div class="col-12 text-center py-4" id="equipmentTypesLoading">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="spinner-border spinner-border-sm text-primary mb-2"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <span class="text-muted">Loading equipment types...</span>
                                            </div>
                                        </div>
                                        <?php if (!empty($equipment_types)): ?>
                                            <?php foreach ($equipment_types as $type): ?>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card bg-light equipment-type-card"
                                                        data-equipment-type-id="<?= $type->id ?>">
                                                        <div class="card-body text-center">
                                                            <?php if (!empty($type->icon)): ?>
                                                                <img src="<?= base_url('assets/emergency_tools/img/equipment/' . $type->icon) ?>"
                                                                    alt="<?= htmlspecialchars($type->name) ?>" class="mb-2"
                                                                    style="width: 50px; height: 50px; object-fit: contain;">
                                                            <?php else: ?>
                                                                <i class="fas fa-tools fa-3x mb-2"></i>
                                                            <?php endif; ?>
                                                            <h5><?= htmlspecialchars($type->name) ?></h5>
                                                            <p class="text-muted mb-1">
                                                                <?= htmlspecialchars($type->description) ?>
                                                            </p>
                                                            <span class="badge bg-primary"><?= $type->template_count ?>
                                                                Templates</span>
                                                            <div class="mt-2">
                                                                <button class="btn btn-sm btn-outline-primary view-templates"
                                                                    data-equipment-type-id="<?= $type->id ?>"
                                                                    data-equipment-type-name="<?= htmlspecialchars($type->name) ?>">
                                                                    View Templates
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <i class="fas fa-info-circle"></i>
                                                    No equipment types found. Please add equipment types first.
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Templates Detail -->
                    <div class="row" id="templates-section" style="display: none;">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" id="templates-title">Templates</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-secondary btn-sm" id="btn-back-overview">
                                            <i class="fas fa-arrow-left"></i> Back to Overview
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            id="btn-add-template-specific">
                                            <i class="fas fa-plus"></i> Add Template
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="templates-list" class="sortable-list">
                                        <!-- Templates will be loaded dynamically -->
                                    </div>
                                    <div id="no-templates" class="text-center py-4" style="display: none;">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No templates found</h5>
                                        <p class="text-muted">Click "Add Template" to create your first template for
                                            this equipment type.
                                        </p>
                                    </div>
                                    <h5 class="text-muted">No templates found</h5>
                                    <p class="text-muted">Click "Add Template" to create your first template for this
                                        equipment
                                        type.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Templates Overview (Grouped) -->
                <div class="row" id="all-templates-section">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                            All Templates Overview
                                            <small class="text-muted" id="templatesCount">(0 items)</small>
                                        </h5>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Cari template..." onkeyup="searchTemplates()">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="expandAllGroups()"
                                                title="Expand All Groups" data-bs-toggle="tooltip">
                                                <i class="fas fa-expand-alt"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                onclick="collapseAllGroups()" title="Collapse All Groups"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-compress-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="templatesTable">
                                        <thead>
                                            <tr>
                                                <th>Icon</th>
                                                <th>Equipment Type</th>
                                                <th>Order</th>
                                                <th>Item Name</th>
                                                <th>Standard Condition</th>
                                                <th>Picture</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="all-templates-tbody">
                                            <!-- Data akan dimuat secara dinamis -->
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    <div class="d-flex justify-content-center align-items-center py-4">
                                                        <div class="spinner-border text-primary me-3" role="status"
                                                            id="loadingSpinner">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <span>Memuat data templates...</span>
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
        </section>

        <!-- Template Modal -->
        <div class="modal fade" id="templateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="templateForm" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="templateModalTitle">Add Template</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="template_id" name="id">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="equipment_type_id" class="form-label">Equipment Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="equipment_type_id" name="equipment_type_id"
                                            required>
                                            <option value="">Select Equipment Type</option>
                                            <?php if (!empty($equipment_types_dropdown)): ?>
                                                <?php foreach ($equipment_types_dropdown as $type): ?>
                                                    <option value="<?= $type->id ?>">
                                                        <?= htmlspecialchars($type->name) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <div class="form-text">Pilih jenis equipment untuk template ini</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_number" class="form-label">Order Number</label>
                                        <input type="number" class="form-control" id="order_number" name="order_number"
                                            min="1" placeholder="Auto-generated if empty">
                                        <div class="form-text">Kosongkan untuk generate otomatis</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="item_name" class="form-label">Item Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="item_name" name="item_name" required
                                    maxlength="255" placeholder="Contoh: Pin & Segel, Tekanan Angin, dll">
                                <div class="form-text">Nama item yang akan dicek pada template checksheet</div>
                            </div>

                            <div class="mb-3">
                                <label for="standar_condition" class="form-label">Standard Condition <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="standar_condition" name="standar_condition" rows="3"
                                    required
                                    placeholder="Jelaskan kondisi standar yang harus dipenuhi untuk item ini"></textarea>
                                <div class="form-text">Deskripsi kondisi standar yang diharapkan</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="standard_picture" class="form-label">Standard Picture</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="standard_picture"
                                                name="standard_picture" accept="image/*"
                                                onchange="previewStandardPicture()">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="document.getElementById('standard_picture').click()">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Upload gambar standar (JPG, PNG, GIF, WebP - Max 2MB)
                                        </div>

                                        <!-- Picture Preview -->
                                        <div id="picturePreviewContainer" class="mt-2" style="display: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <img id="picturePreviewImg" src="" alt="Preview"
                                                        style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px;">
                                                </div>
                                                <div>
                                                    <small class="text-muted">Preview gambar standar</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Current picture preview -->
                                        <div id="current_picture_preview" style="margin-top: 10px; display: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <img id="current_picture_img" src="" alt="Current"
                                                        style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px;">
                                                </div>
                                                <div>
                                                    <small class="text-muted">Gambar saat ini</small>
                                                </div>
                                            </div>
                                            <input type="hidden" id="standar_picture_url" name="standar_picture_url">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <!-- Empty space for future features or alignment -->
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan:</strong> Template checksheet yang dibuat akan digunakan untuk inspeksi
                                equipment.
                                Upload gambar standar dalam format JPG atau PNG untuk referensi kondisi yang diharapkan.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="btn-text">Save Template</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Standard Picture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Standard Picture" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End content-wrapper -->

<script>
    // Base URL for API calls
    const baseUrl = '<?= base_url() ?>';
    let templatesData = [];
    let templatesGroupedData = {};
    let expandedGroups = new Set(); // Track which groups are expanded

    document.addEventListener('DOMContentLoaded', function () {
        // Hide loading state and show equipment types  
        const loadingElement = document.getElementById('equipmentTypesLoading');
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }

        // Update equipment types count
        const equipmentCards = document.querySelectorAll('.equipment-type-card');
        const countElement = document.getElementById('equipmentTypesCount');
        if (countElement) {
            countElement.textContent = `(${equipmentCards.length} items)`;
        }

        // Load templates data dynamically
        loadAllTemplates();

        // Add expand all / collapse all functionality
        window.expandAllGroups = function () {
            document.querySelectorAll('.equipment-type-group-header').forEach(header => {
                const groupId = header.getAttribute('data-group-id');
                if (!expandedGroups.has(groupId)) {
                    toggleGroup(groupId);
                }
            });
        };

        window.collapseAllGroups = function () {
            document.querySelectorAll('.equipment-type-group-header').forEach(header => {
                const groupId = header.getAttribute('data-group-id');
                if (expandedGroups.has(groupId)) {
                    toggleGroup(groupId);
                }
            });
        };

        // Refresh data function
        window.refreshData = function () {
            console.log('Refreshing checksheet data...');
            const refreshBtn = document.querySelector('[onclick="refreshData()"]');
            const refreshIcon = refreshBtn.querySelector('i');

            // Add spinning animation
            refreshIcon.classList.add('fa-spin');
            refreshBtn.disabled = true;

            // Clear search when refreshing
            clearSearch();

            loadAllTemplates();

            // Remove spinning after a delay
            setTimeout(() => {
                refreshIcon.classList.remove('fa-spin');
                refreshBtn.disabled = false;
            }, 1000);
        };
    });

    // Load all templates function
    function loadAllTemplates() {
        // Show loading state
        const tbody = document.getElementById('all-templates-tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat data templates...</span>
                    </div>
                </td>
            </tr>
        `;

        fetch(baseUrl + 'emergency_tools/master_checksheet/api/get_grouped')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Store both grouped and flattened data
                    templatesData = [];
                    templatesGroupedData = data.data;

                    // Flatten for search functionality
                    Object.values(data.data).forEach(group => {
                        if (group.templates && group.templates.length > 0) {
                            templatesData.push(...group.templates);
                        }
                    });
                    updateTemplatesTable();
                } else {
                    showErrorTable(data.message || 'Gagal memuat data templates');
                }
            })
            .catch(error => {
                console.error('Error loading templates:', error);
                showErrorTable('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
            });
    }

    function showErrorTable(message) {
        const tbody = document.getElementById('all-templates-tbody');
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

    function updateTemplatesTable() {
        const tbody = document.getElementById('all-templates-tbody');
        const countElement = document.getElementById('templatesCount');

        // Handle empty data
        if (!templatesData || templatesData.length === 0) {
            countElement.textContent = '(0 items)';
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <div class="py-5">
                            <i class="fas fa-clipboard-list fa-4x mb-3 text-muted"></i><br>
                            <h5 class="text-muted">Belum ada data templates</h5>
                            <p class="text-muted mb-3">Mulai dengan menambahkan template checksheet pertama Anda</p>
                            <button class="btn btn-primary" id="btn-add-template-empty">
                                <i class="fas fa-plus me-2"></i>Tambah Template
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        // Update counter
        countElement.textContent = `(${templatesData.length} items)`;

        // Generate grouped table rows
        let html = '';
        let groupIndex = 0;

        Object.values(templatesGroupedData).forEach(group => {
            if (!group.templates || group.templates.length === 0) return;

            const groupId = `group-${group.equipment_info.id}`;
            const isExpanded = expandedGroups.has(groupId);
            const itemCount = group.templates.length;
            const equipmentInfo = group.equipment_info;

            // Group header row
            html += `
                <tr class="equipment-type-group-header" data-group-id="${groupId}" style="background-color: rgba(0, 123, 255, 0.08); cursor: pointer; transition: all 0.3s ease;">
                    <td colspan="7" class="py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="me-3 equipment-icon"
                                    style="width: 45px; height: 45px; background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 10px; box-shadow: 0 2px 4px rgba(0,123,255,0.3); display: flex; align-items: center; justify-content: center;">
                                    ${equipmentInfo.icon_url ?
                    `<img src="${baseUrl}assets/emergency_tools/img/equipment/${equipmentInfo.icon_url}" 
                                         alt="${escapeHtml(equipmentInfo.equipment_name)}"
                                         style="width: 28px; height: 28px; object-fit: contain;">` :
                    '<i class="fas fa-tools text-white fs-6"></i>'
                }
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-primary">${escapeHtml(equipmentInfo.equipment_name)}</h6>
                                    <small class="text-muted">${escapeHtml(equipmentInfo.equipment_type)}</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-2">${itemCount}</span>
                                <i class="fas fa-chevron-${isExpanded ? 'up' : 'down'} text-primary transition-icon"></i>
                            </div>
                        </div>
                    </td>
                </tr>
            `;            // Template rows (initially hidden unless expanded)
            group.templates.forEach((template, templateIndex) => {
                const orderColor = template.order_number % 6;
                const orderBadgeClass = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'][orderColor];

                html += `
                    <tr class="template-row group-item-${groupId}" data-template-id="${template.id}" data-equipment-type-id="${template.equipment_type_id}" 
                        style="display: ${isExpanded ? 'table-row' : 'none'}; background-color: #fafbfc; border-left: 4px solid #007bff; animation: fadeIn 0.3s ease-in-out ${templateIndex * 0.1}s both;">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="me-2" style="width: 4px; height: 30px; background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 2px;"></div>
                                <span class="text-muted small">#${template.order_number}</span>
                            </div>
                        </td>
                        <td>
                            <div class="template-info ps-2">
                                <span class="text-muted small">Item</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge order-badge ${orderBadgeClass}">${template.order_number}</span>
                        </td>
                        <td>
                            <div class="template-info">
                                <span class="fw-bold text-dark">${escapeHtml(template.item_name)}</span>
                            </div>
                        </td>
                        <td class="condition-cell">
                            ${template.standar_condition ?
                        (template.standar_condition.length > 50 ?
                            `<span title="${escapeHtml(template.standar_condition)}">${escapeHtml(template.standar_condition.substring(0, 50))}...</span>` :
                            escapeHtml(template.standar_condition)) :
                        '<span class="text-muted">-</span>'
                    }
                        </td>
                        <td>
                            ${template.standar_picture_url ?
                        `<img src="${baseUrl}assets/emergency_tools/img/standards/${template.standar_picture_url}"
                                alt="Standard" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: contain; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-image="${baseUrl}assets/emergency_tools/img/standards/${template.standar_picture_url}">` :
                        '<span class="text-muted">No image</span>'
                    }
                        </td>
                        <td>
                            <div class="btn-group action-buttons" role="group">
                                <button class="btn btn-sm btn-outline-primary edit-template" 
                                    data-template-id="${template.id}" 
                                    title="Edit ${escapeHtml(template.item_name)}"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-template" 
                                    data-template-id="${template.id}" 
                                    data-template-name="${escapeHtml(template.item_name)}"
                                    title="Hapus ${escapeHtml(template.item_name)}"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            groupIndex++;
        });

        tbody.innerHTML = html;

        // Add click handlers for group headers
        document.querySelectorAll('.equipment-type-group-header').forEach(header => {
            header.addEventListener('click', function () {
                const groupId = this.getAttribute('data-group-id');
                toggleGroup(groupId);
            });
        });

        // Initialize tooltips for action buttons
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Toggle group expansion
    function toggleGroup(groupId) {
        const items = document.querySelectorAll(`.group-item-${groupId}`);
        const header = document.querySelector(`[data-group-id="${groupId}"]`);
        const icon = header.querySelector('.transition-icon');

        if (expandedGroups.has(groupId)) {
            // Collapse
            expandedGroups.delete(groupId);
            items.forEach(item => {
                item.style.display = 'none';
            });
            icon.className = 'fas fa-chevron-down text-primary transition-icon';
            header.style.backgroundColor = 'rgba(0, 123, 255, 0.08)';
        } else {
            // Expand
            expandedGroups.add(groupId);
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.display = 'table-row';
                }, index * 50); // Stagger animation
            });
            icon.className = 'fas fa-chevron-up text-primary transition-icon';
            header.style.backgroundColor = 'rgba(0, 123, 255, 0.15)';
        }
    }

    // Global variables
    let currentEquipmentTypeId = null;
    let currentEquipmentTypeName = '';

    // View templates for specific equipment type
    document.addEventListener('click', function (e) {
        if (e.target.closest('.view-templates')) {
            const button = e.target.closest('.view-templates');
            currentEquipmentTypeId = button.getAttribute('data-equipment-type-id');
            currentEquipmentTypeName = button.getAttribute('data-equipment-type-name');

            document.getElementById('templates-title').textContent = 'Templates for ' + currentEquipmentTypeName;
            document.getElementById('all-templates-section').style.display = 'none';
            document.getElementById('templates-section').style.display = 'block';

            loadTemplatesForEquipmentType(currentEquipmentTypeId);
        }
    });

    // Back to overview
    document.addEventListener('click', function (e) {
        if (e.target.closest('#btn-back-overview')) {
            document.getElementById('templates-section').style.display = 'none';
            document.getElementById('all-templates-section').style.display = 'block';
            currentEquipmentTypeId = null;
            currentEquipmentTypeName = '';
        }
    });

    // Load templates for equipment type
    function loadTemplatesForEquipmentType(equipmentTypeId) {
        fetch(baseUrl + 'emergency_tools/master_checksheet/api/get_by_type/' + equipmentTypeId)
            .then(response => response.json())
            .then(function (response) {
                if (response.success) {
                    displayTemplates(response.data);
                } else {
                    console.error('Error loading templates:', response.message);
                    document.getElementById('templates-list').innerHTML = '';
                    document.getElementById('no-templates').style.display = 'block';
                }
            })
            .catch(function (error) {
                console.error('Failed to load templates:', error);
                document.getElementById('templates-list').innerHTML = '';
                document.getElementById('no-templates').style.display = 'block';
            });
    }

    // Display templates
    function displayTemplates(templates) {
        const templatesList = document.getElementById('templates-list');
        const noTemplates = document.getElementById('no-templates');

        if (!templates || templates.length === 0) {
            templatesList.innerHTML = '';
            noTemplates.style.display = 'block';
            return;
        }

        noTemplates.style.display = 'none';
        let html = '';

        templates.forEach(function (template) {
            html += `
        <div class="card mb-2 template-item" data-template-id="${template.id}">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <span class="text-muted">${template.order_number}</span>
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-0">${escapeHtml(template.item_name)}</h6>
                    </div>
                    <div class="col-md-5">
                        <small class="text-muted">${escapeHtml(template.standar_condition)}</small>
                    </div>
                    <div class="col-md-2 text-center">
                        ${template.standar_picture_url ?
                    `<img src="${baseUrl}assets/emergency_tools/img/standards/${template.standar_picture_url}"
                            alt="Standard" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: contain;"
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-image="${baseUrl}assets/emergency_tools/img/standards/${template.standar_picture_url}">` :
                    '<span class="text-muted">No image</span>'
                }
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info edit-template" data-template-id="${template.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger delete-template" data-template-id="${template.id}"
                                data-template-name="${escapeHtml(template.item_name)}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        });

        templatesList.innerHTML = html;
    }

    // Add template buttons
    document.addEventListener('click', function (e) {
        if (e.target.closest('#btn-add-template') || e.target.closest('#btn-add-template-specific') || e.target.closest('#btn-add-template-empty')) {
            resetForm();
            document.getElementById('templateModalTitle').textContent = 'Add Template';

            if (currentEquipmentTypeId) {
                document.getElementById('equipment_type_id').value = currentEquipmentTypeId;
            }

            const modal = new bootstrap.Modal(document.getElementById('templateModal'));
            modal.show();
        }
    });

    // Edit template
    document.addEventListener('click', function (e) {
        if (e.target.closest('.edit-template')) {
            const templateId = e.target.closest('.edit-template').getAttribute('data-template-id');

            fetch(baseUrl + 'emergency_tools/master_checksheet/api/get/' + templateId)
                .then(response => response.json())
                .then(function (response) {
                    if (response.success && response.data) {
                        const template = response.data;

                        resetForm();
                        document.getElementById('templateModalTitle').textContent = 'Edit Template';

                        document.getElementById('template_id').value = template.id;
                        document.getElementById('equipment_type_id').value = template.equipment_type_id;
                        document.getElementById('order_number').value = template.order_number;
                        document.getElementById('item_name').value = template.item_name;
                        document.getElementById('standar_condition').value = template.standar_condition;

                        if (template.standar_picture_url) {
                            document.getElementById('standar_picture_url').value = template.standar_picture_url;
                            document.getElementById('current_picture_img').src = baseUrl + 'assets/emergency_tools/img/standards/' + template.standar_picture_url;
                            document.getElementById('current_picture_preview').style.display = 'block';
                        }

                        const modal = new bootstrap.Modal(document.getElementById('templateModal'));
                        modal.show();
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error!', response.message || 'Template not found', 'error');
                        } else {
                            alert('Error: ' + (response.message || 'Template not found'));
                        }
                    }
                })
                .catch(function (error) {
                    console.error('Failed to get template:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', 'Failed to load template data', 'error');
                    } else {
                        alert('Failed to load template data');
                    }
                });
        }
    });

    // Delete template
    document.addEventListener('click', function (e) {
        if (e.target.closest('.delete-template')) {
            const button = e.target.closest('.delete-template');
            const templateId = button.getAttribute('data-template-id');
            const templateName = button.getAttribute('data-template-name');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Delete template "${templateName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteTemplate(templateId);
                    }
                });
            } else {
                if (confirm(`Delete template "${templateName}"?`)) {
                    deleteTemplate(templateId);
                }
            }
        }
    });

    function deleteTemplate(templateId) {
        fetch(baseUrl + 'emergency_tools/master_checksheet/api/delete/' + templateId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(function (response) {
                if (response.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Success: ' + response.message);
                    }

                    // Reload templates table
                    setTimeout(() => {
                        loadAllTemplates();
                    }, 500);

                    // Refresh current view if in specific equipment type view
                    if (currentEquipmentTypeId) {
                        loadTemplatesForEquipmentType(currentEquipmentTypeId);
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', response.message, 'error');
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            })
            .catch(function (error) {
                console.error('Delete failed:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Failed to delete template', 'error');
                } else {
                    alert('Failed to delete template');
                }
            });
    }

    // Form submission
    document.getElementById('templateForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = this.querySelector('button[type="submit"]');
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.spinner-border');

        // Show loading
        btn.disabled = true;
        btnText.textContent = 'Saving...';
        spinner.classList.remove('d-none');

        const formData = new FormData(this);
        const templateId = document.getElementById('template_id').value;
        const isEdit = templateId && templateId !== '';

        fetch(baseUrl + 'emergency_tools/master_checksheet/api/' + (isEdit ? 'update' : 'create'), {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(function (response) {
                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('templateModal'));
                    modal.hide();

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Success: ' + response.message);
                    }

                    // Reload templates table
                    setTimeout(() => {
                        loadAllTemplates();
                    }, 500);

                    // Refresh current view if in specific equipment type view
                    if (currentEquipmentTypeId) {
                        loadTemplatesForEquipmentType(currentEquipmentTypeId);
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error!', response.message, 'error');
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            })
            .catch(function (error) {
                console.error('Save failed:', error);
                let errorMsg = 'Failed to save template';
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', errorMsg, 'error');
                } else {
                    alert('Error: ' + errorMsg);
                }
            })
            .finally(function () {
                // Hide loading
                btn.disabled = false;
                btnText.textContent = 'Save Template';
                spinner.classList.add('d-none');
            });
    });

    // Image modal
    document.addEventListener('click', function (e) {
        if (e.target.hasAttribute('data-image')) {
            const imageSrc = e.target.getAttribute('data-image');
            document.getElementById('modalImage').src = imageSrc;
        }
    });

    // Search templates
    const searchInput = document.getElementById('search-templates');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#all-templates-tbody tr');

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                if (text.indexOf(searchTerm) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Reset form function
    function resetForm() {
        document.getElementById('templateForm').reset();
        document.getElementById('template_id').value = '';
        document.getElementById('current_picture_preview').style.display = 'none';
        document.getElementById('picturePreviewContainer').style.display = 'none';
        document.getElementById('current_picture_img').src = '';
        document.getElementById('standar_picture_url').value = '';
    }

    // Utility function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Search function
    function searchTemplates() {
        const searchInput = document.getElementById('searchInput');
        const countElement = document.getElementById('templatesCount');

        if (!searchInput || !countElement) return;

        const searchTerm = searchInput.value.toLowerCase().trim();
        const groupHeaders = document.querySelectorAll('.equipment-type-group-header');
        const templateRows = document.querySelectorAll('.template-row');

        let visibleCount = 0;
        let visibleGroups = new Set();

        if (searchTerm === '') {
            // Show all groups but respect expansion state
            groupHeaders.forEach(header => {
                header.style.display = 'table-row';
                const groupId = header.getAttribute('data-group-id');
                const items = document.querySelectorAll(`.group-item-${groupId}`);

                items.forEach(item => {
                    visibleCount++;
                    if (expandedGroups.has(groupId)) {
                        item.style.display = 'table-row';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        } else {
            // Filter templates and show relevant groups
            templateRows.forEach(row => {
                if (row && row.textContent) {
                    const text = row.textContent.toLowerCase();
                    const groupId = row.className.match(/group-item-([^\s]+)/)?.[1];

                    if (text.includes(searchTerm)) {
                        row.style.display = 'table-row';
                        visibleCount++;
                        if (groupId) {
                            visibleGroups.add(groupId);
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Show/hide group headers based on visible items
            groupHeaders.forEach(header => {
                const groupId = header.getAttribute('data-group-id');
                if (visibleGroups.has(groupId)) {
                    header.style.display = 'table-row';
                    // Auto-expand groups that have matching results
                    expandedGroups.add(groupId);
                    const icon = header.querySelector('.transition-icon');
                    if (icon) {
                        icon.className = 'fas fa-chevron-up text-primary transition-icon';
                    }
                } else {
                    header.style.display = 'none';
                }
            });
        }

        // Update counter with filtered results
        if (searchTerm !== '') {
            countElement.textContent = `(${visibleCount} dari ${templatesData.length} items)`;
            countElement.classList.add('text-primary');
        } else {
            countElement.textContent = `(${templatesData.length} items)`;
            countElement.classList.remove('text-primary');
        }

        // Show no results message if needed
        const tbody = document.getElementById('all-templates-tbody');
        const noResultsRow = document.getElementById('noResultsRow');

        if (visibleCount === 0 && templatesData.length > 0 && searchTerm !== '') {
            if (!noResultsRow && tbody) {
                const noResultsHtml = `
                    <tr id="noResultsRow">
                        <td colspan="7" class="text-center text-muted py-4">
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
    }    // Clear search function
    function clearSearch() {
        const searchInput = document.getElementById('searchInput');
        const countElement = document.getElementById('templatesCount');
        const noResultsRow = document.getElementById('noResultsRow');

        if (searchInput) searchInput.value = '';

        // Show all group headers
        const groupHeaders = document.querySelectorAll('.equipment-type-group-header');
        groupHeaders.forEach(header => {
            header.style.display = 'table-row';
        });

        // Reset all template rows based on expansion state
        const templateRows = document.querySelectorAll('.template-row');
        templateRows.forEach(row => {
            const groupId = row.className.match(/group-item-([^\s]+)/)?.[1];
            if (groupId && expandedGroups.has(groupId)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        // Reset counter
        if (countElement) {
            countElement.textContent = `(${templatesData.length || 0} items)`;
            countElement.classList.remove('text-primary');
        }

        // Remove no results message
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }

    // Preview standard picture
    function previewStandardPicture() {
        const fileInput = document.getElementById('standard_picture');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.getElementById('picturePreviewImg');
                const containerElement = document.getElementById('picturePreviewContainer');
                if (imgElement) imgElement.src = e.target.result;
                if (containerElement) containerElement.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            const containerElement = document.getElementById('picturePreviewContainer');
            if (containerElement) containerElement.style.display = 'none';
        }
    }

    // Initialize search event listener
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', searchTemplates);
        }
    });

</script>