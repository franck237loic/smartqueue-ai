<?php $__env->startSection('title', 'Analytics - ' . $company->name); ?>

<?php $__env->startSection('styles'); ?>
<style>
.analytics-container {
    padding: 20px;
}

.metric-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.metric-value {
    font-size: 2.5rem;
    font-weight: bold;
    color: #007bff;
}

.metric-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 5px;
}

.chart-container {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.alert-item {
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border-left: 4px solid;
}

.alert-critical {
    background: #f8d7da;
    border-color: #dc3545;
}

.alert-high {
    background: #fff3cd;
    border-color: #ffc107;
}

.alert-medium {
    background: #d1ecf1;
    border-color: #17a2b8;
}

.recommendation-item {
    padding: 15px;
    margin: 10px 0;
    background: #e7f3ff;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.performance-score {
    font-size: 3rem;
    font-weight: bold;
}

.score-a { color: #28a745; }
.score-b { color: #17a2b8; }
.score-c { color: #ffc107; }
.score-d { color: #fd7e14; }
.score-f { color: #dc3545; }

.prediction-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 10px 0;
}

.prediction-time {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
}

.confidence-bar {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 5px;
}

.confidence-fill {
    height: 100%;
    background: #28a745;
    transition: width 0.3s ease;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="analytics-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📊 Analytics Dashboard</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="refreshAnalytics()">
                🔄 Actualiser
            </button>
            <button class="btn btn-success" onclick="exportReport()">
                📥 Exporter
            </button>
        </div>
    </div>

    <!-- Métriques Principales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="metric-card text-center">
                <div class="metric-value"><?php echo e($analytics['overview']['today']['tickets_created']); ?></div>
                <div class="metric-label">Tickets Créés (Aujourd'hui)</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card text-center">
                <div class="metric-value"><?php echo e($analytics['overview']['today']['tickets_served']); ?></div>
                <div class="metric-label">Tickets Servis (Aujourd'hui)</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card text-center">
                <div class="metric-value"><?php echo e(number_format($analytics['overview']['today']['avg_wait_time'], 1)); ?>m</div>
                <div class="metric-label">Temps d'Attente Moyen</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card text-center">
                <div class="metric-value"><?php echo e($analytics['overview']['today']['current_queue']); ?></div>
                <div class="metric-label">File d'Attente Actuelle</div>
            </div>
        </div>
    </div>

    <!-- Performance Score -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="metric-card">
                <h3>🎯 Score de Performance Global</h3>
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="performance-score score-<?php echo e(strtolower(substr($analytics['performance']['company']['grade'], 0, 1))); ?>">
                            <?php echo e($analytics['performance']['company']['overall_score']); ?>/100
                        </div>
                        <div class="metric-label">Grade: <?php echo e($analytics['performance']['company']['grade']); ?></div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <small>Expérience Client</small>
                                <div class="progress mb-2">
                                    <div class="progress-bar" style="width: <?php echo e($analytics['performance']['company']['metrics']['customer_experience']); ?>%"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <small>Efficacité Opérationnelle</small>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success" style="width: <?php echo e($analytics['performance']['company']['metrics']['operational_efficiency']); ?>%"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <small>Utilisation des Ressources</small>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-info" style="width: <?php echo e($analytics['performance']['company']['metrics']['resource_utilization']); ?>%"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <small>Croissance</small>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-warning" style="width: <?php echo e($analytics['performance']['company']['metrics']['growth']); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prédictions de Temps d'Attente -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="chart-container">
                <h3>⏰ Prédictions de Temps d'Attente</h3>
                <div class="row">
                    <?php $__currentLoopData = $analytics['predictions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceId => $prediction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="prediction-item">
                            <h5>Service <?php echo e($serviceId); ?></h5>
                            <div class="prediction-time"><?php echo e($prediction['estimated_minutes']); ?> min</div>
                            <div class="metric-label">File: <?php echo e($prediction['queue_length']); ?> personnes</div>
                            <div class="metric-label">Confiance: <?php echo e($prediction['confidence']); ?>%</div>
                            <div class="confidence-bar">
                                <div class="confidence-fill" style="width: <?php echo e($prediction['confidence']); ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Analyse de Charge -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="chart-container">
                <h3>📈 Analyse de Charge Actuelle</h3>
                <canvas id="loadChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <h4>📊 Métriques de Charge</h4>
                <div class="mb-3">
                    <strong>En Attente:</strong> <?php echo e($analytics['load_analysis']['real_time']['waiting']['count']); ?>

                </div>
                <div class="mb-3">
                    <strong>Appelés:</strong> <?php echo e($analytics['load_analysis']['real_time']['called']['count']); ?>

                </div>
                <div class="mb-3">
                    <strong>En Service:</strong> <?php echo e($analytics['load_analysis']['real_time']['serving']['count']); ?>

                </div>
                <div class="mb-3">
                    <strong>Agents Disponibles:</strong> <?php echo e($analytics['load_analysis']['real_time']['agents']['available']); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Alertes et Recommandations -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="metric-card">
                <h3>🚨 Alertes Actives</h3>
                <?php if(empty($analytics['alerts'])): ?>
                <p class="text-muted">Aucune alerte active</p>
                <?php else: ?>
                <?php $__currentLoopData = $analytics['alerts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert-item alert-<?php echo e($alert['severity']); ?>">
                    <strong><?php echo e(ucfirst($alert['severity'])); ?>:</strong> <?php echo e($alert['message']); ?>

                    <div class="small text-muted"><?php echo e($alert['timestamp']->format('H:i')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="metric-card">
                <h3>💡 Recommandations</h3>
                <?php if(empty($analytics['recommendations'])): ?>
                <p class="text-muted">Aucune recommandation</p>
                <?php else: ?>
                <?php $__currentLoopData = $analytics['recommendations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommendation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="recommendation-item">
                    <strong><?php echo e(ucfirst($recommendation['category'])); ?>:</strong> <?php echo e($recommendation['description']); ?>

                    <div class="small text-muted">Impact: <?php echo e($recommendation['impact']); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Performance des Agents -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="chart-container">
                <h3>👥 Performance des Agents</h3>
                <div class="row">
                    <?php $__currentLoopData = $analytics['performance']['agents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agentId => $agentScore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="metric-card text-center">
                            <div class="performance-score score-<?php echo e(strtolower(substr($agentScore['grade'], 0, 1))); ?>">
                                <?php echo e($agentScore['overall_score']); ?>

                            </div>
                            <div class="metric-label">Agent <?php echo e($agentId); ?></div>
                            <div class="metric-label"><?php echo e($agentScore['grade']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let loadChart = null;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    startRealTimeUpdates();
});

function initializeCharts() {
    // Graphique de charge
    const ctx = document.getElementById('loadChart').getContext('2d');
    loadChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['8h', '9h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h'],
            datasets: [{
                label: 'Tickets par heure',
                data: [12, 19, 23, 25, 22, 18, 20, 24, 28, 25, 20],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
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
                    beginAtZero: true
                }
            }
        }
    });
}

function startRealTimeUpdates() {
    // Mise à jour toutes les 30 secondes
    setInterval(refreshAnalytics, 30000);
}

function refreshAnalytics() {
    fetch(`/company/<?php echo e($company->id); ?>/analytics/real-time`)
        .then(response => response.json())
        .then(data => {
            updateMetrics(data);
            updateCharts(data);
        })
        .catch(error => {
            console.error('Erreur lors du rafraîchissement:', error);
        });
}

function updateMetrics(data) {
    // Mettre à jour les métriques principales
    document.querySelector('.metric-value').textContent = data.metrics.waiting_tickets;
    // ... autres mises à jour
}

function updateCharts(data) {
    // Mettre à jour les graphiques
    if (loadChart) {
        // Mettre à jour les données du graphique
        loadChart.update();
    }
}

function exportReport() {
    window.open(`/company/<?php echo e($company->id); ?>/analytics/export?format=csv&type=overview`, '_blank');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\analytics\dashboard.blade.php ENDPATH**/ ?>