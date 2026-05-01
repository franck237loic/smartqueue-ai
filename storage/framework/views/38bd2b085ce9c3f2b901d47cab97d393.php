<?php $__env->startSection('title', 'Sélectionner votre entreprise - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-hero flex items-center justify-center">
    <div class="container">
        <div class="login-card animate-fade-in">
            <!-- Logo et Titre -->
            <div class="logo">
                <h1>SmartQueue AI</h1>
                <p>Sélectionnez votre entreprise</p>
            </div>

            <!-- Messages d'erreur -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- Liste des entreprises -->
            <div class="form-group">
                <label class="form-label">Vos entreprises</label>
                
                <?php if($companies->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-primary-gold transition-all cursor-pointer company-card" onclick="selectCompany(<?php echo e($company->id); ?>)">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-primary rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-lg"><?php echo e(substr($company->name, 0, 2)); ?></span>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900"><?php echo e($company->name); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo e($company->address); ?></p>
                                        <p class="text-xs text-gray-400">
                                            Rôle: <span class="font-medium text-primary-gold"><?php echo e($user->companyRole($company)); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <input type="hidden" id="selectedCompanyId" name="company_id" value="">
                <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aucune entreprise associée à votre compte.</p>
                        <a href="<?php echo e(route('logout')); ?>" class="btn btn-primary mt-4">
                            Se déconnecter
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bouton de validation -->
            <?php if($companies->count() > 0): ?>
                <button type="submit" form="selectCompanyForm" class="btn btn-primary">
                    Accéder à l'entreprise
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<form id="selectCompanyForm" method="POST" action="#" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="company_id" id="formCompanyId">
</form>

<script>
// Sélection d'entreprise
function selectCompany(companyId) {
    const form = document.getElementById('selectCompanyForm');
    const input = document.getElementById('formCompanyId');
    
    input.value = companyId;
    
    // Mettre en évidence la carte sélectionnée
    document.querySelectorAll('.company-card').forEach(card => {
        card.classList.remove('ring-2', 'ring-primary-gold');
    });
    
    event.currentTarget.classList.add('ring-2', 'ring-primary-gold');
    
    // Construire l'URL correcte
    form.action = `/switch-company/${companyId}`;
    
    // Soumettre le formulaire
    form.submit();
}

// Animation au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.company-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-fade-in');
    });
});
</script>

<style>
/* Styles spécifiques pour cette page */
.company-card {
    transition: all 0.3s ease;
}

.company-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.ring-2 {
    border-width: 2px;
}

.ring-primary-gold {
    border-color: var(--primary-gold);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
}

.animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

.text-xs {
    font-size: 0.75rem;
}

.text-sm {
    font-size: 0.875rem;
}

.text-lg {
    font-size: 1.125rem;
}

.w-12 {
    width: 3rem;
}

.h-12 {
    height: 3rem;
}

.object-cover {
    object-fit: cover;
}

.py-8 {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.mt-4 {
    margin-top: 1rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\auth\select-company.blade.php ENDPATH**/ ?>