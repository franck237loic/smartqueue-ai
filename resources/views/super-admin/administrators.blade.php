@extends('layouts.super-admin')

@section('title', 'Super Admin - Administrateurs')

@section('content')
<div class="administrators-container">
    <!-- Header Section -->
    <div class="administrators-header">
        <div class="header-content">
            <h1 class="page-title">Gestion des Administrateurs</h1>
            <p class="page-subtitle">{{ $administrators->total() }} administrateurs système</p>
        </div>
        <div class="header-right">
            <a href="{{ route('super_admin.administrators.create') }}" class="btn-create">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nouvel administrateur
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <div class="search-input-wrapper">
                    <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Rechercher un administrateur..." value="{{ request('search') }}" class="search-input">
                </div>
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendu</option>
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

    <!-- Administrators Grid -->
    <div class="administrators-grid">
        @forelse($administrators as $administrator)
        <div class="administrator-card">
            <div class="administrator-header">
                <div class="administrator-avatar">
                    <span>{{ substr($administrator->name, 0, 2) }}</span>
                    <div class="status-indicator {{ $administrator->status === 'active' ? 'active' : ($administrator->status === 'suspended' ? 'suspended' : 'inactive') }}"></div>
                </div>
                <div class="administrator-info">
                    <h3 class="administrator-name">{{ $administrator->name }}</h3>
                    <p class="administrator-email">{{ $administrator->email }}</p>
                </div>
                <div class="administrator-badges">
                    <span class="badge role-badge super-admin">
                        Super Admin
                    </span>
                    <span class="badge status-badge {{ $administrator->status === 'active' ? 'active' : ($administrator->status === 'suspended' ? 'suspended' : 'inactive') }}">
                        {{ $administrator->status }}
                    </span>
                </div>
            </div>

            <div class="administrator-details">
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Dernière connexion: {{ $administrator->last_login_at ? $administrator->last_login_at->diffForHumans() : 'Jamais' }}</span>
                </div>
                <div class="detail-item">
                    <svg class="detail-icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Créé le: {{ $administrator->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="administrator-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $administrator->companies_managed ?? 0 }}</div>
                    <div class="stat-label">Entreprises gérées</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $administrator->actions_count ?? 0 }}</div>
                    <div class="stat-label">Actions effectuées</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $administrator->login_count ?? 0 }}</div>
                    <div class="stat-label">Connexions</div>
                </div>
            </div>

            <div class="administrator-permissions">
                <h4 class="permissions-title">Permissions</h4>
                <div class="permissions-grid">
                    <div class="permission-item {{ $administrator->can('manage_companies') ? 'granted' : 'denied' }}">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Gérer entreprises</span>
                    </div>
                    <div class="permission-item {{ $administrator->can('manage_users') ? 'granted' : 'denied' }}">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Gérer utilisateurs</span>
                    </div>
                    <div class="permission-item {{ $administrator->can('view_statistics') ? 'granted' : 'denied' }}">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Voir statistiques</span>
                    </div>
                    <div class="permission-item {{ $administrator->can('manage_settings') ? 'granted' : 'denied' }}">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Paramètres système</span>
                    </div>
                </div>
            </div>

            <div class="administrator-actions">
                @if($administrator->id !== auth()->id())
                <button onclick="confirmAction('suspend', {{ $administrator->id }})" class="action-btn suspend-btn" title="Suspendre">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
                <button onclick="confirmAction('reset_password', {{ $administrator->id }})" class="action-btn reset-btn" title="Réinitialiser mot de passe">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2h2l5.257-5.257A6 6 0 0121 9z"/>
                    </svg>
                </button>
                <button onclick="confirmAction('delete', {{ $administrator->id }})" class="action-btn delete-btn" title="Supprimer">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                @else
                <div class="current-user-badge">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Vous</span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="empty-title">Aucun administrateur trouvé</h3>
            <p class="empty-description">Commencez par ajouter un nouvel administrateur système</p>
            <a href="{{ route('super_admin.administrators.create') }}" class="btn-create">
                <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un administrateur
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $administrators->links() }}
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Confirmation d'action</h3>
            <button onclick="closeModal()" class="modal-close">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p id="modalMessage"></p>
        </div>
        <div class="modal-footer">
            <button onclick="closeModal()" class="btn-cancel">Annuler</button>
            <button id="modalConfirmBtn" class="btn-danger">Confirmer</button>
        </div>
    </div>
</div>

<script>
function confirmAction(action, adminId) {
    const modal = document.getElementById('confirmModal');
    const message = document.getElementById('modalMessage');
    const confirmBtn = document.getElementById('modalConfirmBtn');
    
    let actionText = '';
    let actionUrl = '';
    
    switch(action) {
        case 'suspend':
            actionText = 'Voulez-vous vraiment suspendre cet administrateur ?';
            actionUrl = `/super-admin/administrators/${adminId}/suspend`;
            break;
        case 'reset_password':
            actionText = 'Voulez-vous vraiment réinitialiser le mot de passe de cet administrateur ?';
            actionUrl = `/super-admin/administrators/${adminId}/reset-password`;
            break;
        case 'delete':
            actionText = 'Voulez-vous vraiment supprimer cet administrateur ? Cette action est irréversible.';
            actionUrl = `/super-admin/administrators/${adminId}`;
            confirmBtn.className = 'btn-danger';
            break;
    }
    
    message.textContent = actionText;
    modal.style.display = 'flex';
    
    confirmBtn.onclick = function() {
        fetch(actionUrl, {
            method: action === 'delete' ? 'DELETE' : 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    };
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
}
</script>

<style>
.administrators-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.administrators-header {
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

.header-content {
    flex: 1;
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

.header-right {
    display: flex;
    align-items: center;
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
    border: 1px solid var(--gray-200);
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

/* Administrators Grid */
.administrators-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.administrator-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.administrator-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: var(--primary);
}

.administrator-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.administrator-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
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

.administrator-info {
    flex: 1;
}

.administrator-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.administrator-email {
    font-size: 0.8rem;
    color: var(--gray-500);
    font-family: monospace;
}

.administrator-badges {
    display: flex;
    gap: 0.5rem;
    flex-direction: column;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: capitalize;
    width: fit-content;
}

.badge.role-badge.super-admin {
    background: var(--error);
    color: white;
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

.administrator-details {
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

.administrator-stats {
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

.administrator-permissions {
    margin-bottom: 1rem;
}

.permissions-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
}

.permissions-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.5rem;
}

.permission-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
}

.permission-item.granted {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.permission-item.denied {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
}

.administrator-actions {
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
}

.action-btn:hover {
    transform: translateY(-2px);
}

.suspend-btn {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.suspend-btn:hover {
    background: var(--warning);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.reset-btn {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

.reset-btn:hover {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.delete-btn {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error);
}

.delete-btn:hover {
    background: var(--error);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.current-user-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
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

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: var(--gray-100);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: var(--gray-200);
}

.modal-body {
    margin-bottom: 2rem;
}

.modal-body p {
    color: var(--gray-600);
    line-height: 1.6;
}

.modal-footer {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--gray-50);
}

.btn-danger {
    padding: 0.75rem 1.5rem;
    background: var(--error);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
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
    .administrators-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .filter-group {
        min-width: auto;
    }
    
    .administrators-grid {
        grid-template-columns: 1fr;
    }
    
    .administrator-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .administrator-badges {
        flex-direction: row;
        justify-content: center;
    }
    
    .administrator-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-content {
        margin: 1rem;
        padding: 1.5rem;
    }
}
</style>
@endsection
