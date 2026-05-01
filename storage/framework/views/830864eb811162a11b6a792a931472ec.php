<?php $__env->startSection('title', 'Gestion des Agents - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-dark-800 rounded-xl p-6 card-shadow">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">Gestion des Agents</h1>
                <p class="text-dark-600">
                    Gérez les agents de l'entreprise <?php echo e($company->name); ?>

                </p>
            </div>
            <a href="<?php echo e(route('company.admin.agents.create', $company)); ?>" class="px-6 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium shadow-lg shadow-brand-600/30 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvel Agent
            </a>
        </div>
    </div>

    <!-- Agents List -->
    <div class="bg-dark-800 rounded-xl card-shadow overflow-hidden">
        <div class="p-6 border-b border-dark-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-white">Agents (<?php echo e($agents->count()); ?>)</h2>
                
                <!-- Search -->
                <div class="relative">
                    <input type="text" id="searchAgents" placeholder="Rechercher un agent..." 
                           class="pl-10 pr-4 py-2 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-dark-700">
            <?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 hover:bg-dark-700/50 transition agent-row" data-name="<?php echo e(strtolower($agent->name)); ?>">
                <div class="flex items-center justify-between">
                    <!-- Agent Info -->
                    <div class="flex items-center gap-4">
                        <!-- Avatar -->
                        <div class="w-12 h-12 bg-brand-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-brand-500 font-bold text-lg">
                                <?php echo e(substr($agent->name, 0, 2)); ?>

                            </span>
                        </div>
                        
                        <!-- Details -->
                        <div>
                            <h3 class="font-medium text-white"><?php echo e($agent->name); ?></h3>
                            <p class="text-sm text-dark-600"><?php echo e($agent->email); ?></p>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="text-xs px-2 py-1 rounded-full bg-green-500/20 text-green-400">
                                    Actif
                                </span>
                                <?php if($agent->pivot->counter_id): ?>
                                <?php
                                    $counter = \App\Models\Counter::find($agent->pivot->counter_id);
                                ?>
                                <?php if($counter): ?>
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-500/20 text-blue-400">
                                    <?php echo e($counter->name); ?>

                                </span>
                                <?php else: ?>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-500/20 text-gray-400">
                                    Guichet supprimé
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <!-- View Details -->
                        <button onclick="showAgentDetails(<?php echo e($agent->id); ?>)" 
                                class="p-2 text-dark-400 hover:text-white hover:bg-dark-600 rounded-lg transition" 
                                title="Voir les détails">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        
                        <!-- Edit -->
                        <a href="<?php echo e(route('company.admin.agents.edit', [$company, $agent])); ?>" 
                           class="p-2 text-blue-400 hover:text-blue-300 hover:bg-dark-600 rounded-lg transition" 
                           title="Modifier l'agent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </a>
                        
                        <!-- Delete -->
                        <button onclick="confirmDeleteAgent(<?php echo e($agent->id); ?>, '<?php echo e($agent->name); ?>')" 
                                class="p-2 text-red-400 hover:text-red-300 hover:bg-dark-600 rounded-lg transition" 
                                title="Supprimer l'agent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Assigned Counters -->
                <?php if($agent->pivot->counter_id): ?>
                <div class="mt-4 pt-4 border-t border-dark-700">
                    <p class="text-sm text-dark-600 mb-2">Guichet assigné:</p>
                    <div class="flex flex-wrap gap-2">
                        <?php
                            $counter = App\Models\Counter::find($agent->pivot->counter_id);
                        ?>
                        <?php if($counter): ?>
                        <span class="px-3 py-1 bg-brand-500/20 text-brand-400 rounded-lg text-sm">
                            <?php echo e($counter->name); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-dark-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">Aucun agent</h3>
                <p class="text-dark-600 mb-6">
                    Aucun agent n'a été ajouté à cette entreprise pour le moment.
                </p>
                <a href="<?php echo e(route('company.admin.agents.create', $company)); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer le premier agent
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-dark-800 rounded-xl p-6 max-w-md w-full card-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.932-2.5L13.068 4c-.57-.833-1.392-1.5-2.932-1.5H4.864c-1.54 0-2.362.667-2.932 1.5L2.068 16.5c-.57.833-.608 2.5.932 2.5h13.856c1.54 0 2.362-.667 2.932-1.5l1.068-11z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Supprimer l'agent</h3>
                    <p class="text-dark-600">Cette action est irréversible</p>
                </div>
            </div>
            
            <p class="text-dark-600 mb-6">
                Êtes-vous sûr de vouloir supprimer l'agent <span id="deleteAgentName" class="font-medium text-white"></span> ?
            </p>
            
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-dark-700 text-white rounded-lg hover:bg-dark-600 font-medium">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Agent Details Modal -->
<div id="detailsModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-dark-800 rounded-xl p-6 max-w-2xl w-full card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Détails de l'agent</h3>
                <button onclick="closeDetailsModal()" class="text-dark-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div id="agentDetails" class="space-y-4">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchAgents').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.agent-row');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        if (name.includes(searchTerm)) {
            row.style.display = 'block';
        } else {
            row.style.display = 'none';
        }
    });
});

