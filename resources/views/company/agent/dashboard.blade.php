@extends('layouts.modern-sidebar')

@section('title', 'Dashboard Agent - ' . $company->name)

@section('content')
<div class="agent-dashboard">
    <!-- Premium Header -->
    <header class="dashboard-header">
        <div class="header-background">
            <div class="gradient-overlay"></div>
            <div class="pattern-overlay"></div>
        </div>
        <div class="header-container">
            <div class="header-left">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="user-details">
                        <h1 class="welcome-text">Bonjour, {{ auth()->user()->name }}</h1>
                        <div class="company-info">
                            <span class="company-name">{{ $company->name }}</span>
                            <span class="role-badge">Agent</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="header-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $waitingTickets ?? 0 }}</div>
                        <div class="stat-label">En attente</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $servedToday ?? 0 }}</div>
                        <div class="stat-label">Servis</div>
                    </div>
                </div>
                <a href="{{ route('company.agent.dashboard', $company) }}" class="refresh-btn">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Dashboard -->
    <main class="main-dashboard">
        <!-- Quick Actions -->
        <section class="quick-actions">
            <div class="actions-grid">
                <a href="{{ route('company.agent.counter', [$company, $counters->first() ?? 1]) }}" class="action-card primary">
                    <div class="action-icon">
                        <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <h3>Guichet Principal</h3>
                        <p>Accéder au guichet</p>
                    </div>
                    <div class="action-arrow">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('company.agent.history', $company) }}" class="action-card secondary">
                    <div class="action-icon">
                        <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <h3>Historique</h3>
                        <p>Voir l'historique</p>
                    </div>
                    <div class="action-arrow">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('company.agent.service.all', $company) }}" class="action-card tertiary">
                    <div class="action-icon">
                        <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <h3>Services</h3>
                        <p>Tous les services</p>
                    </div>
                    <div class="action-arrow">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </section>

        <!-- Performance Stats -->
        <section class="performance-section">
            <div class="section-header">
                <h2>Performance du Jour</h2>
                <div class="time-indicator">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Mis à jour en temps réel</span>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon served">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h4>Tickets Servis</h4>
                            <p>Aujourd'hui</p>
                        </div>
                    </div>
                    <div class="stat-value" id="servedToday">{{ $servedToday ?? 0 }}</div>
                    <div class="stat-trend">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+12% vs hier</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon missed">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h4>Tickets Manqués</h4>
                            <p>Aujourd'hui</p>
                        </div>
                    </div>
                    <div class="stat-value" id="missedToday">{{ $missedToday ?? 0 }}</div>
                    <div class="stat-trend negative">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        <span>-5% vs hier</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon time">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h4>Temps Moyen</h4>
                            <p>Par service</p>
                        </div>
                    </div>
                    <div class="stat-value" id="avgServiceTime">{{ $avgServiceTime ?? 0 }}m</div>
                    <div class="stat-trend">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+2min vs hier</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon waiting">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h4>File d'Attente</h4>
                            <p>Actuellement</p>
                        </div>
                    </div>
                    <div class="stat-value" id="waitingCount">{{ $waitingTickets ?? 0 }}</div>
                    <div class="stat-trend">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14"/>
                        </svg>
                        <span>Stable</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Active Counters -->
        <section class="counters-section">
            <div class="section-header">
                <h2>Mes Guichets</h2>
                <div class="counter-count">{{ $counters->count() }} guichet(s)</div>
            </div>
            
            <div class="counters-grid">
                @foreach($counters as $counter)
                <div class="counter-card">
                    <div class="counter-header">
                        <div class="counter-info">
                            <h3>{{ $counter->name }}</h3>
                            <span class="service-name">{{ $counter->service->name ?? 'Non assigné' }}</span>
                        </div>
                        <div class="counter-status {{ $counter->isOpen() ? 'open' : 'closed' }}">
                            <div class="status-dot"></div>
                            <span>{{ $counter->isOpen() ? 'Ouvert' : 'Fermé' }}</span>
                        </div>
                    </div>
                    
                    <div class="counter-stats">
                        <div class="mini-stat">
                            <span class="label">Servis</span>
                            <span class="value">{{ $counter->tickets()->whereDate('created_at', today())->where('status', 'SERVED')->count() }}</span>
                        </div>
                        <div class="mini-stat">
                            <span class="label">En attente</span>
                            <span class="value">{{ $counter->tickets()->where('status', 'WAITING')->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="counter-actions">
                        <a href="{{ route('company.agent.counter', [$company, $counter]) }}" class="counter-btn primary">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Ouvrir
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Schedule Status -->
        <section class="schedule-section">
            <div class="section-header">
                <h2>Planning du Jour</h2>
                <div class="schedule-time">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ now()->format('H:i') }}</span>
                </div>
            </div>
            
            <div class="schedule-grid" id="scheduleStatus">
                <!-- Schedule items will be loaded here via JavaScript -->
            </div>
        </section>
    </main>
