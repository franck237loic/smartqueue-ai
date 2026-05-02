@extends('layouts.enterprise-layout')

@section('title', 'Modifier Guichet - ' . $counter->name)

@section('content')
<style>
/* Counter Edit Styles */
.counter-edit-container {
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

.counter-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
}

.counter-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
}

.counter-details {
    text-align: left;
}

.counter-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.counter-meta {
    color: #6b7280;
    font-size: 0.875rem;
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

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
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

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.active {
    background: #10b981;
    color: white;
}

.status-badge.inactive {
    background: #6b7280;
    color: white;
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

.modal-content {
    margin-bottom: 1.5rem;
    color: #6b7280;
    line-height: 1.5;
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
    
    .counter-info {
        flex-direction: column;
        text-align: center;
    }
    
    .counter-details {
        text-align: center;
    }
}
</style>

<div class="counter-edit-container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('company.admin.counters', $company) }}">Guichets</a>
        <span class="breadcrumb-separator">/</span>
        <span>Modifier</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header fade-in-up">
        <h1 class="page-title">Modifier le Guichet</h1>
        <p class="page-description">Mettez à jour les informations de ce point de service</p>
        
        <!-- Counter Info -->
        <div class="counter-info">
            <div class="counter-avatar">
                {{ substr($counter->name, 0, 2) }}
            </div>
            <div class="counter-details">
                <div class="counter-name">{{ $counter->name }}</div>
                <div class="counter-meta">
                    Guichet #{{ $counter->number ?? 'N/A' }} 
                    @if($counter->service) • {{ $counter->service->name }} @endif
                </div>
                <div id="statusBadge" class="status-badge {{ $counter->is_active ? 'active' : 'inactive' }}">
                    <i data-lucide="{{ $counter->is_active ? 'check-circle' : 'x-circle' }}" style="width: 16px; height: 16px;"></i>
                    <span id="statusText">{{ $counter->is_active ? 'Actif' : 'Inactif' }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('company.admin.counters.update', [$company, $counter]) }}" method="POST">
        @csrf
        @method('PUT')
        
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
                               value="{{ old('name', $counter->name) }}" 
                               required
                               class="form-input">
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
                               value="{{ old('number', $counter->number) }}"
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
                                <option value="{{ $service->id }}" {{ old('service_id', $counter->service_id) == $service->id ? 'selected' : '' }}>
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
                               value="{{ old('location', $counter->location) }}"
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
                                  placeholder="Décrivez la fonction de ce guichet...">{{ old('description', $counter->description) }}</textarea>
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
                               value="{{ old('capacity', $counter->capacity) }}"
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
                               value="{{ old('average_service_time', $counter->average_service_time) }}"
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
                            <div class="toggle-switch {{ old('is_active', $counter->is_active) ? 'active' : '' }}" data-toggle="is_active">
                                <div class="toggle-slider"></div>
                            </div>
                            <span>Guichet {{ old('is_active', $counter->is_active) ? 'actif' : 'inactif' }} et disponible</span>
                        </div>
                        <input type="hidden" name="is_active" value="{{ old('is_active', $counter->is_active) ? '1' : '0' }}" id="is_active_input">
                        <span class="form-help">Désactivez si le guichet est temporairement indisponible</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Priorité
                        </label>
                        <select name="priority" class="form-select">
                            <option value="normal" {{ old('priority', $counter->priority ?? 'normal') == 'normal' ? 'selected' : '' }}>Normale</option>
                            <option value="high" {{ old('priority', $counter->priority ?? 'normal') == 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="low" {{ old('priority', $counter->priority ?? 'normal') == 'low' ? 'selected' : '' }}>Basse</option>
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
                <button type="button" onclick="showDeleteModal()" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                    Supprimer
                </button>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                    Mettre à Jour
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-icon">
                <i data-lucide="alert-triangle" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h3 class="modal-title">Supprimer le Guichet</h3>
            </div>
        </div>
        
        <div class="modal-content">
            Êtes-vous sûr de vouloir supprimer le guichet <strong>{{ $counter->name }}</strong> ? 
            Cette action est irréversible et supprimera définitivement toutes les données associées.
        </div>
        
        <div class="modal-actions">
            <button onclick="hideDeleteModal()" class="btn btn-secondary">
                Annuler
            </button>
            <form action="{{ route('company.admin.counters.destroy', [$company, $counter]) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
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

// Modal functions
function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        hideDeleteModal();
    }
});
</script>
@endsection
