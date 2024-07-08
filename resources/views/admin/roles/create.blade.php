<x-admin-layout>
    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase">Crear nuevo rol</h1>

    <div class="bg-white shadow-md rounded-md p-6 mt-4">
        <form action="{{ route('admin.roles.store') }}" method="post">
        
            @csrf

            <x-label class="mb-2">Nombre del rol</x-label>    
            <x-input name="name" :value="old('name')" type="text" class="w-full" placeholder="Ingrese nombre del rol" />
            <x-input-error for="name" class="mt-2" />
            
            <div class="my-4">
                <ul>
                    @foreach ($permissions as $permission)
                        <li>
                            <x-label class="mb-1">
                                <x-checkbox
                                    name="permissions[]" 
                                    value="{{ $permission->id }}"
                                    :checked="in_array($permission->id, old('permissions', []))" />
                                <span class="align-middle">{{ $permission->name }}</span>
                            </x-label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex sm:justify-end mt-4">
                <x-button>crear Rol</x-button>
            </div>


        </form>
    </div>
</x-admin-layout>