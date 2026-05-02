@extends('layouts.enterprise-layout')

@section('title', 'Services - ' . $company->name)

@section('content')
<!-- Enterprise Services Management -->
<style>
    /* Services Page Specific Styles */
    .services-container {
        display: flex;
        flex-direction: column;
        gap: var(--space-8);
    }
    
    .page-header {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-8);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.05), transparent);
        transition: left var(--transition-slow);
    }
    
    .page-header:hover::before {
        left: 100%;
    }
    
    .header-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--neutral-900);
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .page-icon {
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        box-shadow: var(--shadow-primary);
    }
    
    .page-description {
        color: var(--neutral-600);
        font-size: 1rem;
        max-width: 600px;
    }
    
    .btn-create {
        background: var(--gradient-primary);
        color: var(--neutral-100);
        border: none;
        border-radius: var(--radius-xl);
        padding: var(--space-4) var(--space-6);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all var(--transition-spring);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }
    
    .btn-create::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left var(--transition-slow);
    }
    
    .btn-create:hover::before {
        left: 100%;
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-primary);
    }
    
    /* Services Table */
    .services-table {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    
    .table-header {
        background: var(--neutral-50);
        border-bottom: 1px solid var(--neutral-200);
        padding: var(--space-4) var(--space-6);
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr 120px;
        align-items: center;
        gap: var(--space-4);
    }
    
    .table-header-cell {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--neutral-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .table-row {
        padding: var(--space-4) var(--space-6);
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr 120px;
        align-items: center;
        gap: var(--space-4);
        border-bottom: 1px solid var(--neutral-200);
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .table-row::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform var(--transition-normal);
        transform-origin: left;
    }
    
    .table-row:hover::before {
        transform: scaleX(1);
    }
    
    .table-row:hover {
        background: var(--neutral-50);
        transform: translateX(4px);
    }
    
    .table-row:last-child {
        border-bottom: none;
    }
    
    .service-info {
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .service-prefix {
        width: 48px;
        height: 48px;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        font-weight: 700;
        font-size: 1.125rem;
        box-shadow: var(--shadow-md);
    }
    
    .service-details {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }
    
    .service-name {
        font-weight: 700;
        color: var(--neutral-900);
        font-size: 0.875rem;
    }
    
    .service-description {
        color: var(--neutral-600);
        font-size: 0.75rem;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .table-cell {
        color: var(--neutral-700);
        font-size: 0.875rem;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid;
    }
    
    .badge-primary {
        background: var(--primary-50);
        color: var(--primary-600);
        border-color: var(--primary-200);
    }
    
    .badge-success {
        background: var(--success-50);
        color: var(--success-600);
        border-color: var(--success-200);
    }
    
    .badge-error {
        background: var(--error-50);
        color: var(--error-600);
        border-color: var(--error-200);
    }
    
    .badge-neutral {
        background: var(--neutral-100);
        color: var(--neutral-600);
        border-color: var(--neutral-300);
    }
    
    .table-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: var(--space-2);
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-lg);
        border: 1px solid var(--neutral-300);
        background: var(--neutral-100);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-spring);
        color: var(--neutral-600);
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: var(--neutral-50);
        border-color: var(--primary-300);
        color: var(--primary-600);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    
    .action-btn.delete:hover {
        background: var(--error-50);
        border-color: var(--error-300);
        color: var(--error-600);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: var(--space-16) var(--space-8);
        color: var(--neutral-500);
    }
    
    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto var(--space-6);
        background: var(--neutral-100);
        border-radius: var(--radius-2xl);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--neutral-200);
        color: var(--neutral-400);
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin-bottom: var(--space-2);
    }
    
    .empty-description {
        color: var(--neutral-500);
        margin-bottom: var(--space-4);
    }
    
    .empty-link {
        color: var(--primary-600);
        text-decoration: none;
        font-weight: 600;
        transition: color var(--transition-fast);
    }
    
    .empty-link:hover {
        color: var(--primary-700);
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        padding: var(--space-6);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .table-header,
        .table-row {
            grid-template-columns: 2fr 1fr 1fr 120px;
        }
        
        .table-header-cell:nth-child(3),
        .table-header-cell:nth-child(4),
        .table-row > div:nth-child(3),
        .table-row > div:nth-child(4) {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: var(--space-4);
            align-items: flex-start;
        }
        
        .btn-create {
            width: 100%;
            justify-content: center;
        }
        
        .table-header,
        .table-row {
            grid-template-columns: 1fr;
            gap: var(--space-2);
        }
        
        .table-header-cell,
        .table-row > div {
            display: none;
        }
        
        .table-row {
            padding: var(--space-4);
        }
        
        .service-info {
            display: flex;
        }
        
        .table-row > div:first-child {
            display: flex;
        }
        
        .table-row > div:last-child {
            display: flex;
            justify-content: flex-end;
            margin-top: var(--space-2);
        }
    }
</style>

<div class="services-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="page-title">
                <div class="page-icon">
                    <i data-lucide="briefcase" style="width: 20px; height: 20px;"></i>
                </div>
                Services
            </div>
            <p class="page-description">
                Gérez les services disponibles dans votre entreprise et configurez leurs paramètres.
            </p>
        </div>
        <a href="{{ route('company.admin.services.create', $company) }}" class="btn-create">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            Nouveau Service
        </a>
    </div>

    <!-- Services Table -->
    <div class="services-table">
        <div class="table-header">
            <div class="table-header-cell">Service</div>
            <div class="table-header-cell">Préfixe</div>
            <div class="table-header-cell">Temps estimé</div>
            <div class="table-header-cell">Guichets</div>
            <div class="table-header-cell">Statut</div>
            <div class="table-header-cell">Actions</div>
        </div>
        
        @forelse($services as $service)
        <div class="table-row">
            <div>
                <div class="service-info">
                    <div class="service-prefix">{{ $service->prefix }}</div>
                    <div class="service-details">
                        <div class="service-name">{{ $service->name }}</div>
                        @if($service->description)
                            <div class="service-description">{{ Str::limit($service->description, 50) }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="table-cell">{{ $service->prefix }}</div>
            <div class="table-cell">{{ $service->estimated_service_time }} min</div>
            <div class="table-cell">
                <span class="badge badge-primary">
                    {{ $service->counters_count ?? 0 }}
                </span>
            </div>
            <div>
                <span class="badge {{ $service->isActive() ? 'badge-success' : 'badge-error' }}">
                    <span style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                    {{ $service->isActive() ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            <div>
                <div class="table-actions">
                    <a href="{{ route('company.admin.services.edit', [$company, $service]) }}" class="action-btn">
                        <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                    </a>
                    <form action="{{ route('company.admin.services.destroy', [$company, $service]) }}" method="POST" onsubmit="return confirm('Supprimer ce service ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete">
                            <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i data-lucide="inbox" style="width: 48px; height: 48px;"></i>
            </div>
            <div class="empty-title">Aucun service configuré</div>
            <div class="empty-description">
                Commencez par créer votre premier service pour gérer efficacement vos files d'attente.
            </div>
            <a href="{{ route('company.admin.services.create', $company) }}" class="empty-link">
                Créer un service
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
    <div class="pagination-container">
        {{ $services->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Re-initialize Lucide icons
    lucide.createIcons();
    
    // Add row hover effects
    const rows = document.querySelectorAll('.table-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(4px)';
        });
    });
});
</script>
@endsection
