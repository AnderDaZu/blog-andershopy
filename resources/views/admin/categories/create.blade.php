<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Categorías',
            'url' => route('admin.categories.index')
        ],
        [
            'name' => 'Crear Categoría'
        ]
    ]">
    
    <form action="{{ route('admin.categories.store') }}" method="post" class="">
        @csrf
       
        <div class="mb-4"> 
            <div class="flex flex-col sm:flex-row sm:items-center mb-2">
                <x-label for="name" value="Nombre categoría" class="sm:w-1/3 text-base md:text-xl" />
                <x-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>
            <x-input-error for="name" class="flex justify-end" />
        </div>

        <div class="flex justify-end">
            <x-button>Crear categoría</x-button>
        </div>
    </form>

</x-admin-layout>