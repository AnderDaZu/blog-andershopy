<x-admin-layout>
    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase">Crear nuevo permiso</h1>

    <div class="bg-white shadow-md rounded-md p-6 mt-4">
        <form action="{{ route('admin.permissions.store') }}" method="post">
        
            @csrf

            <x-label class="mb-2">Nombre del permiso</x-label>    
            <x-input name="name" :value="old('name')" type="text" class="w-full" placeholder="Ingrese nombre del permiso" />
            <x-input-error for="name" class="mt-2" />

            <div class="flex sm:justify-end mt-4">
                <x-button>crear Permiso</x-button>
            </div>

        </form>
    </div>
</x-admin-layout>