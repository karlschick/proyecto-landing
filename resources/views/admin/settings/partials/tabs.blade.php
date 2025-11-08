<div class="border-b border-gray-200">
    <nav class="flex -mb-px overflow-x-auto">
        <button @click="activeTab = 'identity'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'identity' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Identidad de Marca
        </button>
        <button @click="activeTab = 'colors'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'colors' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Colores
        </button>
        <button @click="activeTab = 'social'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'social' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Redes Sociales
        </button>
        <button @click="activeTab = 'contact'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'contact' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Contacto
        </button>
        <button @click="activeTab = 'sections'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'sections' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Secciones
        </button>
        <button @click="activeTab = 'footer'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'footer' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            Footer
        </button>
        <button @click="activeTab = 'seo'"
                class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 transition"
                :class="activeTab === 'seo' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
            SEO
        </button>
        <button type="button"
                class="px-4 py-2 rounded-t-lg font-medium text-sm"
                :class="activeTab === 'navbar' ? 'bg-white text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600'"
                @click="activeTab = 'navbar'">
            Navegación
        </button>
    </nav>
</div>
