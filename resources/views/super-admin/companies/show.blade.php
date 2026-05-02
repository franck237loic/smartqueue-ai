@extends('layouts.super-admin')

@section('title', 'Super Admin - ' . $company->name)

@section('content')
<div class="company-detail-container">
    <!-- Header Section -->
    <div class="company-header">
        <div class="header-left">
            <a href="{{ route('super_admin.companies') }}" class="back-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="company-info">
                <div class="company-avatar">
                    <span>{{ substr($company->name, 0, 2) }}</span>
                    <div class="status-indicator {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}"></div>
                </div>
                <div>
                    <h1 class="company-name">{{ $company->name }}</h1>
                    <div class="company-contact">
                        <span class="contact-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $company->email }}
                        </span>
                        @if($company->phone)
                        <span class="contact-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $company->phone }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="header-right">
            <div class="status-badge {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}">
                {{ ucfirst($company->status) }}
            </div>
            <a href="{{ route('super_admin.companies.edit', $company) }}" class="btn-edit">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <!-- Meta Info -->
    <div class="meta-info">
        <div class="meta-item">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Créée le {{ $company->created_at->format('d F Y') }}</span>
        </div>
        <div class="meta-item">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Dernière activité {{ $company->updated_at->diffForHumans() }}</span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['global']['total'] ?? 0 }}</div>
                <div class="stat-label">Total Tickets</div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['global']['waiting'] ?? 0 }}</div>
                <div class="stat-label">En Attente</div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['global']['served'] ?? 0 }}</div>
                <div class="stat-label">Servis</div>
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['global']['missed_rate'] ?? 0 }}%</div>
                <div class="stat-label">Taux Absence</div>
            </div>
        </div>
    </div>

    <!-- Performance & Agents -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon performance">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="info-title">Performance</h3>
            </div>
            <div class="info-content">
                <div class="info-item">
                    <span class="info-label">Temps moyen d'attente</span>
                    <span class="info-value">{{ $stats['performance']['avg_wait_time'] ?? 0 }} min</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Temps moyen de service</span>
                    <span class="info-value">{{ $stats['performance']['avg_service_time'] ?? 0 }} min</span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="info-header">
                <div class="info-icon agents">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="info-title">Agents & Services</h3>
            </div>
            <div class="info-content">
                <div class="info-item">
                    <span class="info-label">Agents total</span>
                    <span class="info-value">{{ $stats['agents']['total_agents'] ?? 0 }}</span>
                </div>
                @if(isset($stats['agents']['top_agent']))
                <div class="info-item">
                    <span class="info-label">Agent le plus actif</span>
                    <span class="info-value">{{ $stats['agents']['top_agent']['name'] }} ({{ $stats['agents']['top_agent']['tickets'] }} tickets)</span>
                </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Services</span>
                    <span class="info-value">{{ $stats['services']['total_services'] ?? 0 }}</span>
                </div>
                @if(isset($stats['services']['top_service']))
                <div class="info-item">
                    <span class="info-label">Service le plus utilisé</span>
                    <span class="info-value">{{ $stats['services']['top_service']['name'] }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-section">
        <div class="chart-header">
            <div class="chart-icon">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="chart-title">Activité des Tickets (7 derniers jours)</h3>
        </div>
        <div class="chart-container">
            <canvas id="ticketsChart"></canvas>
        </div>
    </div>

    <!-- Activity Section -->
    <div class="activity-section">
        <div class="activity-header">
            <div class="activity-icon">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="activity-title">Activité Récente</h3>
        </div>
        <div class="activity-list">
            @forelse($stats['recent_activity'] as $activity)
            <div class="activity-item">
                <div class="activity-left">
                    <span class="activity-badge {{ $activity['action'] === 'Créé' ? 'created' : ($activity['action'] === 'Appelé' ? 'called' : ($activity['action'] === 'Servi' ? 'served' : 'cancelled')) }}">
                        {{ $activity['action'] }}
                    </span>
                    <span class="activity-description">{{ $activity['description'] }}</span>
                </div>
                <div class="activity-right">
                    <div class="activity-user">{{ $activity['user'] }}</div>
                    <div class="activity-time">{{ $activity['date']->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div class="empty-activity">
                <div class="empty-icon">
                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="empty-title">Aucune activité récente</h4>
                <p class="empty-description">Aucune activité n'a été enregistrée récemment</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($stats['tickets_by_day']['labels'] ?? []),
            datasets: [{
                label: 'Tickets créés',
                data: @json($stats['tickets_by_day']['data'] ?? []),
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
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
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
                            return 'Tickets: ' + context.parsed.y;
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
.company-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.company-header {
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

.header-left {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.back-btn {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.company-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
    position: relative;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.status-indicator {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 16px;
    height: 16px;
    border: 3px solid white;
    border-radius: 50%;
}

.status-indicator.active {
    background: var(--success);
}

.status-indicator.suspended {
    background: var(--warning);
}

.status-indicator.inactive {
    background: var(--gray-400);
}

.company-info {
    flex: 1;
}

.company-name {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.company-contact {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.header-right {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-end;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.2);
    color: #10B981;
}

.status-badge.suspended {
    background: rgba(245, 158, 11, 0.2);
    color: #F59E0B;
}

.status-badge.inactive {
    background: rgba(107, 114, 128, 0.2);
    color: #6B7280;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-edit:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Meta Info */
.meta-info {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    padding: 1rem 0;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.9rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

.stat-card.warning .stat-icon {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
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
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon.performance {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
}

.info-icon.agents {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.info-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.info-value {
    font-weight: 600;
    color: var(--dark);
    text-align: right;
}

/* Chart Section */
.chart-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    margin-bottom: 2rem;
}

.chart-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
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

.chart-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.chart-container {
    height: 300px;
    position: relative;
}

/* Activity Section */
.activity-section {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.activity-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 2rem;
    border-bottom: 1px solid var(--gray-200);
}

.activity-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.activity-list {
    max-height: 400px;
    overflow-y-auto;
}

.activity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--gray-100);
    transition: background 0.3s ease;
}

.activity-item:hover {
    background: var(--gray-50);
}

.activity-left {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
}

.activity-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: capitalize;
    width: fit-content;
}

.activity-badge.created {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

.activity-badge.called {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.activity-badge.served {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.activity-badge.cancelled {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
}

.activity-description {
    color: var(--dark);
    font-weight: 500;
}

.activity-right {
    text-align: right;
}

.activity-user {
    color: var(--gray-600);
    font-size: 0.9rem;
    font-weight: 500;
}

.activity-time {
    color: var(--gray-500);
    font-size: 0.8rem;
}

/* Empty Activity */
.empty-activity {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    color: var(--gray-300);
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--gray-500);
}

/* Responsive */
@media (max-width: 768px) {
    .company-header {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .header-right {
        align-items: center;
        width: 100%;
    }
    
    .meta-info {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .activity-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .activity-right {
        text-align: center;
    }
}
</style>
@endsection
