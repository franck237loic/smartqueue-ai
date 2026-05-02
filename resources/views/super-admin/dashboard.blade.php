@extends('layouts.super-admin')

@section('title', 'Super Admin - Dashboard')

@section('content')
<div class="dashboard-container" x-data="{ stats: {!! json_encode($stats ?? []) !!} }">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">Bienvenue, Super Admin</h1>
            <p class="welcome-subtitle">Voici un aperçu de votre plateforme SmartQueue AI</p>
        </div>
        <div class="welcome-time">
            <div class="time-display" x-text="new Date().toLocaleTimeString()"></div>
            <div class="time-label">{{ now()->format('l d F Y') }}</div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number" x-text="stats.companies_count || 0"></div>
                <div class="stat-label">Entreprises totales</div>
                <div class="stat-change positive">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>+12%</span>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number" x-text="stats.active_companies || 0"></div>
                <div class="stat-label">Entreprises actives</div>
                <div class="stat-change">
                    <div class="status-dot"></div>
                    <span>En ligne</span>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number" x-text="stats.total_users || 0"></div>
                <div class="stat-label">Utilisateurs totaux</div>
                <div class="stat-change positive">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>+25%</span>
                </div>
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-number" x-text="stats.super_admins || {{ \App\Models\User::where('global_role', 'super_admin')->count() }}"></div>
                <div class="stat-label">Super Admins</div>
                <div class="stat-change">
                    <div class="status-dot"></div>
                    <span>Sécurisé</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="section-header">
            <h2 class="section-title">Actions rapides</h2>
            <div class="section-icon">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        <div class="actions-grid">
            <a href="{{ route('super_admin.companies.create') }}" class="action-card primary">
                <div class="action-icon">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span>Nouvelle entreprise</span>
            </a>
            <a href="{{ route('super_admin.companies') }}" class="action-card">
                <div class="action-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span>Voir toutes les entreprises</span>
            </a>
            <a href="{{ route('super_admin.users') }}" class="action-card">
                <div class="action-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <span>Gérer les utilisateurs</span>
            </a>
        </div>
    </div>

    <!-- Recent Companies -->
    <div class="recent-companies">
        <div class="section-header">
            <h2 class="section-title">Entreprises récentes</h2>
            <div class="status-indicator">
                <div class="status-dot"></div>
                <span>Temps réel</span>
            </div>
        </div>
        <div class="companies-list">
            @forelse($recentCompanies as $company)
            <div class="company-card">
                <div class="company-avatar">
                    <span>{{ substr($company->name, 0, 2) }}</span>
                    <div class="online-indicator"></div>
                </div>
                <div class="company-info">
                    <h3 class="company-name">{{ $company->name }}</h3>
                    <div class="company-meta">
                        <span>{{ $company->email }}</span>
                        <span>•</span>
                        <span>{{ $company->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="company-actions">
                    <span class="status-badge {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}">
                        {{ $company->status }}
                    </span>
                    <a href="{{ route('super_admin.companies.show', $company) }}" class="view-btn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="empty-title">Aucune entreprise créée</h3>
                <p class="empty-description">Commencez par ajouter votre première entreprise</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Welcome Section */
.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.welcome-time {
    text-align: right;
}

.time-display {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.time-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
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
    border-radius: 12px;
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
    margin-bottom: 0.5rem;
}

.stat-change {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.stat-change.positive {
    color: var(--success);
}

.stat-change svg {
    width: 16px;
    height: 16px;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: var(--success);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Quick Actions */
.quick-actions {
    margin-bottom: 3rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
}

.section-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-600);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: var(--dark);
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.action-card.primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    color: white;
}

.action-icon {
    width: 48px;
    height: 48px;
    background: var(--gray-100);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-card.primary .action-icon {
    background: rgba(255, 255, 255, 0.2);
}

/* Recent Companies */
.recent-companies {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.companies-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.company-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    transition: background 0.3s ease;
}

.company-card:hover {
    background: var(--gray-50);
}

.company-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
    position: relative;
}

.online-indicator {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 12px;
    height: 12px;
    background: var(--success);
    border: 2px solid white;
    border-radius: 50%;
}

.company-info {
    flex: 1;
}

.company-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.company-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-500);
}

.company-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-badge.active {
    background: var(--success);
    color: white;
}

.status-badge.suspended {
    background: var(--warning);
    color: white;
}

.status-badge.inactive {
    background: var(--gray-200);
    color: var(--gray-600);
}

.view-btn {
    width: 36px;
    height: 36px;
    background: var(--gray-100);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-600);
    transition: all 0.3s ease;
}

.view-btn:hover {
    background: var(--primary);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--gray-500);
}

.empty-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    opacity: 0.3;
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-description {
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-section {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-time {
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
