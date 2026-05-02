@extends('layouts.enterprise-layout')

@section('title', 'Agents - ' . $company->name)

@section('content')
<!-- Modern Agents Dashboard -->
<style>
    /* Clean Modern Design System */
    .agents-dashboard {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    /* Header Section */
    .header-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }
    
    .header-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    
    .header-subtitle {
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .btn-primary {
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
    }
    
    .stat-icon.blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }
    
    .stat-icon.green {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .stat-icon.orange {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    /* Agents Grid */
    .agents-section {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    
    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    
    .search-box {
        position: relative;
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        width: 16px;
        height: 16px;
    }
    
    /* Agents List */
    .agents-list {
        padding: 1rem;
    }
    
    .agent-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    
    .agent-card:last-child {
        margin-bottom: 0;
    }
    
    .agent-card:hover {
        background: white;
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
    
    .agent-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .agent-avatar {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        position: relative;
    }
    
    .status-dot {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .status-online {
        background: #10b981;
    }
    
    .status-offline {
        background: #6b7280;
    }
    
    .agent-info {
        flex: 1;
    }
    
    .agent-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 1.125rem;
        margin-bottom: 0.25rem;
    }
    
    .agent-email {
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .agent-role {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .role-admin {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .role-agent {
        background: #f3f4f6;
        color: #374151;
    }
    
    .agent-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .detail-icon {
        width: 16px;
        height: 16px;
        color: #9ca3af;
    }
    
    .agent-actions {
        display: flex;
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .action-btn {
        flex: 1;
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    .action-btn.danger:hover {
        background: #fef2f2;
        border-color: #ef4444;
        color: #ef4444;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #f3f4f6;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
    
    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .empty-description {
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 1rem;
    }
    
    .modal {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .modal-icon {
        width: 48px;
        height: 48px;
        background: #3b82f6;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .modal-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    
    .modal-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
    }
    
    .modal-content {
        margin-bottom: 1.5rem;
    }
    
    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    
    .agent-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .detail-group {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    
    .detail-value {
        font-weight: 600;
        color: #1f2937;
    }
    
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .role-badge.admin {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .role-badge.agent {
        background: #f3f4f6;
        color: #374151;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #10b981;
        color: white;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: 1px solid;
    }
    
    .btn-primary {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        border-color: #2563eb;
    }
    
    .btn-secondary {
        background: white;
        color: #6b7280;
        border-color: #d1d5db;
    }
    
    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: #374151;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .agents-dashboard {
            padding: 1rem;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .search-box {
            width: 100%;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .agent-details {
            grid-template-columns: 1fr;
        }
        
        .agent-actions {
            flex-direction: column;
        }
    }
</style>

<div class="agents-dashboard">
    <!-- Header -->
    <header class="header-section fade-in-up">
        <div class="header-content">
            <div>
                <h1 class="header-title">Gestion des Agents</h1>
                <p class="header-subtitle">Gérez les agents de votre entreprise et leurs assignations</p>
            </div>
            <a href="{{ route('company.admin.agents.create', $company) }}" class="btn-primary">
                <i data-lucide="plus" style="width: 20px; height: 20px;"></i>
                Nouvel Agent
            </a>
        </div>
    </header>

    <!-- Stats Overview -->
    <div class="stats-grid fade-in-up" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="stat-value">{{ $agents->count() }}</div>
            <div class="stat-label">Total Agents</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="stat-value">{{ $agents->where('pivot.role', 'company_admin')->count() }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i data-lucide="map-pin" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="stat-value">{{ $agents->whereNotNull('pivot.counter_id')->count() }}</div>
            <div class="stat-label">Assignés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i data-lucide="activity" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="stat-value">{{ $agents->whereNull('pivot.counter_id')->count() }}</div>
            <div class="stat-label">Disponibles</div>
        </div>
    </div>

    <!-- Agents Section -->
    <section class="agents-section fade-in-up" style="animation-delay: 0.2s;">
        <div class="section-header">
            <h2 class="section-title">Liste des Agents</h2>
            <div class="search-box">
                <i data-lucide="search" class="search-icon"></i>
                <input type="text" class="search-input" placeholder="Rechercher un agent..." id="searchInput">
            </div>
        </div>

        <div class="agents-list">
            @forelse($agents as $agent)
            <div class="agent-card fade-in-up" style="animation-delay: 0.3s;" data-name="{{ strtolower($agent->name) }}">
                <div class="agent-header">
                    <div class="agent-avatar">
                        {{ substr($agent->name, 0, 1) }}
                        <div class="status-dot status-online"></div>
                    </div>
                    <div class="agent-info">
                        <div class="agent-name">{{ $agent->name }}</div>
                        <div class="agent-email">{{ $agent->email }}</div>
                        <div class="agent-role {{ $agent->pivot->role === 'company_admin' ? 'role-admin' : 'role-agent' }}">
                            <i data-lucide="{{ $agent->pivot->role === 'company_admin' ? 'shield' : 'user' }}" style="width: 12px; height: 12px;"></i>
                            {{ $agent->pivot->role === 'company_admin' ? 'Administrateur' : 'Agent' }}
                        </div>
                    </div>
                </div>

                <div class="agent-details">
                    <div class="detail-item">
                        <i data-lucide="calendar" class="detail-icon"></i>
                        <span>Membre depuis le {{ $agent->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <i data-lucide="map-pin" class="detail-icon"></i>
                        @if($agent->pivot->counter_id)
                            @php
                                $counter = $company->counters()->find($agent->pivot->counter_id);
                            @endphp
                            @if($counter)
                                <span>Guichet: {{ $counter->name }}</span>
                            @else
                                <span>Guichet non trouvé</span>
                            @endif
                        @else
                            <span>Non assigné</span>
                        @endif
                    </div>
                    <div class="detail-item">
                        <i data-lucide="activity" class="detail-icon"></i>
                        <span>Actif</span>
                    </div>
                </div>

                <div class="agent-actions">
                    <button class="action-btn view-agent-btn" 
                        data-agent-id="{{ $agent->id }}">
                        <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
                        Voir
                    </button>
                    <a href="{{ route('company.admin.agents.edit', [$company, $agent]) }}" class="action-btn">
                        <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                        Modifier
                    </a>
                    <form action="{{ route('company.admin.agents.destroy', [$company, $agent]) }}" method="POST" onsubmit="return confirm('Retirer cet agent ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn danger">
                            <i data-lucide="user-x" style="width: 16px; height: 16px;"></i>
                            Retirer
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="users" style="width: 40px; height: 40px;"></i>
                </div>
                <div class="empty-title">Aucun agent</div>
                <div class="empty-description">
                    Aucun agent n'a été ajouté à cette entreprise. Commencez par ajouter votre premier agent.
                </div>
                <a href="{{ route('company.admin.agents.create', $company) }}" class="btn-primary">
                    <i data-lucide="plus" style="width: 20px; height: 20px;"></i>
                    Ajouter un agent
                </a>
            </div>
            @endforelse
        </div>
    </section>
</div>

<!-- Agent Details Modal -->
<div id="agentDetailsModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-icon">
                <i data-lucide="user" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 class="modal-title">Détails de l'Agent</h3>
                <p class="modal-subtitle">Informations complètes</p>
            </div>
        </div>
        
        <div class="modal-content">
            <div class="agent-details-grid">
                <div class="detail-group">
                    <div class="detail-label">Nom Complet</div>
                    <div class="detail-value" id="detail-name"></div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" id="detail-email"></div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">Rôle</div>
                    <div class="detail-value">
                        <span class="role-badge" id="detail-role"></span>
                    </div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">Date de création</div>
                    <div class="detail-value" id="detail-date"></div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">Statut</div>
                    <div class="detail-value">
                        <span class="status-badge">
                            <i data-lucide="check-circle" style="width: 12px; height: 12px;"></i>
                            Actif
                        </span>
                    </div>
                </div>
                
                <div class="detail-group">
                    <div class="detail-label">ID</div>
                    <div class="detail-value" id="detail-id"></div>
                </div>
            </div>
        </div>
        
        <div class="modal-actions">
            <button onclick="hideAgentDetailsModal()" class="btn btn-secondary">
                Fermer
            </button>
            <a href="#" id="edit-agent-link" class="btn btn-primary">
                <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                Modifier
            </a>
        </div>
    </div>
</div>

<script>
// Store agents data globally
window.agentsData = {!! json_encode(collect($agents)->mapWithKeys(function($agent) {
    return [$agent->id => [
        'id' => $agent->id,
        'name' => $agent->name,
        'email' => $agent->email,
        'date' => $agent->created_at->format('d/m/Y'),
        'role' => $agent->pivot->role
    ]];
})->all()) !!};

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const agentCards = document.querySelectorAll('.agent-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        agentCards.forEach(card => {
            const name = card.dataset.name;
            if (name.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Add staggered animation to cards
    agentCards.forEach((card, index) => {
        card.style.animationDelay = `${0.3 + (index * 0.1)}s`;
    });
    
    // Add hover effects to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Agent Details Modal Functions
function showAgentDetails(agentId, name, email, createdDate, role) {
    // Populate modal with agent data
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-email').textContent = email;
    document.getElementById('detail-date').textContent = createdDate;
    document.getElementById('detail-id').textContent = '#' + agentId;
    
    // Set role badge
    const roleElement = document.getElementById('detail-role');
    roleElement.className = 'role-badge ' + (role === 'company_admin' ? 'admin' : 'agent');
    roleElement.innerHTML = `
        <i data-lucide="${role === 'company_admin' ? 'shield' : 'user'}" style="width: 12px; height: 12px;"></i>
        ${role === 'company_admin' ? 'Administrateur' : 'Agent'}
    `;
    
    // Set edit link
    document.getElementById('edit-agent-link').href = `/company/{{ $company->id }}/admin/agents/${agentId}/edit`;
    
    // Show modal
    document.getElementById('agentDetailsModal').style.display = 'flex';
    
    // Re-initialize Lucide icons for the modal
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
}

function hideAgentDetailsModal() {
    document.getElementById('agentDetailsModal').style.display = 'none';
}

// Add event listeners for view buttons
document.addEventListener('click', function(event) {
    // Handle view agent buttons
    if (event.target.closest('.view-agent-btn')) {
        const button = event.target.closest('.view-agent-btn');
        const agentId = button.dataset.agentId;
        const agent = window.agentsData[agentId];
        
        if (agent) {
            showAgentDetails(agent.id, agent.name, agent.email, agent.date, agent.role);
        }
    }
    
    // Close modal when clicking outside
    const modal = document.getElementById('agentDetailsModal');
    if (event.target === modal) {
        hideAgentDetailsModal();
    }
});
</script>
@endsection
