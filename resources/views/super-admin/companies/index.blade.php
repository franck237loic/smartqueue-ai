@extends('layouts.super-admin')

@section('title', 'Super Admin - Entreprises')

@section('content')
<div class="companies-container">
    <!-- Header Section -->
    <div class="companies-header">
        <div class="header-content">
            <h1 class="page-title">Gestion des Entreprises</h1>
            <p class="page-subtitle">{{ $companies->total() }} entreprises sur la plateforme</p>
        </div>
        <a href="{{ route('super_admin.companies.create') }}" class="btn-create">
            <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle entreprise
        </a>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <div class="search-input-wrapper">
                    <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Rechercher une entreprise..." value="{{ request('search') }}" class="search-input">
                </div>
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendue</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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

    <!-- Companies Grid -->
    <div class="companies-grid">
        @forelse($companies as $company)
        <div class="company-card">
            <div class="company-header">
                <div class="company-avatar">
                    <span>{{ substr($company->name, 0, 2) }}</span>
                    <div class="status-indicator {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}"></div>
                </div>
                <div class="company-info">
                    <h3 class="company-name">{{ $company->name }}</h3>
                    <p class="company-slug">{{ $company->slug }}</p>
                </div>
                <div class="company-badges">
                    <span class="badge status-badge {{ $company->status === 'active' ? 'active' : ($company->status === 'suspended' ? 'suspended' : 'inactive') }}">
                        {{ $company->status }}
                    </span>
                </div>
            </div>

            <div class="company-details">
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $company->email }}</span>
                </div>
                @if($company->phone)
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $company->phone }}</span>
                </div>
                @endif
            </div>

            <div class="company-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $company->users_count ?? 0 }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $company->services_count ?? 0 }}</div>
                    <div class="stat-label">Services</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $company->counters_count ?? 0 }}</div>
                    <div class="stat-label">Guichets</div>
                </div>
            </div>

            <div class="company-actions">
                <a href="{{ route('super_admin.companies.show', $company) }}" class="action-btn view-btn" title="Voir détails">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>
                <a href="{{ route('super_admin.companies.edit', $company) }}" class="action-btn edit-btn" title="Modifier">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                <form action="{{ route('super_admin.companies.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette entreprise ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-btn" title="Supprimer">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="empty-title">Aucune entreprise trouvée</h3>
            <p class="empty-description">Commencez par créer votre première entreprise</p>
            <a href="{{ route('super_admin.companies.create') }}" class="btn-create">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Créer une entreprise
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $companies->links() }}
    </div>
</div>

<style>
.companies-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.companies-header {
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

.btn-create {
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

.btn-create:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
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

/* Companies Grid */
.companies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.company-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.company-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: var(--primary);
}

.company-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.company-avatar {
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

.status-indicator {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 12px;
    height: 12px;
    border: 2px solid white;
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
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.company-slug {
    font-size: 0.8rem;
    color: var(--gray-500);
    font-family: monospace;
}

.company-badges {
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

.badge.status-badge.active {
    background: var(--success);
    color: white;
}

.badge.status-badge.suspended {
    background: var(--warning);
    color: white;
}

.badge.status-badge.inactive {
    background: var(--gray-200);
    color: var(--gray-600);
}

.company-details {
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

.company-stats {
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

.company-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.view-btn {
    background: var(--success);
    color: white;
}

.view-btn:hover {
    background: #059669;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.edit-btn {
    background: var(--primary);
    color: white;
}

.edit-btn:hover {
    background: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.delete-btn {
    background: var(--error);
    color: white;
}

.delete-btn:hover {
    background: #dc2626;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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
    .companies-header {
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
    
    .companies-grid {
        grid-template-columns: 1fr;
    }
    
    .company-stats {
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
