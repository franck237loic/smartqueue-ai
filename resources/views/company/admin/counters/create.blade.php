@extends('layouts.enterprise-layout')

@section('title', 'Créer un Guichet')

@section('content')
<style>
/* Counter Create Styles */
.counter-create-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb a:hover {
    color: #2563eb;
}

.breadcrumb-separator {
    color: #d1d5db;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.page-description {
    color: #6b7280;
    font-size: 1rem;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    background: #3b82f6;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.section-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
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

.form-input.error {
    border-color: #ef4444;
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
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
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
    border: none;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 2px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

.status-toggle {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toggle-switch {
    position: relative;
    width: 48px;
    height: 24px;
    background: #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.2s;
}

.toggle-switch.active {
    background: #3b82f6;
}

.toggle-slider {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: transform 0.2s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.toggle-switch.active .toggle-slider {
    transform: translateX(24px);
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
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>

<div class="counter-create-container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('company.admin.counters', $company) }}">Guichets</a>
        <span class="breadcrumb-separator">/</span>
        <span>Créer un guichet</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header fade-in-up">
        <h1 class="page-title">Créer un Nouveau Guichet</h1>
        <p class="page-description">Ajoutez un nouveau point de service pour votre entreprise</p>
        
        <!-- Status Badge -->
        <div style="margin-top: 1rem;">
            <div id="statusBadge" class="status-badge active">
                <i data-lucide="check-circle" style="width: 16px; height: 16px;"></i>
                <span id="statusText">Actif</span>
            </div>
        </div>
    </div>

    <form action="{{ route('company.admin.counters.store', $company) }}" method="POST">
        @csrf
        
        <!-- Basic Information Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-lucide="settings" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Informations de Base</h2>
                        <p class="section-description">Données essentielles du guichet</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Nom du Guichet<span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="form-input"
                               placeholder="Ex: Guichet Principal">
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Numéro d'Identification
                        </label>
                        <input type="text" 
                               name="number" 
                               value="{{ old('number') }}"
                               class="form-input"
                               placeholder="Ex: 1, A, G1">
                        <span class="form-help">Numéro ou lettre pour identifier le guichet</span>
                        @error('number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Service Associé
                        </label>
                        <select name="service_id" class="form-select">
                            <option value="">Aucun service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="form-help">Le service rattaché à ce guichet</span>
                        @error('service_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Emplacement
                        </label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location') }}"
                               class="form-input"
                               placeholder="Ex: Étage 1, Salle A">
                        <span class="form-help">Où se trouve physiquement ce guichet</span>
                        @error('location')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.2s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon" style="background: #8b5cf6;">
                        <i data-lucide="info" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Informations Complémentaires</h2>
                        <p class="section-description">Détails additionnels du guichet</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">
                            Description
                        </label>
                        <textarea name="description" 
                                  rows="4"
                                  class="form-textarea"
                                  placeholder="Décrivez la fonction de ce guichet...">{{ old('description') }}</textarea>
                        <span class="form-help">Informations supplémentaires sur le guichet</span>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Capacité Maximale
                        </label>
                        <input type="number" 
                               name="capacity" 
                               value="{{ old('capacity') }}"
                               min="1"
                               class="form-input"
                               placeholder="Ex: 50">
                        <span class="form-help">Nombre maximum de personnes simultanées</span>
                        @error('capacity')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Temps Moyen de Service
                        </label>
                        <input type="number" 
                               name="average_service_time" 
                               value="{{ old('average_service_time') }}"
                               min="1"
                               class="form-input"
                               placeholder="Ex: 10">
                        <span class="form-help">Temps moyen en minutes par client</span>
                        @error('average_service_time')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Section -->
        <div class="form-card fade-in-up" style="animation-delay: 0.3s;">
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon" style="background: #10b981;">
                        <i data-lucide="toggle-left" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Statut du Guichet</h2>
                        <p class="section-description">Définissez l'état de fonctionnement</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Statut Actif
                        </label>
                        <div class="status-toggle">
                            <div class="toggle-switch active" data-toggle="is_active">
                                <div class="toggle-slider"></div>
                            </div>
                            <span>Guichet actif et disponible</span>
                        </div>
                        <input type="hidden" name="is_active" value="1" id="is_active_input">
                        <span class="form-help">Désactivez si le guichet est temporairement indisponible</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Priorité
                        </label>
                        <select name="priority" class="form-select">
                            <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normale</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Basse</option>
                        </select>
                        <span class="form-help">Priorité de traitement des tickets</span>
                        @error('priority')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-card fade-in-up" style="animation-delay: 0.4s;">
            <div class="form-actions">
                <a href="{{ route('company.admin.counters', $company) }}" class="btn btn-secondary">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="plus-circle" style="width: 16px; height: 16px;"></i>
                    Créer le Guichet
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Form validation
    const form = document.querySelector('form');
    const nameInput = document.querySelector('input[name="name"]');
    const capacityInput = document.querySelector('input[name="capacity"]');
    const serviceTimeInput = document.querySelector('input[name="average_service_time"]');
    
    // Toggle switch functionality
    const toggleSwitches = document.querySelectorAll('[data-toggle]');
    
    toggleSwitches.forEach(toggleSwitch => {
        const toggleType = toggleSwitch.dataset.toggle;
        const hiddenInput = document.getElementById(toggleType + '_input');
        
        if (hiddenInput) {
            toggleSwitch.addEventListener('click', function() {
                this.classList.toggle('active');
                const isActive = this.classList.contains('active');
                hiddenInput.value = isActive ? '1' : '0';
                
                // Update text in form
                const statusText = this.parentElement.querySelector('span');
                if (statusText) {
                    if (toggleType === 'is_active') {
                        statusText.textContent = isActive ? 'Guichet actif et disponible' : 'Guichet inactif et indisponible';
                    }
                }
                
                // Update header status badge
                if (toggleType === 'is_active') {
                    const statusBadge = document.getElementById('statusBadge');
                    const statusTextHeader = document.getElementById('statusText');
                    
                    if (statusBadge && statusTextHeader) {
                        // Update badge class
                        statusBadge.className = 'status-badge ' + (isActive ? 'active' : 'inactive');
                        
                        // Update badge text
                        statusTextHeader.textContent = isActive ? 'Actif' : 'Inactif';
                        
                        // Update badge icon
                        const icon = statusBadge.querySelector('i');
                        if (icon) {
                            icon.setAttribute('data-lucide', isActive ? 'check-circle' : 'x-circle');
                            // Re-initialize Lucide icons
                            lucide.createIcons();
                        }
                    }
                }
            });
        }
    });
    
    // Real-time validation
    nameInput.addEventListener('input', function() {
        if (this.value.trim().length < 2) {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });
    
    capacityInput.addEventListener('input', function() {
        if (this.value && (this.value < 1 || this.value > 9999)) {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });
    
    serviceTimeInput.addEventListener('input', function() {
        if (this.value && (this.value < 1 || this.value > 480)) {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate required fields
        const requiredInputs = form.querySelectorAll('[required]');
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('error');
                isValid = false;
            } else {
                input.classList.remove('error');
            }
        });
        
        // Validate name length
        if (nameInput.value.trim().length < 2) {
            nameInput.classList.add('error');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            showToast('Veuillez corriger les erreurs dans le formulaire', 'error');
        }
    });
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: ${type === 'error' ? '#ef4444' : '#10b981'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Add slide animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
