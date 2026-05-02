@extends('layouts.enterprise-layout')

@section('title', 'Statistiques - ' . $company->name)

@section('content')
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Enterprise Statistics Dashboard -->
<style>
    /* Statistics Page Specific Styles */
    .statistics-container {
        display: flex;
        flex-direction: column;
        gap: var(--space-8);
    }
    
    .page-header {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-8);
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
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
    }
    
    .stat-card {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
        transition: left var(--transition-slow);
    }
    
    .stat-card:hover::before {
        left: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-primary);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-4);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        box-shadow: var(--shadow-md);
    }
    
    .stat-icon.primary {
        background: var(--gradient-primary);
    }
    
    .stat-icon.success {
        background: var(--gradient-success);
    }
    
    .stat-icon.error {
        background: var(--gradient-error);
    }
    
    .stat-icon.warning {
        background: var(--gradient-warning);
    }
    
    .stat-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--neutral-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--neutral-900);
        font-variant-numeric: tabular-nums;
    }
    
    .stat-change {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: var(--space-2);
    }
    
    .change-positive {
        background: var(--success-50);
        color: var(--success-600);
    }
    
    .change-negative {
        background: var(--error-50);
        color: var(--error-600);
    }
    
    .change-neutral {
        background: var(--neutral-100);
        color: var(--neutral-600);
    }
    
    /* Performance Section */
    .performance-section {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-8);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-8);
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
    
    .performance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
    }
    
    .performance-card {
        background: var(--neutral-50);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        text-align: center;
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
    }
    
    .performance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform var(--transition-normal);
        transform-origin: left;
    }
    
    .performance-card:hover::before {
        transform: scaleX(1);
    }
    
    .performance-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-md);
    }
    
    .performance-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--neutral-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: var(--space-4);
    }
    
    .performance-value {
        font-size: 3rem;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        margin-bottom: var(--space-2);
    }
    
    .performance-value.success {
        color: var(--success-600);
    }
    
    .performance-value.error {
        color: var(--error-600);
    }
    
    .performance-value.primary {
        color: var(--primary-600);
    }
    
    .performance-description {
        font-size: 0.875rem;
        color: var(--neutral-600);
    }
    
    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: var(--space-6);
    }
    
    .chart-card {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        transition: all var(--transition-spring);
    }
    
    .chart-card:hover {
        transform: translateY(-2px);
        border-color: var(--primary-300);
        box-shadow: var(--shadow-md);
    }
    
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 1px solid var(--neutral-200);
    }
    
    .chart-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--neutral-900);
    }
    
    .chart-period {
        display: flex;
        align-items: center;
    }
    
    .period-select {
        padding: var(--space-2) var(--space-3);
        border: 1px solid var(--neutral-300);
        border-radius: var(--radius-md);
        background: var(--neutral-100);
        color: var(--neutral-700);
        font-size: 0.875rem;
        cursor: pointer;
        transition: all var(--transition-fast);
    }
    
    .period-select:hover {
        border-color: var(--primary-400);
        background: var(--neutral-200);
    }
    
    .period-select:focus {
        outline: none;
        border-color: var(--primary-500);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .chart-container canvas {
        max-height: 300px;
        width: 100% !important;
    }
    
    /* Animations */
    @keyframes slideUp {
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
        animation: slideUp 0.6s ease-out forwards;
    }
    
    /* KPIs Section */
    .kpi-section {
        margin-bottom: var(--space-8);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--neutral-200);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--neutral-900);
    }
    
    .section-description {
        color: var(--neutral-600);
        font-size: 0.875rem;
    }
    
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
    }
    
    .kpi-card {
        background: white;
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        transition: all var(--transition-spring);
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-500), var(--primary-300));
        transform: scaleX(0);
        transition: transform var(--transition-spring);
    }
    
    .kpi-card:hover::before {
        transform: scaleX(1);
    }
    
    .kpi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-300);
    }
    
    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-4);
    }
    
    .kpi-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .kpi-trend {
        display: flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-lg);
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .kpi-trend.positive {
        background: var(--success-50);
        color: var(--success-600);
    }
    
    .kpi-trend.negative {
        background: var(--error-50);
        color: var(--error-600);
    }
    
    .kpi-content {
        text-align: center;
    }
    
    .kpi-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--neutral-900);
        margin-bottom: var(--space-2);
        line-height: 1;
    }
    
    .kpi-label {
        color: var(--neutral-700);
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: var(--space-1);
    }
    
    .kpi-description {
        color: var(--neutral-500);
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .charts-section {
            grid-template-columns: 1fr;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="statistics-container">
    <!-- Page Header -->
    <div class="page-header animate-slide-up">
        <div class="header-content">
            <h1 class="page-title">
                <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
                Statistiques de {{ $company->name }}
            </h1>
            <p class="page-subtitle">Vue d'ensemble des performances et indicateurs clés</p>
        </div>
    </div>

    <!-- KPIs Section -->
    <section class="kpi-section">
        <div class="section-header">
            <div class="section-title">Indicateurs Clés</div>
            <div class="section-description">Vue d'ensemble des performances</div>
        </div>
        
        <div class="kpi-grid">
            <div class="kpi-card animate-slide-up" style="animation-delay: 0.1s;">
                <div class="kpi-header">
                    <div class="kpi-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="kpi-trend positive">
                        <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
                        +12.5%
                    </div>
                </div>
                <div class="kpi-content">
                    <div class="kpi-value animate-count">1,247</div>
                    <div class="kpi-label">Total Clients</div>
                    <div class="kpi-description">Actifs ce mois</div>
                </div>
            </div>

            <div class="kpi-card animate-slide-up" style="animation-delay: 0.2s;">
                <div class="kpi-header">
                    <div class="kpi-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i data-lucide="ticket" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="kpi-trend positive">
                        <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
                        +8.3%
                    </div>
                </div>
                <div class="kpi-content">
                    <div class="kpi-value animate-count">8,543</div>
                    <div class="kpi-label">Tickets Créés</div>
                    <div class="kpi-description">7 derniers jours</div>
                </div>
            </div>

            <div class="kpi-card animate-slide-up" style="animation-delay: 0.3s;">
                <div class="kpi-header">
                    <div class="kpi-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="kpi-trend positive">
                        <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
                        +15.7%
                    </div>
                </div>
                <div class="kpi-content">
                    <div class="kpi-value animate-count">7,892</div>
                    <div class="kpi-label">Tickets Résolus</div>
                    <div class="kpi-description">7 derniers jours</div>
                </div>
            </div>

            <div class="kpi-card animate-slide-up" style="animation-delay: 0.4s;">
                <div class="kpi-header">
                    <div class="kpi-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                        <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="kpi-trend negative">
                        <i data-lucide="trending-down" style="width: 16px; height: 16px;"></i>
                        -3.2%
                    </div>
                </div>
                <div class="kpi-content">
                    <div class="kpi-value animate-count">24.5</div>
                    <div class="kpi-label">Temps Moyen</div>
                    <div class="kpi-description">Minutes par ticket</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-card animate-slide-up" style="animation-delay: 0.5s;">
            <div class="chart-header">
                <div class="chart-title">Évolution des Tickets</div>
                <div class="chart-period">
                    <select id="periodSelect" class="period-select">
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="90">90 derniers jours</option>
                    </select>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>

        <div class="chart-card animate-slide-up" style="animation-delay: 0.6s;">
            <div class="chart-header">
                <div class="chart-title">Répartition par Service</div>
            </div>
            <div class="chart-container">
                <canvas id="serviceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    initializeCharts();
    
    const periodSelect = document.getElementById('periodSelect');
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            updateEvolutionChart(this.value);
        });
    }
    
    animateNumbers();
});

