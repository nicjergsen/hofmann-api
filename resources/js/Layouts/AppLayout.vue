<template>
    <div class="min-h-screen flex flex-col">
      <!-- Barra de navegación -->
      <nav class="bg-gray-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-2">
          <div class="flex justify-between items-center">
            <div class="flex-shrink-0">
              <span class="font-bold text-xl">Hofmann API</span>
            </div>
            <div class="hidden md:flex">
              
            </div>
          </div>
        </div>
      </nav>
  
      <!-- Contenido principal -->
      <main class="flex-1">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot></slot>
        </div>
      </main>
  
      <!-- Pie de página -->
      <footer class="bg-gray-800 text-white text-center py-4">
        <div class="max-w-7xl mx-auto">
          &copy; {{ new Date().getFullYear() }} Nicolás Fernández - Laravel Dev
        </div>
      </footer>
    </div>
</template>
  
<script>
export default {
name: 'AppLayout',
}
</script>