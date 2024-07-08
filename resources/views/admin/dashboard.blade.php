<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Inicio',
            'url' => route('admin.dashboard')
        ]
    ]">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 py-4 px-2 md:px-6 flex gap-4 justify-center items-center shadow-lg rounded-md">
            <h2 class="uppercase text-blue-600 text-sm sm:text-base md:text-lg lg:text-xl font-semibold">AnderShoppy Blog</h2>
        </div>

        <div class="bg-gray-50 py-4 px-2 md:px-6 flex gap-4 items-center shadow-lg rounded-md">
            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition shrink-0">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </button>

            <div>
                <span class="uppercase text-sm md:text-base lg:text-lg font-semibold">Bienvenido {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="mt-0 pt-0">
                    @csrf
                    <button class="hover:text-blue-500 text-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
    
</x-admin-layout>