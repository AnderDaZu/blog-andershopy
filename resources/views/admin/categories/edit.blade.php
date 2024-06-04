<x-admin-layout>
    
    <form action="{{ route('admin.categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <div class="flex flex-col sm:flex-row sm:items-center mb-2">
                <x-label for="name" value="Nombre categoría" class="sm:w-1/3 text-base md:text-xl" />
                <x-input class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
            </div>
            <x-input-error for="name" class="flex justify-end" />
        </div>

        <div class="flex justify-end">
            <x-danger-button onclick="deleteCategory()">Eliminar categoría</x-danger-button>
            <x-button class="ml-2">Actualizar categoría</x-button>
        </div>
    </form>

    <form action="{{ route('admin.categories.destroy', $category) }}" method="post" id="formDelete">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $category->id }}">
    </form>

    @push('js')
        <script>
            function deleteCategory(){
                Swal.fire({
                    title: '¿Deseas borrar esta categoría?',
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