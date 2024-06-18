<x-admin-layout>
    
    <div class="flex flex-col sm:flex-row sm:justify-between items-center mb-4">
        <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase mb-2 sm:mb-0">Editar permiso</h1>
        <x-cstm_button_create href="{{ route('admin.permissions.create') }}">
            Agregar Permiso
        </x-cstm_button_create>
    </div>

    <div class="bg-white shadow-md rounded-md p-6 mt-4">
        <form action="{{ route('admin.permissions.update', $permission) }}" method="post">
        
            @csrf
            @method('PUT')

            <x-label class="mb-2">Nombre del permiso</x-label>    
            <x-input name="name" :value="old('name', $permission->name)" type="text" class="w-full" placeholder="Ingrese nombre del permiso" />
            <x-input-error for="name" class="mt-2" />

            <div class="flex sm:justify-end mt-4">
                <x-danger-button onclick="deletePermission()">Eliminar Permiso</x-danger-button>
                <x-button class="ml-2">Actualizar Permiso</x-button>
            </div>

        </form>
    </div>

    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="post" id="formDelete">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $permission->id }}">
    </form>

    @push('js')
        <script>
            function deletePermission(){
                Swal.fire({
                    title: '¿Deseas borrar este permiso?',
                    text: "No podras revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formDelete').submit();
                    }    
                })
            }
        </script>
    @endpush
</x-admin-layout>