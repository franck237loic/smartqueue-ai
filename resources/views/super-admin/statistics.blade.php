@extends('layouts.super-admin')

@section('title', 'Super Admin - Statistiques Générales')

@section('content')
<div class="statistics-container">
    <!-- Header Section -->
    <div class="statistics-header">
        <div class="header-content">
            <h1 class="page-title">Statistiques Générales</h1>
            <p class="page-subtitle">Vue d'ensemble du système et des performances</p>
        </div>
        <div class="header-right">
            <div class="stats-icon">
                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="date-filter">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label class="filter-label">Période</label>
                <select name="period" class="filter-select" onchange="this.form.submit()">
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                    <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Cette semaine</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Ce mois</option>
                    <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Cette année</option>
                    <option value="all" {{ request('period') === 'all' ? 'selected' : '' }}>Tout le temps</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Date de début</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="filter-input">
            </div>
            <div class="filter-group">
                <label class="filter-label">Date de fin</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="filter-input">
            </div>
            <button type="submit" class="btn-filter">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Appliquer
            </button>
        </form>
    </div>

    <!-- Overview Cards -->
    <div class="overview-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['companies']['total'] ?? 0 }}</div>
                <div class="stat-label">Entreprises</div>
                <div class="stat-change positive">+{{ $stats['companies']['growth'] ?? 0 }}%</div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['users']['total'] ?? 0 }}</div>
                <div class="stat-label">Utilisateurs</div>
                <div class="stat-change positive">+{{ $stats['users']['growth'] ?? 0 }}%</div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['services']['total'] ?? 0 }}</div>
                <div class="stat-label">Services</div>
                <div class="stat-change positive">+{{ $stats['services']['growth'] ?? 0 }}%</div>
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['counters']['total'] ?? 0 }}</div>
                <div class="stat-label">Guichets</div>
                <div class="stat-change positive">+{{ $stats['counters']['growth'] ?? 0 }}%</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Tickets Over Time -->
        <div class="chart-section">
            <div class="chart-header">
                <div class="chart-icon">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="chart-title">Évolution des Tickets</h3>
            </div>
            <div class="chart-container">
                <canvas id="ticketsChart"></canvas>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="chart-section">
            <div class="chart-header">
                <div class="chart-icon performance">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="chart-title">Métriques de Performance</h3>
            </div>
            <div class="metrics-grid">
                <div class="metric-item">
                    <div class="metric-value">{{ $stats['performance']['avg_wait_time'] ?? 0 }} min</div>
                    <div class="metric-label">Temps d'attente moyen</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">{{ $stats['performance']['avg_service_time'] ?? 0 }} min</div>
                    <div class="metric-label">Temps de service moyen</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">{{ $stats['performance']['satisfaction_rate'] ?? 0 }}%</div>
                    <div class="metric-label">Taux de satisfaction</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">{{ $stats['performance']['efficiency'] ?? 0 }}%</div>
                    <div class="metric-label">Efficacité globale</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Companies -->
    <div class="top-section">
        <div class="section-header">
            <div class="section-icon companies">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="section-title">Top Entreprises</h3>
        </div>
        <div class="top-grid">
            @foreach($stats['top_companies'] ?? [] as $company)
            <div class="top-item">
                <div class="top-info">
                    <div class="top-avatar">
                        <span>{{ substr($company['name'], 0, 2) }}</span>
                    </div>
                    <div>
                        <h4 class="top-name">{{ $company['name'] }}</h4>
                        <p class="top-stats">{{ $company['tickets'] }} tickets • {{ $company['users'] }} utilisateurs</p>
                    </div>
                </div>
                <div class="top-metrics">
                    <div class="top-metric">
                        <span class="metric-number">{{ $company['avg_wait_time'] }} min</span>
                        <span class="metric-label">Attente</span>
                    </div>
                    <div class="top-metric">
                        <span class="metric-number">{{ $company['satisfaction'] }}%</span>
                        <span class="metric-label">Satisfaction</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- System Health -->
    <div class="health-section">
        <div class="section-header">
            <div class="section-icon health">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="section-title">Santé du Système</h3>
        </div>
        <div class="health-grid">
            <div class="health-item">
                <div class="health-status good"></div>
                <div class="health-info">
                    <h4 class="health-title">Base de données</h4>
                    <p class="health-description">Connexion stable, performance optimale</p>
                    <div class="health-metrics">
                        <span class="health-metric">Latence: 12ms</span>
                        <span class="health-metric">Uptime: 99.9%</span>
                    </div>
                </div>
            </div>

            <div class="health-item">
                <div class="health-status good"></div>
                <div class="health-info">
                    <h4 class="health-title">Serveur Web</h4>
                    <p class="health-description">Toutes les services opérationnels</p>
                    <div class="health-metrics">
                        <span class="health-metric">CPU: 45%</span>
                        <span class="health-metric">RAM: 2.1GB</span>
                    </div>
                </div>
            </div>

            <div class="health-item">
                <div class="health-status warning"></div>
                <div class="health-info">
                    <h4 class="health-title">File d'Attente</h4>
                    <p class="health-description">Trafic élevé, temps de traitement normal</p>
                    <div class="health-metrics">
                        <span class="health-metric">En attente: 23</span>
                        <span class="health-metric">Traité/min: 45</span>
                    </div>
                </div>
            </div>

            <div class="health-item">
                <div class="health-status good"></div>
                <div class="health-info">
                    <h4 class="health-title">Email Service</h4>
                    <p class="health-description">Envoi d'emails fonctionnel</p>
                    <div class="health-metrics">
                        <span class="health-metric">Envoyés: 1,234</span>
                        <span class="health-metric">Erreurs: 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tickets Chart
    const ctx = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($stats['tickets_chart']['labels'] ?? []),
            datasets: [{
                label: 'Tickets créés',
                data: @json($stats['tickets_chart']['data'] ?? []),
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: '#4F46E5',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'Tickets traités',
                data: @json($stats['processed_tickets_chart']['data'] ?? []),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4F46E5',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(107, 114, 128, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 12
                        },
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

<style>
.statistics-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.statistics-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

.header-right {
    display: flex;
    align-items: center;
}

.stats-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Date Filter */
.date-filter {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.filter-form {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-width: 150px;
}

.filter-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dark);
}

