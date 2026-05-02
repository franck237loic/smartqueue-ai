@extends('layouts.super-admin')

@section('title', 'Super Admin - Utilisateurs')

@section('content')
<div class="users-container">
    <!-- Header Section -->
    <div class="users-header">
        <div class="header-content">
            <h1 class="page-title">Gestion des Utilisateurs</h1>
            <p class="page-subtitle">{{ $users->total() }} utilisateurs sur la plateforme</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <div class="search-input-wrapper">
                    <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Rechercher par nom ou email..." value="{{ request('search') }}" class="search-input">
                </div>
            </div>
            <div class="filter-group">
                <select name="role" class="filter-select">
                    <option value="">Tous les rôles</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="company_admin" {{ request('role') === 'company_admin' ? 'selected' : '' }}>Admin Entreprise</option>
                    <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
        </form>
    </div>

    <!-- Users Grid -->
    <div class="users-grid">
        @forelse($users as $user)
        <div class="user-card">
            <div class="user-header">
                <div class="user-avatar">
                    <span>{{ substr($user->name, 0, 2) }}</span>
                    <div class="role-indicator {{ $user->global_role === 'super_admin' ? 'super-admin' : ($user->global_role === 'company_admin' ? 'admin' : 'agent') }}"></div>
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                </div>
                <div class="user-badges">
                    <span class="badge role-badge {{ $user->global_role === 'super_admin' ? 'super-admin' : ($user->global_role === 'company_admin' ? 'admin' : 'agent') }}">
                        {{ $user->global_role === 'super_admin' ? 'Super Admin' : ($user->global_role === 'company_admin' ? 'Admin' : 'Agent') }}
                    </span>
                </div>
            </div>

            <div class="user-details">
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ $user->companies_count }} entreprises</span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    @if($user->currentCompany)
                        <span>{{ $user->currentCompany->name }}</span>
                    @else
                        <span class="text-muted">Aucune entreprise active</span>
                    @endif
                </div>
            </div>

            <div class="user-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $user->companies_count ?? 0 }}</div>
                    <div class="stat-label">Entreprises</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $user->global_role === 'super_admin' ? '∞' : '1' }}</div>
                    <div class="stat-label">Permissions</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $user->created_at->format('Y') }}</div>
                    <div class="stat-label">Année</div>
                </div>
            </div>

            <div class="user-actions">
                @if($user->global_role !== 'super_admin')
                <form action="{{ route('super_admin.users.make-super-admin', $user) }}" method="POST" class="inline" onsubmit="return confirm('Promouvoir cet utilisateur en Super Admin ?')">
                    @csrf
                    <button type="submit" class="action-btn promote-btn" title="Promouvoir Super Admin">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l5.414 5.414a1 1 0 010 1.414l-5.414 5.414a1 1 0 01-1.414 0L10 14.586V8a2 2 0 012-2z"/>
                        </svg>
                        Promouvoir
                    </button>
                </form>
                @else
                <div class="action-btn super-admin-btn">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15l-2-2m0 0l-2 2m2-2v6m-1 1H8a2 2 0 01-2-2V8a2 2 0 012-2h4a2 2 0 012 2v6m-1 1h2a2 2 0 002-2V8a2 2 0 00-2-2h-4a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    Super Admin
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="empty-title">Aucun utilisateur trouvé</h3>
            <p class="empty-description">Aucun utilisateur ne correspond à vos critères de recherche</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
</div>

<style>
.users-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
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

/* Filters Section */
.filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.filters-form {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 250px;
}

.search-input-wrapper {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    pointer-events: none;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: var(--gray-50);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background: white;
}

.filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 0.9rem;
    background: var(--gray-50);
    transition: all 0.3s ease;
    cursor: pointer;
}

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

/* Users Grid */
.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.user-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.user-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: var(--primary);
}

.user-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.user-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    position: relative;
    flex-shrink: 0;
}

.role-indicator {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 12px;
    height: 12px;
    border: 2px solid white;
    border-radius: 50%;
}

.role-indicator.super-admin {
    background: var(--error);
}

.role-indicator.admin {
    background: var(--warning);
}

.role-indicator.agent {
    background: var(--success);
}

.user-info {
    flex: 1;
}

.user-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.user-email {
    font-size: 0.8rem;
    color: var(--gray-500);
    font-family: monospace;
}

.user-badges {
    display: flex;
    gap: 0.5rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: capitalize;
}

.badge.role-badge.super-admin {
    background: var(--error);
    color: white;
}

.badge.role-badge.admin {
    background: var(--warning);
    color: white;
}

.badge.role-badge.agent {
    background: var(--success);
    color: white;
}

.user-details {
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-600);
}

.detail-icon {
    color: var(--primary);
    flex-shrink: 0;
}

.text-muted {
    color: var(--gray-400);
}

.user-stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 1rem 0;
    border-top: 1px solid var(--gray-200);
    border-bottom: 1px solid var(--gray-200);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.user-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: auto;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 600;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.promote-btn {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
    color: white;
}

.promote-btn:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.super-admin-btn {
    background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
    color: white;
    cursor: default;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.5rem;
    color: var(--gray-300);
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--gray-500);
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 0.5rem;
}

.pagination-wrapper .pagination a,
.pagination-wrapper .pagination span {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination-wrapper .pagination a {
    background: white;
    color: var(--primary);
    border: 1px solid var(--gray-200);
}

.pagination-wrapper .pagination a:hover {
    background: var(--primary);
    color: white;
}

.pagination-wrapper .pagination span.active {
    background: var(--primary);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .users-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .filter-group {
        min-width: auto;
    }
    
    .users-grid {
        grid-template-columns: 1fr;
    }
    
    .user-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
}
</style>
@endsection