</div>

<script>
// Simple and Safe Agent Dashboard
document.addEventListener('DOMContentLoaded', function() {
    
    // Safe element selector
    function safeGetElement(id) {
        try {
            return document.getElementById(id);
        } catch (e) {
            return null;
        }
    }
    
    // Safe element selector for querySelector
    function safeQuerySelector(selector) {
        try {
            return document.querySelector(selector);
        } catch (e) {
            return null;
        }
    }
    
    // Safe element selector for querySelectorAll
    function safeQuerySelectorAll(selector) {
        try {
            return document.querySelectorAll(selector);
        } catch (e) {
            return [];
        }
    }
    
    // Update stats safely
    function updateStats(stats) {
        const servedToday = safeGetElement('servedToday');
        const missedToday = safeGetElement('missedToday');
        const avgServiceTime = safeGetElement('avgServiceTime');
        const waitingCount = safeGetElement('waitingCount');
        
        if (servedToday && stats.served_today !== undefined) {
            servedToday.textContent = stats.served_today;
        }
        if (missedToday && stats.missed_today !== undefined) {
            missedToday.textContent = stats.missed_today;
        }
        if (avgServiceTime && stats.avg_service_time !== undefined) {
            avgServiceTime.textContent = stats.avg_service_time + 'm';
        }
        if (waitingCount && stats.waiting_today !== undefined) {
            waitingCount.textContent = stats.waiting_today;
        }
    }
    
    // Display schedule status safely
    function displayScheduleStatus(data) {
        const container = safeGetElement('scheduleStatus');
        if (!container) return;
        
        const schedules = data.counters || [];
        
        if (!schedules || schedules.length === 0) {
            container.innerHTML = '<div style="text-align: center; padding: 2rem; color: #666;">Aucun planning configuré</div>';
            return;
        }
        
        let html = '';
        schedules.forEach(function(schedule) {
            html += '<div style="border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">';
            html += '<h4>' + (schedule.counter_name || 'Guichet') + '</h4>';
            html += '<p>Service: ' + (schedule.service || 'Non assigné') + '</p>';
            html += '<p>Agent: ' + (schedule.agent || 'Non assigné') + '</p>';
            html += '<p>Statut: ' + (schedule.is_in_working_hours ? 'En service' : 'Hors service') + '</p>';
            html += '</div>';
        });
        
        container.innerHTML = html;
    }
    
    // Fetch stats
    async function refreshStats() {
        try {
            const response = await fetch('/company/{{ $company->id }}/agent/api/performance');
            if (response.ok) {
                const data = await response.json();
                updateStats(data.stats || {});
            }
        } catch (error) {
            console.log('Stats refresh failed');
        }
    }
    
    // Fetch schedule
    async function loadScheduleStatus() {
        try {
            const response = await fetch('/company/{{ $company->id }}/agent/api/work-schedules/status');
            if (response.ok) {
                const data = await response.json();
                displayScheduleStatus(data);
            }
        } catch (error) {
            console.log('Schedule refresh failed');
        }
    }
    
    // Add simple hover effects
    function addHoverEffects() {
        const cards = safeQuerySelectorAll('.action-card, .stat-card, .counter-card');
        cards.forEach(function(card) {
            if (card) {
                card.addEventListener('mouseenter', function() {
                    try {
                        card.style.transform = 'translateY(-2px)';
                        card.style.transition = 'transform 0.3s ease';
                    } catch (e) {}
                });
                
                card.addEventListener('mouseleave', function() {
                    try {
                        card.style.transform = 'translateY(0)';
                    } catch (e) {}
                });
            }
        });
    }
    
    // Refresh button handler
    function initRefreshButton() {
        const refreshBtn = safeQuerySelector('.refresh-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function(e) {
                e.preventDefault();
                refreshStats();
                loadScheduleStatus();
            });
        }
    }
    
    // Auto refresh
    function startAutoRefresh() {
        // Initial load
        refreshStats();
        loadScheduleStatus();
        
        // Set interval for auto refresh
        setInterval(function() {
            refreshStats();
            loadScheduleStatus();
        }, 30000);
    }
    
    // Initialize everything
    try {
        startAutoRefresh();
        addHoverEffects();
        initRefreshButton();
    } catch (error) {
        console.log('Dashboard initialization failed');
    }
});
</script>

