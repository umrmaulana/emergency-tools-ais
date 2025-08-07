<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Dashboard Emergency Tools</h2>
                    <p class="text-muted mb-0">Selamat datang, <?php echo $user['name'] ?? 'User'; ?>!</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="refreshDashboard()" title="Refresh Data"
                        data-bs-toggle="tooltip">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            <?php echo date('d F Y, H:i'); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="stat-number"><?php echo number_format($total_equipment ?? 0); ?></div>
                <div class="stat-label">
                    <i class="fas fa-tools me-2"></i>
                    Total Equipment
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="stat-number"><?php echo number_format($equipment_checked_today ?? 0); ?></div>
                <div class="stat-label">
                    <i class="fas fa-check-circle me-2"></i>
                    Dicek Hari Ini
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="stat-number"><?php echo number_format($pending_approvals ?? 0); ?></div>
                <div class="stat-label">
                    <i class="fas fa-clock me-2"></i>
                    Pending Approval
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <div class="stat-number">
                    <?php echo number_format((($total_equipment ?? 0) > 0) ? (($equipment_checked_today ?? 0) / ($total_equipment ?? 1)) * 100 : 0, 1); ?>%
                </div>
                <div class="stat-label">
                    <i class="fas fa-chart-pie me-2"></i>
                    Progress Hari Ini
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart Pengecekan -->
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Grafik Pengecekan (7 Hari Terakhir)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="inspectionChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo site_url('emergency-tools/report'); ?>" class="btn btn-primary">
                            <i class="fas fa-chart-bar me-2"></i>
                            Lihat Report
                        </a>
                        <a href="<?php echo site_url('emergency-tools/equipment'); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-tools me-2"></i>
                            Kelola Equipment
                        </a>
                        <a href="<?php echo site_url('emergency-tools/master-location'); ?>"
                            class="btn btn-outline-secondary">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Master Location
                        </a>
                        <a href="<?php echo site_url('emergency-tools/master-checksheet'); ?>"
                            class="btn btn-outline-info">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Master Checksheet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>
                            Aktivitas Terbaru
                            <small class="text-muted" id="activityCount">(Loading...)</small>
                        </h5>
                    </div>
                    <a href="<?php echo site_url('emergency_tools/report'); ?>" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Equipment</th>
                                    <th>Inspector</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="activityTableBody">
                                <!-- Data akan dimuat secara dinamis -->
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <div class="d-flex justify-content-center align-items-center py-4">
                                            <div class="spinner-border text-primary me-3" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span>Memuat aktivitas terbaru...</span>
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

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
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

    .activity-row {
        transition: all 0.3s ease;
    }

    .activity-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .activity-row:hover .user-avatar {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        background-color: rgba(0, 123, 255, 0.05);
        padding: 1rem 0.75rem;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .stat-number {
            font-size: 2rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>

<script>
    let dashboardData = {};

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        loadDashboardData();
        initializeChart();
    });

    // Load dashboard data
    function loadDashboardData() {
        loadRecentActivity();
    }

    // Load recent activity
    function loadRecentActivity() {
        const tbody = document.getElementById('activityTableBody');
        const countElement = document.getElementById('activityCount');

        // Show loading
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-muted">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat aktivitas terbaru...</span>
                    </div>
                </td>
            </tr>
        `;

        // Simulate API call - replace with actual endpoint
        fetch('<?= base_url("emergency_tools/dashboard/api/recent_activity") ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateActivityTable(data.data);
                    countElement.textContent = `(${data.data.length} items)`;
                } else {
                    showEmptyActivity();
                    countElement.textContent = '(0 items)';
                }
            })
            .catch(error => {
                console.error('Error loading activity:', error);
                showEmptyActivity();
                countElement.textContent = '(Error)';
            });
    }

    // Update activity table
    function updateActivityTable(activities) {
        const tbody = document.getElementById('activityTableBody');

        if (!activities || activities.length === 0) {
            showEmptyActivity();
            return;
        }

        tbody.innerHTML = activities.map((activity, index) => {
            const status = activity.approval_status || 'pending';
            let badgeClass = '';
            switch (status) {
                case 'approved': badgeClass = 'bg-success'; break;
                case 'rejected': badgeClass = 'bg-danger'; break;
                default: badgeClass = 'bg-warning';
            }

            return `
                <tr class="activity-row" style="animation: fadeIn 0.3s ease-in-out ${index * 0.1}s both;">
                    <td>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            ${new Date(activity.inspection_date).toLocaleDateString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            })}
                        </small>
                    </td>
                    <td>
                        <span class="fw-bold">${escapeHtml(activity.equipment_code || 'N/A')}</span><br>
                        <small class="text-muted">${escapeHtml(activity.equipment_name || 'Unknown Equipment')}</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar bg-primary me-2"
                                style="width: 25px; height: 25px; font-size: 0.8rem;">
                                ${(activity.inspector_name || 'U').charAt(0).toUpperCase()}
                            </div>
                            ${escapeHtml(activity.inspector_name || 'Unknown')}
                        </div>
                    </td>
                    <td>
                        <span class="badge ${badgeClass}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="viewActivity(${activity.id})" title="View Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Show empty activity
    function showEmptyActivity() {
        const tbody = document.getElementById('activityTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Data akan muncul setelah ada aktivitas pengecekan
                </td>
            </tr>
        `;
    }

    // Refresh dashboard
    function refreshDashboard() {
        const refreshBtn = document.querySelector('[onclick="refreshDashboard()"]');
        const refreshIcon = refreshBtn.querySelector('i');

        refreshIcon.classList.add('fa-spin');
        refreshBtn.disabled = true;

        loadDashboardData();

        setTimeout(() => {
            refreshIcon.classList.remove('fa-spin');
            refreshBtn.disabled = false;
        }, 1000);
    }

    // View activity detail
    function viewActivity(id) {
        window.location.href = `<?= base_url("emergency_tools/report/detail/") ?>${id}`;
    }

    // Utility function
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initialize chart
    function initializeChart() {
        // Chart configuration (existing code remains the same)
        const ctx = document.getElementById('inspectionChart').getContext('2d');
        const chartData = <?php echo json_encode($chart_data ?? []); ?>;

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item.date),
                datasets: [{
                    label: 'Jumlah Pengecekan',
                    data: chartData.map(item => item.count),
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                }
            }
        });
    }
</script>