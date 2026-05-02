@extends('layouts.enterprise-layout')

@section('title', 'Modifier Agent - ' . $agent->name)

@section('content')
<!-- Modern Agent Edit -->
<style>
    /* Clean Edit Form Styles */
    .agent-edit-container {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    /* Header Section */
    .header-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    
    .breadcrumb-link {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .breadcrumb-link:hover {
        color: #3b82f6;
    }
    
    .breadcrumb-separator {
        color: #d1d5db;
    }
    
    .breadcrumb-current {
        color: #1f2937;
        font-weight: 600;
    }
    
    .header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .agent-avatar {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2rem;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .header-info {
        flex: 1;
    }
    
    .header-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .header-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }
    
    /* Form Section */
    .form-section {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    
    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    
    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-icon {
        width: 24px;
        height: 24px;
        background: #3b82f6;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .form-content {
        padding: 2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: white;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #9ca3af;
    }
    
    .form-help {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .form-error {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    /* Status Cards */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .status-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .status-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .status-value {
        font-weight: 600;
        color: #1f2937;
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
    
    /* Form Actions */
    .form-actions {
        padding: 2rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
    
    .actions-left {
        display: flex;
        gap: 1rem;
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
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
    
    .btn-danger {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    /* Modal */
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
        max-width: 400px;
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
        background: #fef2f2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
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
        color: #374151;
        margin-bottom: 1.5rem;
    }
    
    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
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
        .agent-edit-container {
            padding: 1rem;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .status-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .actions-left {
            flex-direction: column;
            width: 100%;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="agent-edit-container">
    <!-- Header -->
    <header class="header-section fade-in-up">
        <div class="breadcrumb">
            <a href="{{ route('company.admin.agents', $company) }}" class="breadcrumb-link">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                Agents
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $agent->name }}</span>
        </div>
        
        <div class="header-content">
            <div class="agent-avatar">
                {{ substr($agent->name, 0, 1) }}
            </div>
            <div class="header-info">
                <h1 class="header-title">Modifier l'Agent</h1>
                <p class="header-subtitle">Mettez à jour les informations de {{ $agent->name }}</p>
            </div>
        </div>
    </header>

    <!-- Edit Form -->
    <form method="POST" action="{{ route('company.admin.agents.update', [$company, $agent]) }}" class="form-section fade-in-up" style="animation-delay: 0.1s;">
        @csrf
        @method('PUT')
        
        <!-- Personal Information -->
        <div class="section-header">
            <h2 class="section-title">
                <div class="section-icon">
                    <i data-lucide="user" style="width: 16px; height: 16px;"></i>
                </div>
                Informations Personnelles
            </h2>
        </div>
        
        <div class="form-content">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        Nom Complet <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ $agent->name }}" 
                        required
                        class="form-input"
                        placeholder="Entrez le nom complet"
                    >
                    <div class="form-help">Nom et prénom de l'agent</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ $agent->email }}" 
                        required
                        class="form-input"
                        placeholder="agent@entreprise.com"
                    >
                    <div class="form-help">Adresse email professionnelle</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Nouveau Mot de Passe
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input"
                        placeholder="Laissez vide pour ne pas modifier"
                    >
                    <div class="form-help">Minimum 8 caractères (laissez vide pour conserver l'actuel)</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Téléphone
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        value="{{ $agent->phone ?? '' }}" 
                        class="form-input"
                        placeholder="+33 1 23 45 67 89"
                    >
                    <div class="form-help">Numéro de téléphone professionnel</div>
                </div>
            </div>
        </div>
        
        <!-- Role Assignment -->
        <div class="section-header">
            <h2 class="section-title">
                <div class="section-icon">
                    <i data-lucide="shield" style="width: 16px; height: 16px;"></i>
                </div>
                Assignation
            </h2>
        </div>
        
        <div class="form-content">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        Rôle <span class="required">*</span>
                    </label>
                    <select name="role" required class="form-select">
                        <option value="">Sélectionnez un rôle</option>
                        @php
                            $agentPivot = $agent->companies()->where('company_id', $company->id)->first();
                            $currentRole = $agentPivot ? $agentPivot->pivot->role : 'agent';
                        @endphp
                        <option value="agent" {{ $currentRole == 'agent' ? 'selected' : '' }}>
                            Agent
                        </option>
                        <option value="company_admin" {{ $currentRole == 'company_admin' ? 'selected' : '' }}>
                            Administrateur d'Entreprise
                        </option>
                    </select>
                    <div class="form-help">
                        Agent: Peut gérer les tickets et guichets<br>
                        Admin: Peut gérer toute l'entreprise
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Guichet Assigné
                    </label>
                    <select name="counter_id" class="form-select">
                        <option value="">Aucun guichet assigné</option>
                        @foreach($counters as $counter)
                        <option value="{{ $counter->id }}" 
                                {{ ($agentPivot && $agentPivot->pivot->counter_id == $counter->id) ? 'selected' : '' }}>
                            {{ $counter->name }} @if($counter->service) ({{ $counter->service->name }}) @endif
                        </option>
                        @endforeach
                    </select>
                    <div class="form-help">Optionnel: L'agent sera assigné à ce guichet par défaut</div>
                </div>
            </div>
        </div>
        
        <!-- Current Status -->
        <div class="section-header">
            <h2 class="section-title">
                <div class="section-icon">
                    <i data-lucide="activity" style="width: 16px; height: 16px;"></i>
                </div>
                Statut Actuel
            </h2>
        </div>
        
        <div class="form-content">
            <div class="status-grid">
                <div class="status-card">
                    <div class="status-label">Date de création</div>
                    <div class="status-value">{{ $agent->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="status-card">
                    <div class="status-label">Dernière modification</div>
                    <div class="status-value">{{ $agent->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="status-card">
                    <div class="status-label">Statut du compte</div>
                    <div class="status-badge">
                        <i data-lucide="check-circle" style="width: 12px; height: 12px;"></i>
                        Actif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="form-actions">
            <div class="actions-left">
                <a href="{{ route('company.admin.agents', $company) }}" class="btn btn-secondary">
                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                    Annuler
                </a>
                
                <button type="button" onclick="showDeleteModal()" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                    Supprimer l'Agent
                </button>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                Enregistrer les Modifications
            </button>
        </div>
    </form>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-icon">
                <i data-lucide="alert-triangle" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 class="modal-title">Supprimer l'agent</h3>
                <p class="modal-subtitle">Cette action est irréversible</p>
            </div>
        </div>
        
        <div class="modal-content">
            Êtes-vous sûr de vouloir supprimer l'agent <strong>{{ $agent->name }}</strong> ?
        </div>
        
        <div class="modal-actions">
            <button onclick="hideDeleteModal()" class="btn btn-secondary">
                Annuler
            </button>
            <form method="POST" action="{{ route('company.admin.agents.destroy', [$company, $agent]) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Form validation
    const form = document.querySelector('form');
    const passwordInput = document.querySelector('input[name="password"]');
    const emailInput = document.querySelector('input[name="email"]');
    const nameInput = document.querySelector('input[name="name"]');
    
    form.addEventListener('submit', function(e) {
        // Password validation
        if (passwordInput.value && passwordInput.value.length < 8) {
            e.preventDefault();
            showError('Le mot de passe doit contenir au moins 8 caractères');
            passwordInput.focus();
            return;
        }
        
        // Required fields validation
        if (!emailInput.value || !nameInput.value) {
            e.preventDefault();
            showError('Le nom et l\'email sont obligatoires');
            if (!nameInput.value) nameInput.focus();
            else emailInput.focus();
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            e.preventDefault();
            showError('Veuillez entrer une adresse email valide');
            emailInput.focus();
            return;
        }
    });
    
    // Real-time validation feedback
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = '#ef4444';
            } else if (this.value.trim()) {
                this.style.borderColor = '#10b981';
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.borderColor = '#3b82f6';
        });
    });
});

function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function showError(message) {
    // Create error toast
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ef4444;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        z-index: 2000;
        animation: slideInRight 0.3s ease-out;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection
