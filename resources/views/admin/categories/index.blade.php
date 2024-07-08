<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Categorías',
        ]
    ]">

    <div class="flex justify-end mb-2">
        {{-- <a href="{{ route('admin.categories.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Agregar Categoría
        </a> --}}
        <x-cstm_button_create href="{{ route('admin.categories.create') }}">
            Agregar Categoría
        </x-cstm_button_create>
    </div>

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
                @foreach ($categories as $category)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $category->id }}
                        </th>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                            {{ $category->name }}
                        </td>

                        {{-- <td class="px-2 py-4" width="15">
                            <a href="{{ route('admin.categories.show', $category) }}" class="font-medium text-gray-600 dark:text-gray-300"><i class="fa-regular fa-eye"></i></a>
                        </td> --}}
                        <td class="px-2 py-4 text-center" width="15">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td class="pl-2 pr-6 py-4 text-center" width="15">
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" id="formDelete-{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.preventDefault(); deleteCategory({{ $category }})" class="font-medium text-red-600 dark:text-red-500"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        {{ $categories->links() }}
    </div>

    @push('js')
        <script>
            function deleteCategory(category){
                // console.log(`Hizo clic...`, category.name);
                Swal.fire({
                        title: '¿Deseas borrar esta categoría? ' + category.name,
                        text: "No podras revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, borrar',
                        cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formDelete-' + category.id).submit();
                    }    
                })
            }
        </script>
    @endpush

</x-admin-layout>