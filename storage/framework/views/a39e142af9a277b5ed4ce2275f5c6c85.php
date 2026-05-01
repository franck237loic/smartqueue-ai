<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage - <?php echo e($company->name); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta http-equiv="refresh" content="30">
    <style>
        @keyframes pulse-call {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .calling { animation: pulse-call 1s ease-in-out infinite; }
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen">
    <div class="bg-slate-800 border-b border-slate-700">
        <div class="px-8 py-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold"><?php echo e($company->name); ?></h1>
                <p class="text-slate-400 mt-1">File d'attente en temps reel</p>
            </div>
            <div class="text-right">
                <p class="text-4xl font-mono"><?php echo e(now()->format('H:i')); ?></p>
                <p class="text-slate-400"><?php echo e(now()->format('d/m/Y')); ?></p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-slate-300 mb-4 uppercase tracking-wide">Derniers Appels</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $calledTickets->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 calling">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-200 text-sm uppercase tracking-wide">Ticket</p>
                            <p class="text-5xl font-bold"><?php echo e($ticket->number); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-200 text-sm uppercase tracking-wide">Guichet</p>
                            <p class="text-3xl font-bold"><?php echo e($ticket->counter?->name ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full bg-slate-800 rounded-2xl p-12 text-center">
                    <p class="text-slate-400 text-xl">Aucun ticket en cours d'appel</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-slate-800 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-300 mb-4">Services Actifs</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between bg-slate-700 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold"><?php echo e($service->prefix); ?></span>
                            <span class="ml-4 font-medium"><?php echo e($service->name); ?></span>
                        </div>
                        <span class="text-slate-400"><?php echo e($service->waiting_tickets_count); ?> en attente</span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-300 mb-4">Instructions</h3>
                <ul class="space-y-3 text-slate-400">
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">1</span>
                        <span>Prenez un ticket au kiosque ou sur votre telephone</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">2</span>
                        <span>Attendez que votre numero s'affiche</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">3</span>
                        <span>Presentez-vous au guichet indique</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Real-time Script -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Audio System
        class AudioCaller {
            constructor() {
                this.synth = window.speechSynthesis;
            }

            speak(text) {
                if (!this.synth) return;
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'fr-FR';
                utterance.rate = 0.9;
                utterance.pitch = 1;
                this.synth.speak(utterance);
            }

            callTicket(number, counter) {
                const text = `Ticket ${number}, présentez-vous au ${counter}`;
                this.speak(text);
            }

            playBeep() {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 800;
                gain.gain.value = 0.3;
                osc.start();
                osc.stop(ctx.currentTime + 0.2);
            }
        }

        // Initialize Pusher Echo
        const pusher = new Pusher('<?php echo e(env('PUSHER_APP_KEY')); ?>', {
            cluster: '<?php echo e(env('PUSHER_APP_CLUSTER', 'eu')); ?>',
            wsHost: window.location.hostname,
            wsPort: 8080,
            wssPort: 8080,
            forceTLS: false,
            enabledTransports: ['ws', 'wss']
        });

        const channel = pusher.subscribe('company.<?php echo e($company->id); ?>');
        const audio = new AudioCaller();

        channel.bind('ticket.called', function(data) {
            console.log('Ticket called:', data);
            audio.playBeep();
            setTimeout(() => audio.callTicket(data.ticket.number, data.ticket.counter), 500);
            location.reload();
        });

        channel.bind('ticket.served', function(data) {
            console.log('Ticket served:', data);
            location.reload();
        });

        // Clock update
        setInterval(() => {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
        }, 1000);
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\public\display.blade.php ENDPATH**/ ?>