function initializeCharts() {
    const evolutionCtx = document.getElementById('evolutionChart');
    if (evolutionCtx) {
        window.evolutionChart = new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: generateDateLabels(7),
                datasets: [{
                    label: 'Tickets Créés',
                    data: [45, 52, 38, 65, 72, 58, 61],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Tickets Résolus',
                    data: [38, 45, 32, 58, 68, 52, 55],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
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
    
    const serviceCtx = document.getElementById('serviceChart');
    if (serviceCtx) {
        window.serviceChart = new Chart(serviceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Service Client', 'Support Technique', 'Comptabilité', 'Ressources Humaines', 'Marketing'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
}

function generateDateLabels(days) {
    const labels = [];
    const today = new Date();
    
    for (let i = days - 1; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - i);
        labels.push(date.toLocaleDateString('fr-FR', { month: 'short', day: 'numeric' }));
    }
    
    return labels;
}

function updateEvolutionChart(days) {
    if (!window.evolutionChart) return;
    
    window.evolutionChart.data.labels = generateDateLabels(days);
    window.evolutionChart.data.datasets[0].data = generateRandomData(days, 20, 80);
    window.evolutionChart.data.datasets[1].data = generateRandomData(days, 15, 70);
    window.evolutionChart.update();
}

function generateRandomData(count, min, max) {
    const data = [];
    for (let i = 0; i < count; i++) {
        data.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    return data;
}

function animateNumbers() {
    const elements = document.querySelectorAll('.animate-count');
    elements.forEach((element, index) => {
        const text = element.textContent;
        const finalValue = parseInt(text.replace(/[^0-9]/g, ''));
        const suffix = text.replace(/[0-9]/g, '');
        
        if (finalValue > 0) {
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
                    element.textContent = Math.floor(currentValue) + suffix;
                }, 30);
            }, delay);
        }
    });
}
</script>
@endsection
