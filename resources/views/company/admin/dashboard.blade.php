@extends('layouts.enterprise-layout')

@section('title', 'Dashboard - ' . $company->name)

@section('content')
<!-- Enterprise Dashboard Content -->
<style>
    /* Dashboard Specific Styles */
    .dashboard-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }
    
    .overview-card {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .overview-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
        transition: left var(--transition-slow);
    }
    
    .overview-card:hover::before {
        left: 100%;
    }
    
    .overview-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-primary);
    }
    
    .overview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-4);
    }
    
    .overview-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--neutral-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .overview-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        box-shadow: var(--shadow-primary);
    }
    
    .overview-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--neutral-900);
        margin-bottom: var(--space-2);
        font-variant-numeric: tabular-nums;
    }
    
    .overview-change {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .change-positive {
        background: var(--success-50);
        color: var(--success-600);
    }
    
    .change-negative {
        background: var(--error-50);
        color: var(--error-600);
    }
    
    /* Services Management */
    .services-section {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        margin-bottom: var(--space-8);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 1px solid var(--neutral-200);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--neutral-900);
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .section-icon {
        width: 32px;
        height: 32px;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        color: var(--neutral-100);
        border: none;
        border-radius: var(--radius-xl);
        padding: var(--space-3) var(--space-6);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all var(--transition-spring);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
        box-shadow: var(--shadow-md);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-primary);
    }
    
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left var(--transition-slow);
    }
    
    .btn-primary:hover::before {
        left: 100%;
    }
    
    /* Services List */
    .services-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .service-card {
        background: var(--neutral-50);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-xl);
        padding: var(--space-5);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .service-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--gradient-primary);
        transform: scaleY(0);
        transition: transform var(--transition-normal);
        transform-origin: bottom;
    }
    
    .service-card:hover::before {
        transform: scaleY(1);
    }
    
    .service-card:hover {
        transform: translateX(8px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-md);
    }
    
    .service-info {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        flex: 1;
    }
    
    .service-prefix {
        width: 56px;
        height: 56px;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: var(--shadow-md);
    }
    
    .service-details h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--neutral-900);
        margin-bottom: var(--space-1);
    }
    
    .service-meta {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        font-size: 0.875rem;
        color: var(--neutral-600);
    }
    
    .service-meta-item {
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .service-actions {
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid;
    }
    
    .status-active {
        background: var(--success-50);
        color: var(--success-600);
        border-color: var(--success-200);
    }
    
    .status-inactive {
        background: var(--error-50);
        color: var(--error-600);
        border-color: var(--error-200);
    }
    
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: var(--radius-full);
        animation: pulse 2s infinite;
    }
    
    .status-active .status-indicator {
        background: var(--success-500);
    }
    
    .status-inactive .status-indicator {
        background: var(--error-500);
    }
    
    .btn-secondary {
        background: transparent;
        color: var(--primary-600);
        border: 1px solid var(--primary-300);
        border-radius: var(--radius-lg);
        padding: var(--space-2) var(--space-4);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all var(--transition-spring);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
    }
    
    .btn-secondary:hover {
        background: var(--primary-50);
        border-color: var(--primary-400);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
    }
    
    .action-card {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        text-decoration: none;
        color: inherit;
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .action-card::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
        transition: all var(--transition-slow);
        transform: translate(-50%, -50%);
    }
    
    .action-card:hover::before {
        width: 400px;
        height: 400px;
    }
    
    .action-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-lg);
    }
    
    .action-icon {
        width: 64px;
        height: 64px;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        margin-bottom: var(--space-4);
        position: relative;
        z-index: 1;
        transition: all var(--transition-spring);
        box-shadow: var(--shadow-md);
    }
    
    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .action-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--neutral-900);
        margin-bottom: var(--space-2);
        position: relative;
        z-index: 1;
    }
    
    .action-description {
        color: var(--neutral-600);
        font-size: 0.875rem;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: var(--space-12) var(--space-6);
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
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Animations */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.2);
        }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-up {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-overview {
            grid-template-columns: 1fr;
            gap: var(--space-4);
        }
        
        .section-header {
            flex-direction: column;
            gap: var(--space-4);
            align-items: flex-start;
        }
        
        .service-card {
            flex-direction: column;
            gap: var(--space-4);
            align-items: flex-start;
        }
        
        .service-actions {
            width: 100%;
            justify-content: space-between;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Dashboard Overview -->
<div class="dashboard-overview">
    <div class="overview-card animate-slide-up" style="animation-delay: 0.1s;">
        <div class="overview-header">
            <div class="overview-title">Services Actifs</div>
            <div class="overview-icon">
                <i data-lucide="briefcase" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div class="overview-value">{{ $stats['services_count'] }}</div>
        <div class="overview-change change-positive">
            <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
            <span>+12% ce mois</span>
        </div>
    </div>
    
    <div class="overview-card animate-slide-up" style="animation-delay: 0.2s;">
        <div class="overview-header">
            <div class="overview-title">Guichets</div>
            <div class="overview-icon">
                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div class="overview-value">{{ $stats['counters_count'] }}</div>
        <div class="overview-change change-positive">
            <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
            <span>+5% cette semaine</span>
        </div>
    </div>
    
    <div class="overview-card animate-slide-up" style="animation-delay: 0.3s;">
        <div class="overview-header">
            <div class="overview-title">Agents</div>
            <div class="overview-icon">
                <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div class="overview-value">{{ $stats['agents_count'] }}</div>
        <div class="overview-change change-positive">
            <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
            <span>+8% ce mois</span>
        </div>
    </div>
    
    <div class="overview-card animate-slide-up" style="animation-delay: 0.4s;">
        <div class="overview-header">
            <div class="overview-title">Tickets Aujourd'hui</div>
            <div class="overview-icon">
                <i data-lucide="file-text" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div class="overview-value">{{ $stats['tickets_today'] }}</div>
        <div class="overview-change change-negative">
            <i data-lucide="trending-down" style="width: 16px; height: 16px;"></i>
            <span>-3% vs hier</span>
        </div>
    </div>
</div>

<!-- Services Management -->
<section class="services-section animate-slide-up" style="animation-delay: 0.5s;">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon">
                <i data-lucide="briefcase" style="width: 18px; height: 18px;"></i>
            </div>
            Services Actifs
        </div>
        <a href="{{ route('company.admin.services.create', $company) }}" class="btn-primary">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            Nouveau Service
        </a>
    </div>
    
    <div class="services-list">
        @forelse($services as $service)
        <div class="service-card">
            <div class="service-info">
                <div class="service-prefix">{{ $service->prefix }}</div>
                <div class="service-details">
                    <h3>{{ $service->name }}</h3>
                    <div class="service-meta">
                        <div class="service-meta-item">
                            <i data-lucide="file-text" style="width: 14px; height: 14px;"></i>
                            <span>{{ $service->tickets_count }} tickets/jour</span>
                        </div>
                        <div class="service-meta-item">
                            <i data-lucide="clock" style="width: 14px; height: 14px;"></i>
                            <span>{{ $service->estimated_service_time }} min</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="service-actions">
                <div class="status-badge {{ $service->isActive() ? 'status-active' : 'status-inactive' }}">
                    <span class="status-indicator"></span>
                    {{ $service->isActive() ? 'Actif' : 'Inactif' }}
                </div>
                <a href="{{ route('company.admin.services.edit', [$company, $service]) }}" class="btn-secondary">
                    <i data-lucide="edit" style="width: 14px; height: 14px;"></i>
                    Modifier
                </a>
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
        </div>
        @endforelse
    </div>
</section>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="{{ route('company.admin.counters', $company) }}" class="action-card animate-slide-up" style="animation-delay: 0.6s;">
        <div class="action-icon">
            <i data-lucide="users" style="width: 32px; height: 32px;"></i>
        </div>
        <div class="action-title">Guichets</div>
        <div class="action-description">
            Configurez et assignez les agents aux différents guichets de service.
        </div>
    </a>
    
    <a href="{{ route('company.admin.agents', $company) }}" class="action-card animate-slide-up" style="animation-delay: 0.7s;">
        <div class="action-icon">
            <i data-lucide="user-check" style="width: 32px; height: 32px;"></i>
        </div>
        <div class="action-title">Agents</div>
        <div class="action-description">
            Gérez les agents, leurs permissions et leurs plannings de travail.
        </div>
    </a>
    
    <a href="{{ route('company.admin.statistics', $company) }}" class="action-card animate-slide-up" style="animation-delay: 0.8s;">
        <div class="action-icon">
            <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
        </div>
        <div class="action-title">Statistiques</div>
        <div class="action-description">
            Analysez les performances, consultez les rapports et les tendances.
        </div>
    </a>
</div>

<!-- Dashboard JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Re-initialize Lucide icons for dynamic content
    lucide.createIcons();
    
    // Animate numbers on load
    const values = document.querySelectorAll('.overview-value');
    values.forEach((value, index) => {
        const finalValue = parseInt(value.textContent);
        let currentValue = 0;
        const increment = finalValue / 40;
        const delay = index * 100;
        
        setTimeout(() => {
            const counter = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    currentValue = finalValue;
                    clearInterval(counter);
                }
                value.textContent = Math.floor(currentValue);
            }, 25);
        }, delay);
    });
    
    // Add interactive hover effects
    const cards = document.querySelectorAll('.overview-card, .service-card, .action-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = this.style.transform + ' scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            setTimeout(() => {
                this.style.transform = this.style.transform.replace(' scale(1.02)', '');
            }, 150);
        });
    });
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.animate-slide-up').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        observer.observe(el);
    });
});
</script>
@endsection
