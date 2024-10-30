<header class="bg-purple-300 text-white">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo de la clínica -->
        <div class="flex items-center">
            <img src="http://localhost/Gestion_Clinica/app/views/media/image0_0-removebg-preview.png" alt="Logo" class="w-16 h-16 mr-3">
            <span class="text-2xl font-bold">Clinica Pacoren</span>
        </div>

        <!-- Navegación -->
        <nav class="hidden md:flex space-x-6">
            <a href="index.php" class="hover:text-purple-800">Inicio</a>
            <a href="servicios.php" class="hover:text-purple-800">Servicios</a>
            <a href="contacto.php" class="hover:text-purple-800">Contacto</a>
            <a href="about.php" class="hover:text-purple-800">Sobre Nosotros</a>
        </nav>

        <!-- Botones de Login y Registrarse -->
        <div class="flex space-x-4">
            <a href="app\views\login.php" class="bg-white text-purple-700 font-semibold py-2 px-4 rounded-lg hover:bg-purple-100">Iniciar sesión</a>
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
            <a href="index.php" class="block text-white hover:bg-purple-600 py-2 rounded">Inicio</a>
            <a href="servicios.php" class="block text-white hover:bg-purple-600 py-2 rounded">Servicios</a>
            <a href="contacto.php" class="block text-white hover:bg-purple-600 py-2 rounded">Contacto</a>
            <a href="about.php" class="block text-white hover:bg-purple-600 py-2 rounded">Sobre Nosotros</a>
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
