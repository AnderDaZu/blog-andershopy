<x-admin-layout>
    <h1 class="text-base sm:text-lg md:text-xl uppercase font-bold mb-4">Lista de Roles</h1>

    <div class="flex justify-end mb-4">
        <x-cstm_button_create href="{{ route('admin.roles.create') }}">
            Agregar Rol
        </x-cstm_button_create>
    </div>
</x-admin-layout>