<style>
    @keyframes logoSplash {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    .splash-logo-anim {
        animation: logoSplash 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes textSplash {
        0% {
            transform: translateY(20px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    .splash-text-anim {
        opacity: 0;
        animation: textSplash 0.8s ease-out 0.4s forwards;
    }
</style>

<div id="splash-screen" class="fixed inset-0 z-[9999] bg-gray-50 flex flex-col items-center justify-center transition-all duration-700 ease-in-out">
    <div class="relative flex flex-col items-center">
        <!-- Logo with soft glow -->
        <div class="relative">
            <div class="absolute inset-0 bg-blue-500 blur-2xl opacity-20 rounded-full animate-pulse scale-150"></div>
            <img src="{{ asset('img/LogoLab.png') }}" alt="Logo Lab" class="relative w-40 h-40 object-contain splash-logo-anim opacity-0.8">
        </div>
        
        <h2 class="mt-8 text-3xl font-bold text-gray-900 tracking-tight splash-text-anim">SIMALAB</h2>
        <p class="text-sm font-medium text-gray-500 mt-2 splash-text-anim" style="animation-delay: 0.6s;">Laboratorium Teknik Digital</p>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Check if splash has already been shown in this session
        if (!sessionStorage.getItem('splashShown')) {
            const splash = document.getElementById('splash-screen');
            // Disable scroll
            document.body.style.overflow = 'hidden';
            
            // Wait for animation, then fade out
            setTimeout(() => {
                splash.style.opacity = '0';
                splash.style.visibility = 'hidden';
                // Re-enable scroll
                document.body.style.overflow = '';
                
                // Remove from DOM
                setTimeout(() => {
                    splash.remove();
                }, 700);
                
                // Set flag so it doesn't show again in this session
                sessionStorage.setItem('splashShown', 'true');
            }, 2500); // 2.5 seconds total display time
        } else {
            // Remove splash screen immediately if already shown
            const splash = document.getElementById('splash-screen');
            if (splash) splash.remove();
        }
    });
</script>
