<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Roles',
        ]
    ]">
    <h1 class="text-base sm:text-lg md:text-xl uppercase font-bold mb-4">Lista de Roles</h1>

    <div class="flex justify-end mb-4">
        <x-cstm_button_create href="{{ route('admin.roles.create') }}">
            Agregar Rol
        </x-cstm_button_create>
    </div>

    @if ( count($roles) > 0 )
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" colspan="2" class="px-6 pl-2 pr-6">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $rol->id }}
                            </th>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $rol->name }}
                            </td>

                            {{-- <td class="px-2 py-4" width="15">
                                <a href="{{ route('admin.roles.show', $rol) }}" class="font-medium text-gray-600 dark:text-gray-300"><i class="fa-regular fa-eye"></i></a>
                            </td> --}}
                            <td class="px-2 py-4 text-center" width="15">
                                <a href="{{ route('admin.roles.edit', $rol) }}" class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                            <td class="pl-2 pr-6 py-4 text-center" width="15">
                                <form action="{{ route('admin.roles.destroy', $rol) }}" method="POST" id="formDelete-{{ $rol->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="event.preventDefault(); deleterol({{ $rol }})" class="font-medium text-red-600 dark:text-red-500"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- <div class="mt-2">
            {{ $roles->links() }}
        </div> --}}

        @push('js')
            <script>
                function deleterol(rol){
                    // console.log(`Hizo clic...`, rol.name);
                    Swal.fire({
                            title: '¿Deseas borrar esta categoría? ' + rol.name,
                            text: "No podras revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, borrar',
                            cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formDelete-' + rol.id).submit();
                        }    
                    })
                }
            </script>
        @endpush
    @else
        <div class="p-4 mb-4 text-md text-blue-800 rounded-md bg-blue-100">
            <span class="font-medium">Aún no hay roles registrados</span>
        </div>
    @endif

</x-admin-layout>