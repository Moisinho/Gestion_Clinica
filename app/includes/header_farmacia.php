<header class="bg-purple-300 text-white">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo de la clínica -->
        <div class="flex items-center">
            <img src="http://localhost/Gestion_Clinica/app/views/media/image0_0-removebg-preview.png" alt="Logo" class="w-16 h-16 mr-3">
            <span class="text-2xl font-bold">Clinica Pacoren</span>
        </div>
        <div class="flex justify-between">
            <!-- Navegación -->
            <nav class="hidden md:flex space-x-6 px-6">
                <a href="../../views/Farmaceutico/farmacia_inicio.php" class="hover:text-purple-800">Inicio</a>
            </nav>

            <div class="flex items-center space-x-4">
                <span class="text-white">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Usuario'); ?></span>
                <button onclick="window.location.href='configuracion.php'" class="text-white hover:text-secondary flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.836-1.372.068-3.166-1.065-2.572c-1.756.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Menú móvil -->
        <button id="menu-toggle" class="text-white md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Menú móvil expandido -->
    <div id="mobile-menu" class="md:hidden bg-purple-300 py-4 hidden">
        <nav class="space-y-2 px-6">
            <a href="../../views/Doctor/medico_inicio.php" class="block text-white hover:bg-purple-600 py-2 rounded">Inicio</a>
        </nav>
    </div>

    <!-- Script para el menú móvil -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</header>