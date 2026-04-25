@extends('layouts.modern-sidebar')

@section('title', 'Monitoring - ' . $company->name)

@section('styles')
<style>
.monitoring-container {
    padding: 20px;
}

.health-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.health-status {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-healthy { background: #28a745; }
.status-warning { background: #ffc107; }
.status-critical { background: #dc3545; }

.metric-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.metric-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
}

.metric-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: #007bff;
}

.metric-label {
    color: #6c757d;
    font-size: 0.8rem;
    margin-top: 5px;
}

.alert-list {
    max-height: 300px;
    overflow-y: auto;
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

.performance-chart {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.websocket-status {
    background: #e8f5e8;
    border: 1px solid #28a745;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.connection-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.connection-item {
    text-align: center;
}

.connection-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #28a745;
}

.system-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-top: 10px;
}

.uptime-display {
    font-size: 1.2rem;
    font-weight: bold;
    color: #28a745;
}

.refresh-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    background: #28a745;
    border-radius: 50%;
    margin-left: 10px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>
@endsection

@section('content')
<div class="monitoring-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🖥️ Monitoring Dashboard</h1>
        <div class="d-flex gap-2 align-items-center">
            <span class="refresh-indicator"></span>
            <span class="text-muted">Temps réel</span>
            <button class="btn btn-primary" onclick="refreshMonitoring()">
                🔄 Actualiser
            </button>
        </div>
    </div>

    <!-- État de Santé du Système -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="health-card">
                <h3>🏥 État de Santé du Système</h3>
                <div class="health-status">
                    <div class="status-indicator status-{{ $monitoring['health']['overall'] }}"></div>
                    <h4>Statut Global: {{ ucfirst($monitoring['health']['overall']) }}</h4>
                    <span class="badge badge-{{ $monitoring['health']['overall'] === 'healthy' ? 'success' : ($monitoring['health']['overall'] === 'warning' ? 'warning' : 'danger') }}">
                        Score: {{ $monitoring['health']['score'] }}/100
                    </span>
                </div>
                
                <div class="row">
                    @foreach($monitoring['health']['checks'] as $check => $status)
                    <div class="col-md-3">
                        <div class="metric-item">
                            <div class="status-indicator status-{{ $status['status'] }}"></div>
                            <strong>{{ ucfirst($check) }}</strong>
                            <div class="small">{{ $status['message'] }}</div>
                            @if(isset($status['response_time']))
                            <div class="text-muted">{{ $status['response_time'] }}ms</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Métriques de Performance -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="performance-chart">
                <h3>📊 Performance en Temps Réel</h3>
                <canvas id="performanceChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="health-card">
                <h4>⚡ Métriques de Performance</h4>
                <div class="metric-grid">
                    <div class="metric-item">
                        <div class="metric-value">{{ $monitoring['performance']['response_times']['database'] }}ms</div>
                        <div class="metric-label">Base de Données</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-value">{{ $monitoring['performance']['response_times']['cache'] }}ms</div>
                        <div class="metric-label">Cache</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-value">{{ $monitoring['performance']['throughput']['tickets_per_hour'] }}</div>
                        <div class="metric-label">Tickets/Heure</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-value">{{ $monitoring['performance']['queue_metrics']['current_queue_length'] }}</div>
                        <div class="metric-label">File Actuelle</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WebSocket Status -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="websocket-status">
                <h4>🔌 WebSocket (Reverb) Status</h4>
                <div class="connection-metrics">
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['connections']['total'] }}</div>
                        <div class="metric-label">Connexions Totales</div>
                    </div>
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['connections']['clients'] }}</div>
                        <div class="metric-label">Clients</div>
                    </div>
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['connections']['agents'] }}</div>
                        <div class="metric-label">Agents</div>
                    </div>
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['performance']['latency'] }}ms</div>
                        <div class="metric-label">Latence</div>
                    </div>
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['performance']['message_rate'] }}/s</div>
                        <div class="metric-label">Messages/s</div>
                    </div>
                    <div class="connection-item">
                        <div class="connection-number">{{ $monitoring['websocket']['performance']['error_rate'] }}%</div>
                        <div class="metric-label">Taux d'Erreur</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Base de Données et Cache -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="health-card">
                <h4>🗄️ Base de Données</h4>
                <div class="system-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Connexion:</strong> {{ $monitoring['database']['connection']['status'] }}
                        </div>
                        <div class="col-md-6">
                            <strong>Hôte:</strong> {{ $monitoring['database']['connection']['host'] }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Requêtes/s:</strong> {{ $monitoring['database']['performance']['queries_per_second'] }}
                        </div>
                        <div class="col-md-6">
                            <strong>Temps moyen:</strong> {{ $monitoring['database']['performance']['query_time_avg'] }}ms
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Requêtes lentes:</strong> {{ $monitoring['database']['performance']['slow_queries'] }}
                        </div>
                        <div class="col-md-6">
                            <strong>Taille:</strong> {{ $monitoring['database']['size']['database_size'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="health-card">
                <h4>💾 Cache</h4>
                <div class="system-info">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Driver:</strong> {{ $monitoring['cache']['driver'] }}
                        </div>
                        <div class="col-md-6">
                            <strong>Statut:</strong> {{ $monitoring['cache']['status'] }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Taux de Hit:</strong> {{ $monitoring['cache']['metrics']['hit_rate'] }}%
                        </div>
                        <div class="col-md-6">
                            <strong>Taux de Miss:</strong> {{ $monitoring['cache']['metrics']['miss_rate'] }}%
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Opérations/s:</strong> {{ $monitoring['cache']['performance']['operations_per_second'] }}
                        </div>
                        <div class="col-md-6">
                            <strong>Clés:</strong> {{ $monitoring['cache']['metrics']['keys_count'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes et Erreurs -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="health-card">
                <h3>🚨 Alertes Système</h3>
                <div class="alert-list">
                    @if(empty($monitoring['alerts']))
                    <p class="text-muted">Aucune alerte active</p>
                    @else
                    @foreach($monitoring['alerts'] as $alert)
                    <div class="alert-item alert-{{ $alert['severity'] }}">
                        <strong>{{ ucfirst($alert['type']) }}</strong>: {{ $alert['message'] }}
                        <div class="small text-muted">{{ $alert['timestamp']->format('H:i:s') }}</div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="health-card">
                <h3>📋 Erreurs Récentes</h3>
                <div class="alert-list">
                    @if(empty($monitoring['errors']['recent_errors']))
                    <p class="text-muted">Aucune erreur récente</p>
                    @else
                    @foreach($monitoring['errors']['recent_errors'] as $error)
                    <div class="alert-item alert-medium">
                        <strong>{{ $error['level'] }}</strong>: {{ $error['message'] }}
                        <div class="small text-muted">{{ $error['context'] }} - {{ $error['timestamp']->format('H:i:s') }}</div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="mt-3">
                    <h5>Tendances d'Erreurs</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <small>Dernière heure:</small>
                            <strong>{{ $monitoring['errors']['error_trends']['last_hour'] }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small>6 dernières heures:</small>
                            <strong>{{ $monitoring['errors']['error_trends']['last_6_hours'] }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small>24 dernières heures:</small>
                            <strong>{{ $monitoring['errors']['error_trends']['last_24_hours'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Uptime et Disponibilité -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="health-card">
                <h3>⏰ Uptime et Disponibilité</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="metric-item">
                            <div class="uptime-display">{{ $monitoring['uptime']['system_uptime'] }}</div>
                            <div class="metric-label">Uptime Système</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-item">
                            <div class="metric-value">{{ $monitoring['uptime']['service_uptime']['last_24_hours'] }}%</div>
                            <div class="metric-label">Disponibilité 24h</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-item">
                            <div class="metric-value">{{ $monitoring['uptime']['service_uptime']['last_7_days'] }}%</div>
                            <div class="metric-label">Disponibilité 7j</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric-item">
                            <div class="metric-value">{{ $monitoring['uptime']['downtime_incidents']['last_30_days'] }}</div>
                            <div class="metric-label">Incidents 30j</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h5>SLA (Service Level Agreement)</h5>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar {{ $monitoring['uptime']['availability']['sla_met'] ? 'bg-success' : 'bg-danger' }}" 
                             style="width: {{ $monitoring['uptime']['availability']['current'] }}%">
                            {{ $monitoring['uptime']['availability']['current'] }}% (Cible: {{ $monitoring['uptime']['availability']['target'] }}%)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let performanceChart = null;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    startRealTimeMonitoring();
});

function initializeCharts() {
    // Graphique de performance
    const ctx = document.getElementById('performanceChart').getContext('2d');
    performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: generateTimeLabels(),
            datasets: [
                {
                    label: 'Temps réponse DB (ms)',
                    data: generateRandomData(12, 10, 50),
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Temps réponse Cache (ms)',
                    data: generateRandomData(12, 1, 10),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Tickets/heure',
                    data: generateRandomData(12, 5, 30),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
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

function startRealTimeMonitoring() {
    // Mise à jour toutes les 30 secondes
    setInterval(refreshMonitoring, 30000);
    
    // Mise à jour du graphique toutes les 5 secondes
    setInterval(updatePerformanceChart, 5000);
}

function refreshMonitoring() {
    fetch(`/company/{{ $company->id }}/monitoring/real-time`)
        .then(response => response.json())
        .then(data => {
            updateHealthStatus(data.health);
            updateMetrics(data.performance);
            updateWebSocketStatus(data.websocket);
            updateAlerts(data.alerts);
        })
        .catch(error => {
            console.error('Erreur lors du rafraîchissement:', error);
        });
}

function updatePerformanceChart() {
    if (performanceChart) {
        // Décaler les données et ajouter de nouvelles valeurs
        performanceChart.data.datasets.forEach(dataset => {
            dataset.data.shift();
            dataset.data.push(generateRandomData(1, 5, 50)[0]);
        });
        
        // Mettre à jour les labels
        performanceChart.data.labels.shift();
        performanceChart.data.labels.push(new Date().toLocaleTimeString());
        
        performanceChart.update('none');
    }
}

function updateHealthStatus(health) {
    // Mettre à jour l'indicateur de santé
    const indicator = document.querySelector('.status-indicator');
    indicator.className = `status-indicator status-${health.overall}`;
    
    // Mettre à jour le score
    document.querySelector('.badge').textContent = `Score: ${health.score}/100`;
}

function updateMetrics(performance) {
    // Mettre à jour les métriques de performance
    document.querySelectorAll('.metric-value').forEach((element, index) => {
        const values = [
            performance.response_times.database,
            performance.response_times.cache,
            performance.throughput.tickets_per_hour,
            performance.queue_metrics.current_queue_length
        ];
        
        if (values[index] !== undefined) {
            element.textContent = values[index];
        }
    });
}

function updateWebSocketStatus(websocket) {
    // Mettre à jour les métriques WebSocket
    document.querySelectorAll('.connection-number').forEach((element, index) => {
        const values = [
            websocket.connections.total,
            websocket.connections.clients,
            websocket.connections.agents,
            websocket.performance.latency,
            websocket.performance.message_rate,
            websocket.performance.error_rate
        ];
        
        if (values[index] !== undefined) {
            element.textContent = values[index];
        }
    });
}

function updateAlerts(alerts) {
    // Mettre à jour la liste des alertes
    const alertList = document.querySelector('.alert-list');
    if (alertList && alerts.length > 0) {
        alertList.innerHTML = alerts.map(alert => `
            <div class="alert-item alert-${alert.severity}">
                <strong>${alert.type}</strong>: ${alert.message}
                <div class="small text-muted">${new Date(alert.timestamp).toLocaleTimeString()}</div>
            </div>
        `).join('');
    }
}

function generateTimeLabels() {
    const labels = [];
    const now = new Date();
    for (let i = 11; i >= 0; i--) {
        const time = new Date(now - i * 5 * 60000);
        labels.push(time.toLocaleTimeString());
    }
    return labels;
}

function generateRandomData(count, min, max) {
    const data = [];
    for (let i = 0; i < count; i++) {
        data.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    return data;
}
</script>
@endsection