// Delete confirmation
function confirmDeleteAgent(agentId, agentName) {
    document.getElementById('deleteAgentName').textContent = agentName;
    document.getElementById('deleteForm').action = `/company/<?php echo e($company->id); ?>/admin/agents/${agentId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Agent details
function showAgentDetails(agentId) {
    fetch(`/company/<?php echo e($company->id); ?>/admin/agents/${agentId}/details`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            
            document.getElementById('agentDetails').innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-white mb-4">Informations personnelles</h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-dark-600">Nom complet</p>
                                <p class="text-white font-medium">${data.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Email</p>
                                <p class="text-white font-medium">${data.email}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Téléphone</p>
                                <p class="text-white font-medium">${data.phone}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Rôle</p>
                                <p class="text-white font-medium">${data.pivot_role}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Statut</p>
                                <p class="text-white font-medium">${data.status}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Date de création</p>
                                <p class="text-white font-medium">${new Date(data.created_at).toLocaleDateString('fr-FR')}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-white mb-4">Assignations</h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-dark-600">Entreprise</p>
                                <p class="text-white font-medium">${data.company.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-600">Guichets assignés</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    ${data.assigned_counters.length > 0 
                                        ? data.assigned_counters.map(counter => 
                                            `<span class="px-3 py-1 bg-brand-500/20 text-brand-400 rounded-lg text-sm">${counter.name} ${counter.service ? `(${counter.service.name})` : ''}</span>`
                                        ).join('')
                                        : '<span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-lg text-sm">Non assigné</span>'
                                    }
                                </div>
                            </div>
                            ${data.assigned_counters.length > 0 ? `
                                <div>
                                    <p class="text-sm text-dark-600">Détails du guichet</p>
                                    <div class="mt-2 space-y-2">
                                        ${data.assigned_counters.map(counter => `
                                            <div class="bg-dark-700/50 p-3 rounded-lg">
                                                <p class="text-white font-medium">${counter.name}</p>
                                                ${counter.service ? `<p class="text-sm text-dark-600">Service: ${counter.service.name}</p>` : ''}
                                                <p class="text-sm text-dark-600">Localisation: ${counter.location || 'Non spécifiée'}</p>
                                                <p class="text-sm text-dark-600">Statut: ${counter.status === 'open' ? 'Ouvert' : 'Fermé'}</p>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('detailsModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('agentDetails').innerHTML = `
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.932-2.5L13.068 4c-.57-.833-1.392-1.5-2.932-1.5H4.864c-1.54 0-2.362.667-2.932 1.5L2.068 16.5c-.57.833-.608 2.5.932 2.5h13.856c1.54 0 2.362-.667 2.932-1.5l1.068-11z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Erreur de chargement</h3>
                    <p class="text-dark-600">${error.message}</p>
                </div>
            `;
            document.getElementById('detailsModal').classList.remove('hidden');
        });
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\agents.blade.php ENDPATH**/ ?>