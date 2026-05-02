@extends('layouts.enterprise-layout')

@section('title', 'Guichets - ' . $company->name)

@section('content')
<!-- Enterprise Counters Management -->
<style>
    /* Counters Page Specific Styles */
    .counters-container {
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
    
    /* Counters Table */
    .counters-table {
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
        grid-template-columns: 2fr 1fr 1.5fr 1fr 120px;
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
        grid-template-columns: 2fr 1fr 1.5fr 1fr 120px;
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
    
    .counter-info {
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .counter-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-success);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        box-shadow: var(--shadow-md);
    }
    
    .counter-details {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }
    
    .counter-name {
        font-weight: 700;
        color: var(--neutral-900);
        font-size: 0.875rem;
    }
    
    .counter-number {
        color: var(--neutral-600);
        font-size: 0.75rem;
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
    
    .agent-info {
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }
    
    .agent-avatar {
        width: 32px;
        height: 32px;
        background: var(--gradient-secondary);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        font-weight: 700;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
    }
    
    .agent-name {
        font-weight: 600;
        color: var(--neutral-900);
        font-size: 0.875rem;
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
        .table-row > div:nth-child(3) {
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
        
        .counter-info {
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

<div class="counters-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="page-title">
                <div class="page-icon">
                    <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                </div>
                Guichets
            </div>
            <p class="page-description">
                Gérez les guichets de service et assignez les agents pour optimiser le flux de travail.
            </p>
        </div>
        <a href="{{ route('company.admin.counters.create', $company) }}" class="btn-create">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            Nouveau Guichet
        </a>
    </div>

    <!-- Counters Table -->
    <div class="counters-table">
        <div class="table-header">
            <div class="table-header-cell">Guichet</div>
            <div class="table-header-cell">Service</div>
            <div class="table-header-cell">Agent assigné</div>
            <div class="table-header-cell">Statut</div>
            <div class="table-header-cell">Actions</div>
        </div>
        
        @forelse($counters as $counter)
        <div class="table-row">
            <div>
                <div class="counter-info">
                    <div class="counter-icon">
                        <i data-lucide="building" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="counter-details">
                        <div class="counter-name">{{ $counter->name }}</div>
                        @if($counter->number)
                            <div class="counter-number">N° {{ $counter->number }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                @if($counter->service)
                    <span class="badge badge-primary">
                        {{ $counter->service->name }}
                    </span>
                @else
                    <span class="badge badge-neutral">-</span>
                @endif
            </div>
            <div>
                @php
                    // Récupérer l'agent assigné via company_user
                    $assignedUser = null;
                    if ($counter->id) {
                        $companyUser = \Illuminate\Support\Facades\DB::table('company_user')
                            ->where('company_id', $company->id)
                            ->where('counter_id', $counter->id)
                            ->first();
                        if ($companyUser) {
                            $assignedUser = \App\Models\User::find($companyUser->user_id);
                        }
                    }
                @endphp
                @if($assignedUser)
                    <div class="agent-info">
                        <div class="agent-avatar">
                            {{ substr($assignedUser->name, 0, 1) }}
                        </div>
                        <div class="agent-name">{{ $assignedUser->name }}</div>
                    </div>
                @else
                    <span class="badge badge-neutral">Non assigné</span>
                @endif
            </div>
            <div>
                @if($counter->status === 'open')
                    <span class="badge badge-success">
                        <span style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                        Ouvert
                    </span>
                @else
                    <span class="badge badge-error">
                        <span style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                        Fermé
                    </span>
                @endif
            </div>
            <div>
                <div class="table-actions">
                    <a href="{{ route('company.admin.counters.edit', [$company, $counter]) }}" class="action-btn">
                        <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                    </a>
                    <form action="{{ route('company.admin.counters.destroy', [$company, $counter]) }}" method="POST" onsubmit="return confirm('Supprimer ce guichet ?')">
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
                <i data-lucide="users" style="width: 48px; height: 48px;"></i>
            </div>
            <div class="empty-title">Aucun guichet configuré</div>
            <div class="empty-description">
                Créez des guichets pour organiser efficacement le service client.
            </div>
            <a href="{{ route('company.admin.counters.create', $company) }}" class="empty-link">
                Créer un guichet
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($counters->hasPages())
    <div class="pagination-container">
        {{ $counters->links() }}
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