.filter-input,
.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--gray-50);
    color: var(--dark);
}

.filter-input:focus,
.filter-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background: white;
}

.btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

/* Overview Grid */
.overview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-card.primary .stat-icon {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.stat-card.warning .stat-icon {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.stat-card.danger .stat-icon {
    background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-600);
    margin-bottom: 0.25rem;
}

.stat-change {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    display: inline-block;
}

.stat-change.positive {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.stat-change.negative {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
}

/* Charts Grid */
.charts-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.chart-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.chart-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.chart-icon.performance {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.chart-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.chart-container {
    height: 300px;
    position: relative;
}

.metrics-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.metric-item {
    text-align: center;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.metric-label {
    font-size: 0.9rem;
    color: var(--gray-600);
}

/* Top Section */
.top-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.section-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.section-icon.companies {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.section-icon.health {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.top-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.top-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.top-item:hover {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.top-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.top-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    flex-shrink: 0;
}

.top-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.top-stats {
    font-size: 0.8rem;
    color: var(--gray-600);
}

.top-metrics {
    display: flex;
    gap: 1rem;
}

.top-metric {
    text-align: center;
}

.metric-number {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
}

/* Health Section */
.health-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.health-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.health-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.health-status {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 4px;
}

.health-status.good {
    background: var(--success);
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
}

.health-status.warning {
    background: var(--warning);
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
}

.health-status.error {
    background: var(--error);
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
}

.health-info {
    flex: 1;
}

.health-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.health-description {
    font-size: 0.9rem;
    color: var(--gray-600);
    margin-bottom: 1rem;
}

.health-metrics {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.health-metric {
    font-size: 0.8rem;
    color: var(--gray-500);
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    border: 1px solid var(--gray-200);
}

/* Responsive */
@media (max-width: 768px) {
    .statistics-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        min-width: auto;
    }
    
    .overview-grid {
        grid-template-columns: 1fr;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .top-grid {
        grid-template-columns: 1fr;
    }
    
    .top-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .health-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