<style>
/* Simple Dashboard Styles */
.agent-dashboard {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: Arial, sans-serif;
    color: #1e293b;
}

.dashboard-header {
    padding: 2rem;
    background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
    color: white;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.welcome-text {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.company-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    font-size: 0.8rem;
}

.header-stats {
    display: flex;
    gap: 2rem;
    text-align: center;
}

.stat-item .stat-value {
    font-size: 1.5rem;
    font-weight: bold;
}

.stat-item .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.refresh-btn {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 1rem;
}

.main-dashboard {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.action-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    text-decoration: none;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease;
}

.action-card:hover {
    transform: translateY(-2px);
}

.action-icon {
    width: 50px;
    height: 50px;
    background: #f8fafc;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3b82f6;
}

.action-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.action-content p {
    font-size: 0.9rem;
    color: #64748b;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stat-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-icon.served { background: #10b981; }
.stat-icon.missed { background: #ef4444; }
.stat-icon.time { background: #f59e0b; }
.stat-icon.waiting { background: #3b82f6; }

.stat-value {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.counters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.counter-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.counter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.counter-info h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.service-name {
    font-size: 0.9rem;
    color: #64748b;
}

.counter-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.counter-status.open {
    background: #d1fae5;
    color: #10b981;
}

.counter-status.closed {
    background: #fee2e2;
    color: #ef4444;
}

.counter-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 1rem;
}

.mini-stat {
    text-align: center;
}

.mini-stat .label {
    font-size: 0.8rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.mini-stat .value {
    font-size: 1.1rem;
    font-weight: 600;
}

.counter-btn {
    background: #3b82f6;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s ease;
}

.counter-btn:hover {
    background: #2563eb;
}

.schedule-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.schedule-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-left: 4px solid #10b981;
}

.schedule-card.inactive {
    border-left-color: #64748b;
}

.schedule-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.schedule-service {
    font-size: 0.9rem;
    color: #64748b;
}

.schedule-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
}

.status-indicator.off {
    background: #64748b;
}

.schedule-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.schedule-time, .schedule-agent {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #64748b;
}

.schedule-empty {
    text-align: center;
    padding: 2rem;
    color: #64748b;
}

@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .actions-grid, .stats-grid, .counters-grid, .schedule-grid {
        grid-template-columns: 1fr;
    }
    
    .main-dashboard {
        padding: 1rem;
    }
}
</style>
@endsection
