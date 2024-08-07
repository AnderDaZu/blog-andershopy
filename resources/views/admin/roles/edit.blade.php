<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Roles',
            'url' => route('admin.roles.index')
        ],
        [
            'name' => $role->name
        ]
    ]">
    
    <div class="flex flex-col sm:flex-row sm:justify-between items-center mb-4">
        <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase mb-2 sm:mb-0">Editar rol</h1>
        <x-cstm_button_create href="{{ route('admin.roles.create') }}">
            Agregar Rol
        </x-cstm_button_create>
    </div>

    <div class="bg-white shadow-md rounded-md p-6 mt-4">
        <form action="{{ route('admin.roles.update', $role) }}" method="post">
        
            @csrf
            @method('PUT')

            <x-label class="mb-2">Nombre del rol</x-label>    
            <x-input name="name" :value="old('name', $role->name)" type="text" class="w-full" placeholder="Ingrese nombre del rol" />
            <x-input-error for="name" class="mt-2" />

            <div class="my-4">
                <ul>
                    @foreach ($permissions as $permission)
                        <li>
                            <label>
                                <x-checkbox
                                    name="permissions[]" 
                                    value="{{ $permission->id }}" 
                                    :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))"/>
                                {{ $permission->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex sm:justify-end mt-4">
                <x-danger-button onclick="deleteRol()">Eliminar rol</x-danger-button>
                <x-button class="ml-2">Actualizar Rol</x-button>
            </div>

        </form>
    </div>

    <form action="{{ route('admin.roles.destroy', $role) }}" method="post" id="formDelete">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $role->id }}">
    </form>

    @push('js')
        <script>
            function deleteRol(){
                Swal.fire({
                    title: '¿Deseas borrar este rol?',
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