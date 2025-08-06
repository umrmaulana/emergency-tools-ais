<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Dashboard Emergency Tools</h2>
                    <p class="text-muted mb-0">Selamat datang, <?php echo $user['name']; ?>!</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?php echo date('d F Y, H:i'); ?>
                    </small>
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
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Aktivitas Terbaru
                    </h5>
                    <a href="<?php echo site_url('supervisor/report'); ?>" class="btn btn-sm btn-outline-primary">
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
                            <tbody>
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?php echo date('H:i, d M Y'); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">EQ-001</span><br>
                                        <small class="text-muted">Fire Extinguisher</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar bg-success me-2"
                                                style="width: 25px; height: 25px; font-size: 0.8rem;">J</div>
                                            John Doe
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Pending Approval</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Data akan muncul setelah ada aktivitas pengecekan
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

<script>
    // Chart configuration
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
</script>