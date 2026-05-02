@extends('layouts.enterprise-layout')

@section('title', 'Modifier Service - ' . $service->name)

@section('content')
<!-- Enterprise Service Edit -->
<style>
    /* Service Edit Page Specific Styles */
    .service-edit-container {
        max-width: 800px;
        margin: 0 auto;
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
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        margin-bottom: var(--space-4);
    }
    
    .breadcrumb-link {
        color: var(--neutral-600);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: color var(--transition-fast);
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .breadcrumb-link:hover {
        color: var(--primary-600);
    }
    
    .breadcrumb-separator {
        color: var(--neutral-400);
        font-size: 0.875rem;
    }
    
    .breadcrumb-current {
        color: var(--neutral-900);
        font-size: 0.875rem;
        font-weight: 600;
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
        margin-top: var(--space-2);
    }
    
    /* Form Section */
    .form-section {
        background: var(--neutral-100);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-2xl);
        padding: var(--space-8);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--neutral-700);
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .required {
        color: var(--error-600);
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        background: var(--neutral-50);
        border: 1px solid var(--neutral-300);
        border-radius: var(--radius-lg);
        padding: var(--space-3) var(--space-4);
        font-size: 0.875rem;
        color: var(--neutral-900);
        transition: all var(--transition-spring);
        width: 100%;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary-400);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        background: var(--neutral-100);
    }
    
    .form-input::placeholder,
    .form-textarea::placeholder {
        color: var(--neutral-500);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-error {
        color: var(--error-600);
        font-size: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .form-actions {
        display: flex;
        gap: var(--space-4);
        margin-top: var(--space-8);
        padding-top: var(--space-6);
        border-top: 1px solid var(--neutral-200);
    }
    
    .btn {
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius-xl);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all var(--transition-spring);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
        border: 1px solid;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        color: var(--neutral-100);
        border-color: transparent;
        box-shadow: var(--shadow-md);
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
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .btn-secondary {
        background: transparent;
        color: var(--neutral-700);
        border-color: var(--neutral-300);
    }
    
    .btn-secondary:hover {
        background: var(--neutral-50);
        border-color: var(--neutral-400);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    
    .btn-flex {
        flex: 1;
        justify-content: center;
    }
    
    /* Service Info Card */
    .service-info-card {
        background: var(--neutral-50);
        border: 1px solid var(--neutral-200);
        border-radius: var(--radius-xl);
        padding: var(--space-4);
        display: flex;
        align-items: center;
        gap: var(--space-4);
        margin-bottom: var(--space-6);
    }
    
    .service-icon {
        width: 56px;
        height: 56px;
        background: var(--gradient-primary);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-100);
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: var(--shadow-md);
    }
    
    .service-details {
        flex: 1;
    }
    
    .service-name {
        font-weight: 700;
        color: var(--neutral-900);
        font-size: 1.125rem;
        margin-bottom: var(--space-1);
    }
    
    .service-meta {
        color: var(--neutral-600);
        font-size: 0.875rem;
    }
    
    /* Animations */
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
        .service-edit-container {
            padding: var(--space-4);
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: var(--space-4);
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-flex {
            width: 100%;
        }
    }
</style>

<div class="service-edit-container">
    <!-- Page Header -->
    <div class="page-header animate-slide-up">
        <div class="breadcrumb">
            <a href="{{ route('company.admin.services', $company) }}" class="breadcrumb-link">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                Services
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $service->name }}</span>
        </div>
        
        <div class="page-title">
            <div class="page-icon">
                <i data-lucide="edit" style="width: 20px; height: 20px;"></i>
            </div>
            Modifier le Service
        </div>
        <p class="page-description">
            Mettez à jour les informations et paramètres du service "{{ $service->name }}".
        </p>
    </div>

    <!-- Service Info Card -->
    <div class="service-info-card animate-slide-up" style="animation-delay: 0.1s;">
        <div class="service-icon">
            {{ $service->prefix }}
        </div>
        <div class="service-details">
            <div class="service-name">{{ $service->name }}</div>
            <div class="service-meta">
                Préfixe: {{ $service->prefix }} • 
                Temps estimé: {{ $service->estimated_service_time }} min • 
                Statut: {{ $service->isActive() ? 'Actif' : 'Inactif' }}
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="form-section animate-slide-up" style="animation-delay: 0.2s;">
        <form action="{{ route('company.admin.services.update', [$company, $service]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        Nom du service <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $service->name) }}" 
                        required
                        class="form-input"
                        placeholder="Entrez le nom du service"
                    >
                    @error('name')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Préfixe <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="prefix" 
                        value="{{ old('prefix', $service->prefix) }}" 
                        required 
                        maxlength="10"
                        class="form-input"
                        placeholder="Ex: A, B, C..."
                    >
                    @error('prefix')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Temps estimé (minutes) <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="estimated_service_time" 
                        value="{{ old('estimated_service_time', $service->estimated_service_time) }}" 
                        required 
                        min="1"
                        class="form-input"
                        placeholder="Temps moyen de traitement"
                    >
                    @error('estimated_service_time')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Timeout absence (minutes) <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="missed_timeout" 
                        value="{{ old('missed_timeout', $service->missed_timeout) }}" 
                        required 
                        min="1"
                        class="form-input"
                        placeholder="Délai avant absence"
                    >
                    @error('missed_timeout')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top: var(--space-6);">
                <label class="form-label">
                    Description
                </label>
                <textarea 
                    name="description" 
                    rows="4"
                    class="form-textarea"
                    placeholder="Décrivez le service et son fonctionnement..."
                >{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-group" style="margin-top: var(--space-6);">
                <label class="form-label">
                    Statut <span class="required">*</span>
                </label>
                <select name="status" required class="form-select">
                    <option value="active" {{ $service->status === 'active' ? 'selected' : '' }}>
                        🟢 Actif
                    </option>
                    <option value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>
                        🔴 Inactif
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('company.admin.services', $company) }}" class="btn btn-secondary btn-flex">
                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary btn-flex">
                    <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Re-initialize Lucide icons
    lucide.createIcons();
    
    // Add form validation feedback
    const inputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = 'var(--error-400)';
            } else if (this.value.trim()) {
                this.style.borderColor = 'var(--success-400)';
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--primary-400)';
        });
    });
    
    // Add character counter for description
    const textarea = document.querySelector('textarea[name="description"]');
    if (textarea) {
        const counter = document.createElement('div');
        counter.style.cssText = 'font-size: 0.75rem; color: var(--neutral-500); margin-top: 4px;';
        textarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            const length = textarea.value.length;
            counter.textContent = `${length} caractères`;
            
            if (length > 500) {
                counter.style.color = 'var(--warning-600)';
            } else {
                counter.style.color = 'var(--neutral-500)';
            }
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    }
});
</script>
@endsection
